<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use App\Constants\Status;
use App\Models\City;
use App\Models\Deposit;
use App\Models\Owner;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pageTitle                          = 'Dashboard';

        $widget['total_users']              = User::count();
        $widget['total_owners']             = Owner::count();
        $widget['payment_pending']          = Deposit::pending()->count();
        $widget['pending_tickets']          = SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count();

        $topHotels = Owner::active()->withCount(['bookings as total_booking' => function ($booking) {
            $booking->whereIn('status', [Status::BOOKING_ACTIVE, Status::BOOKING_CHECKOUT]);
        }])->having('total_booking', '>', 0)->orderBy('total_booking', 'DESC')->with('hotelSetting:owner_id,city_id,name',  'hotelSetting.city.country')->take(10)->get();

        $mostBookedCities = City::select('cities.id', 'cities.name','cities.image' ,'countries.name as country')->join('hotel_settings', 'cities.id', '=', 'hotel_settings.city_id')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->join('owners', 'hotel_settings.owner_id', '=', 'owners.id')
            ->leftJoin('bookings', function ($join) {
                $join->on('owners.id', '=', 'bookings.owner_id')
                    ->whereIn('bookings.status', [Status::BOOKING_ACTIVE, Status::BOOKING_CHECKOUT]);
            })
            ->selectRaw("COUNT(bookings.id) as total_booking")
            ->selectRaw("COUNT(DISTINCT hotel_settings.id) as total_hotel")
            ->groupBy('cities.id')
            ->having('total_booking', '>', 0)
            ->orderBy('total_booking', 'DESC')
            ->take(10)
            ->get();

        // Monthly Deposit & Withdraw Report Graph
        $months = collect([]);

        $billPayments = Transaction::where('remark', 'monthly_bill_payment')->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM(amount) as amount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $billPayments->map(function ($depositData) use ($months) {
            $months->push($depositData->months);
        });

        $withdrawalMonth = Withdrawal::where('created_at', '>=', Carbon::now()->subYear())->where('status', Status::PAYMENT_SUCCESS)
            ->selectRaw("SUM( CASE WHEN status = " . Status::PAYMENT_SUCCESS . " THEN amount END) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $withdrawalMonth->map(function ($withdrawData) use ($months) {
            if (!in_array($withdrawData->months, $months->toArray())) {
                $months->push($withdrawData->months);
            }
        });

        for ($i = 0; $i < $months->count() - 1; ++$i) {
            for ($j = $i + 1; $j < $months->count(); $j++) {
                $monthVal = Carbon::parse($months[$i]);
                $nextMonthVal = Carbon::parse($months[$j]);
                if($monthVal > $nextMonthVal){
                    $months[$i] = $nextMonthVal->format('F-Y');
                    $months[$j] = $monthVal->format('F-Y');
                }
            }
        }
        
        return view('admin.dashboard', compact('pageTitle', 'widget', 'topHotels', 'mostBookedCities', 'months', 'billPayments', 'withdrawalMonth'));
    }

    // car
    public function cardashboard()
    {
        $pageTitle                          = 'Dashboard';

        $widget['total_users']              = User::count();
        $widget['total_owners']             = Owner::count();
        $widget['payment_pending']          = Deposit::pending()->count();
        $widget['pending_tickets']          = SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count();

        $topHotels = Owner::active()->withCount(['bookings as total_booking' => function ($booking) {
            $booking->whereIn('status', [Status::BOOKING_ACTIVE, Status::BOOKING_CHECKOUT]);
        }])->having('total_booking', '>', 0)->orderBy('total_booking', 'DESC')->with('hotelSetting:owner_id,city_id,name',  'hotelSetting.city.country')->take(10)->get();

        $mostBookedCities = City::select('cities.id', 'cities.name','cities.image' ,'countries.name as country')->join('hotel_settings', 'cities.id', '=', 'hotel_settings.city_id')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->join('owners', 'hotel_settings.owner_id', '=', 'owners.id')
            ->leftJoin('bookings', function ($join) {
                $join->on('owners.id', '=', 'bookings.owner_id')
                    ->whereIn('bookings.status', [Status::BOOKING_ACTIVE, Status::BOOKING_CHECKOUT]);
            })
            ->selectRaw("COUNT(bookings.id) as total_booking")
            ->selectRaw("COUNT(DISTINCT hotel_settings.id) as total_hotel")
            ->groupBy('cities.id')
            ->having('total_booking', '>', 0)
            ->orderBy('total_booking', 'DESC')
            ->take(10)
            ->get();

        // Monthly Deposit & Withdraw Report Graph
        $months = collect([]);

        $billPayments = Transaction::where('remark', 'monthly_bill_payment')->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM(amount) as amount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $billPayments->map(function ($depositData) use ($months) {
            $months->push($depositData->months);
        });

        $withdrawalMonth = Withdrawal::where('created_at', '>=', Carbon::now()->subYear())->where('status', Status::PAYMENT_SUCCESS)
            ->selectRaw("SUM( CASE WHEN status = " . Status::PAYMENT_SUCCESS . " THEN amount END) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $withdrawalMonth->map(function ($withdrawData) use ($months) {
            if (!in_array($withdrawData->months, $months->toArray())) {
                $months->push($withdrawData->months);
            }
        });

        for ($i = 0; $i < $months->count() - 1; ++$i) {
            for ($j = $i + 1; $j < $months->count(); $j++) {
                $monthVal = Carbon::parse($months[$i]);
                $nextMonthVal = Carbon::parse($months[$j]);
                if($monthVal > $nextMonthVal){
                    $months[$i] = $nextMonthVal->format('F-Y');
                    $months[$j] = $monthVal->format('F-Y');
                }
            }
        }
        
        return view('admin.dashboard', compact('pageTitle', 'widget', 'topHotels', 'mostBookedCities', 'months', 'billPayments', 'withdrawalMonth'));
    }
    //car

    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('admin.notifications', compact('pageTitle', 'notifications'));
    }

    public function notificationRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
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
            return to_route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports', compact('reports', 'pageTitle'));
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
        AdminNotification::where('is_read', Status::NO)->update([
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
}
