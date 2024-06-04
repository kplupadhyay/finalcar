<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\OwnerNotification;
use App\Models\Room;
use App\Models\BookedRoom;
use App\Models\Booking;
use App\Models\PaymentLog;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Constants\Status;
use App\Lib\GoogleAuthenticator;
use App\Models\Deposit;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $pageTitle                          = 'Dashboard';
        $todaysBookedRoomIds                = BookedRoom::active()->currentOwner('booking')->where('booked_for', todaysDate())->pluck('room_id')->toArray();
        $widget['today_booked']             = count($todaysBookedRoomIds);

        $widget['today_available']          = Room::currentOwner()->active()->whereNotIn('id', $todaysBookedRoomIds)->count();


        $widget['total']                    = Booking::currentOwner()->count();
        $widget['active']                   = Booking::currentOwner()->active()->count();
        $widget['pending_checkin']          = Booking::currentOwner()->active()->KeyNotGiven()->whereDate('check_in', '<=', now())->count();
        $widget['delayed_checkout']         = Booking::currentOwner()->delayedCheckout()->count();
        $widget['upcoming_checkin']         = Booking::currentOwner()->active()->whereDate('check_in', '>', now())->whereDate('check_in', '<=', now()->addDays(hotelSetting('upcoming_checkin_days')))->count();
        $widget['upcoming_checkout']        = Booking::currentOwner()->active()->whereDate('check_out', '>', now())->whereDate('check_out', '<=', now()->addDays(hotelSetting('upcoming_checkout_days')))->count();

        // Monthly Booking
        $report['months']                = collect([]);
        $report['booking_month_amount']  = collect([]);
        $report['booking_cancel_amount'] = collect([]);

        $bookingMonth  = BookedRoom::whereHas('booking', function ($query) {
            $query->currentOwner();
        })
            ->where('booked_for', '>=', now()->subYear())
            ->whereIn('status', [Status::ROOM_ACTIVE, Status::ROOM_CHECKOUT])
            ->selectRaw("SUM( CASE WHEN status IN(1,9) THEN fare END) as bookingAmount")
            ->selectRaw("DATE_FORMAT(booked_for,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')
            ->get();

        $bookingMonth->map(function ($bookingData) use ($report) {
            $report['months']->push($bookingData->months);
            $report['booking_month_amount']->push(getAmount($bookingData->bookingAmount));
        });

        $trxReport['date'] = collect([]);

        $plusTrx = PaymentLog::currentOwner()->where('type', 'BOOKING_PAYMENT_RECEIVED')->where('created_at', '>=', now()->subDays(30))
            ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
            ->orderBy('created_at')
            ->groupBy('date')
            ->get();

        $plusTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });

        $minusTrx = PaymentLog::currentOwner()->where('type', 'BOOKING_PAYMENT_RETURNED')->where('created_at', '>=', now()->subDays(30))
            ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
            ->orderBy('created_at')
            ->groupBy('date')
            ->get();

        $minusTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });

        $trxReport['date'] = dateSorting($trxReport['date']->unique()->toArray());
        $months            = $report['months'];

        for ($i = 0; $i < $months->count(); ++$i) {
            $monthVal      = Carbon::parse($months[$i]);
            if (isset($months[$i + 1])) {
                $monthValNext = Carbon::parse($months[$i + 1]);
                if ($monthValNext < $monthVal) {
                    $temp = $months[$i];
                    $months[$i]   = Carbon::parse($months[$i + 1])->format('F-Y');
                    $months[$i + 1] = Carbon::parse($temp)->format('F-Y');
                } else {
                    $months[$i]   = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }
        return view('owner.dashboard', compact('pageTitle', 'widget', 'bookingMonth', 'months', 'trxReport', 'plusTrx', 'minusTrx'));
    }

    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $owner = authOwner();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($owner->email . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Setting';
        return view('owner.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $owner = authOwner();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($owner, $request->code, $request->key);
        if ($response) {
            $owner->tsc = $request->key;
            $owner->ts = 1;
            $owner->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $owner = authOwner();
        $response = verifyG2fa($owner, $request->code);
        if ($response) {
            $owner->tsc = null;
            $owner->ts = 0;
            $owner->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        $owner = authOwner();
        return view('owner.profile', compact('pageTitle', 'owner'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:40',
            'lastname' => 'required|max:40',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $owner = authOwner();

        if ($request->hasFile('image')) {
            try {
                $old = $owner->image ?: null;
                $owner->image = fileUploader($request->image, getFilePath('ownerProfile'), getFileSize('ownerProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $owner->firstname  = $request->firstname;
        $owner->lastname  = $request->lastname;
        $owner->email = $request->email;
        $owner->save();

        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('owner.profile')->withNotify($notify);
    }


    public function password()
    {
        $pageTitle = 'Password Setting';
        $owner = authOwner();
        return view('owner.password', compact('pageTitle', 'owner'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = authOwner();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('owner.password')->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = OwnerNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('owner.notifications', compact('pageTitle', 'notifications'));
    }

    public function notificationRead($id)
    {
        $notification = OwnerNotification::findOrFail($id);
        $notification->is_read = Status::YES;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }

    public function requestReport()
    {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['PURCHASECODE'] = env('PURCHASECODE');
        $url = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
        $response = CurlRequest::curlContent($url);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return to_route('owner.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('owner.reports', compact('reports', 'pageTitle'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bug,feature',
            'message' => 'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['PURCHASECODE'] = env('PURCHASECODE');
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = CurlRequest::curlPostContent($url, $arr);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success', $response->message];
        return back()->withNotify($notify);
    }

    public function readAll()
    {
        OwnerNotification::where('is_read', Status::NO)->update([
            'is_read' => Status::YES
        ]);
        $notify[] = ['success', 'Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function paymentHistory()
    {
        $pageTitle = 'Subscription History';
        $deposits  = Deposit::where('status', '!=', Status::PAYMENT_INITIATE)->where('pay_for_month', '>', 0)->where('owner_id', getOwnerParentId())->searchable(['trx'])->dateFilter()->with('gateway')->latest()->paginate(getPaginate());

        return view('owner.payment_history', compact('pageTitle', 'deposits'));
    }

    public function updateAutoPaymentStatus(Request $request)
    {
        $owner = authOwner();
        $owner->auto_payment = $request->auto_payment ? 1 : 0;
        $owner->save();

        $notify[] = ['success', 'Auto payment status updated successfully'];
        return back()->withNotify($notify);
    }
}
