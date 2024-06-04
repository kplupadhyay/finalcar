<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use App\Models\Country;
use App\Models\CoverPhoto;
use App\Models\HotelSetting;
use App\Models\Location;
use App\Models\NotificationLog;
use App\Models\Owner;
use App\Models\RoomType;
use App\Models\Transaction;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ManageOwnersController extends Controller
{
    public function allOwners()
    {
        $pageTitle = 'All Hotels';
        $owners = $this->ownersData();
        return view('admin.owners.list', compact('pageTitle', 'owners'));
    }

    public function activeOwners()
    {
        $pageTitle = 'Active Hotels';
        $owners = $this->ownersData('active');
        return view('admin.owners.list', compact('pageTitle', 'owners'));
    }

    public function bannedOwners()
    {
        $pageTitle = 'Banned Hotels';
        $owners = $this->ownersData('banned');
        return view('admin.owners.list', compact('pageTitle', 'owners'));
    }

    public function detail($id)
    {
        $owner     = Owner::owner()->whereNotIn('status', [2, 5])->with('hotelSetting', 'hotelSetting.country', 'hotelSetting.city', 'hotelSetting.location')->findOrFail($id);
        $pageTitle = 'Vendor\'s Detail';

        $widget['total_room_type'] = RoomType::where('owner_id', $owner->id)->count();
        $widget['total_booking']   = Booking::active()->where('owner_id', $owner->id)->count();
        $widget['total_staff']     = Owner::where('parent_id', $owner->id)->count();
        $totalTransaction = Transaction::where('owner_id', $owner->id)->count();

        $countries = Country::active()->orderBy('name')->get();
        return view('admin.owners.detail', compact('pageTitle', 'owner', 'widget', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $owner          = Owner::owner()->findOrFail($id);
        $countryData    = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray   = (array) $countryData;
        $countries      = implode(',', array_keys($countryArray));
        $countryCode    = $request->country;
        $country        = $countryData->$countryCode->country;
        $dialCode       = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email|unique:owners,email,' . $owner->id,
            'country'   => 'required|in:' . $countries,
        ]);

        $countryCode          = $request->country;
        $owner->mobile        = $dialCode . $request->mobile;
        $owner->country_code  = $countryCode;
        $owner->firstname     = $request->firstname;
        $owner->lastname      = $request->lastname;
        $owner->email         = $request->email;
        $owner->address      = [
            'address'       => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'zip'           => $request->zip,
            'country'       => @$country,
        ];

        $owner->ts = $request->ts ? Status::ENABLE : Status::DISABLE;
        $owner->save();

        $notify[] = ['success', 'Vendor detail updated successfully'];
        return back()->withNotify($notify);
    }

    public function hotelSetting($id)
    {
        $owner     = Owner::owner()->with('hotelSetting')->findOrFail($id);
        $pageTitle = 'Hotel Setting of ' . $owner->fullname;
        $setting   = $owner->hotelSetting;

        $countries = Country::active()->orderBy('name')->with('cities.locations')->whereHas('cities', function ($city) {
            $city->whereHas('locations');
        })->get();

        $coverPhotos = CoverPhoto::where('owner_id', $owner->id)->get();

        $images      = [];
        foreach ($coverPhotos as $key => $image) {
            $img['id']  = $image->id;
            $img['src'] = getImage(getFilePath('coverPhoto') . '/' . $image->cover_photo);
            $images[]   = $img;
        }

        return view('admin.owners.hotel_setting', compact('pageTitle', 'setting', 'countries', 'images'));
    }

    public function updateHotelSetting(Request $request, $id)
    {
        $this->hotelSettingValidation($request, $id);
        $hotelSetting = HotelSetting::findOrFail($id);

        $hotelSetting->name                             = $request->name;
        $hotelSetting->star_rating                      = $request->star_rating;
        $hotelSetting->hotel_address                    = $request->hotel_address;
        $hotelSetting->latitude                         = $request->latitude;
        $hotelSetting->longitude                        = $request->longitude;
        $hotelSetting->country_id                       = $request->country_id;
        $hotelSetting->city_id                          = $request->city_id;
        $hotelSetting->location_id                      = $request->location_id;
        $hotelSetting->tax_name                         = $request->tax_name;
        $hotelSetting->tax_percentage                   = $request->tax_percentage;
        $hotelSetting->checkin_time                     = $request->checkin_time;
        $hotelSetting->checkout_time                    = $request->checkout_time;
        $hotelSetting->upcoming_checkin_days            = $request->upcoming_checkin_days;
        $hotelSetting->upcoming_checkout_days           = $request->upcoming_checkout_days;
        $hotelSetting->confirmation_amount_percentage   = $request->confirmation_amount_percentage;
        $hotelSetting->description                      = $request->description;
        $hotelSetting->cancellation_policy              = $request->cancellation_policy;

        if ($request->hasFile('image')) {
            try {
                $hotelSetting->image = fileUploader($request->image, getFilePath('hotelImage'), null, @$hotelSetting->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        $this->uploadCoverPhoto($request, $hotelSetting->owner_id);
        $hotelSetting->save();

        $notify[] = ['success', 'Hotel setting updated successfully'];
        return back()->withNotify($notify);
    }



    private function uploadCoverPhoto($request, $ownerId)
    {
        $path = getFilePath('coverPhoto');
        $owner = Owner::where('id', $ownerId)->with('coverPhotos')->first();
        $previousImages = $owner->coverPhotos->pluck('id')->toArray();
        $imageToRemove  = array_values(array_diff($previousImages, $request->old ?? []));

        // remove previous file
        foreach ($imageToRemove as $item) {
            $coverPhoto   = CoverPhoto::where('owner_id', $owner->id)->find($item);
            @unlink($path . '/' . $coverPhoto->cover_photo);
            $coverPhoto->delete();
        }

        // upload updated file
        if ($request->hasFile('cover_photos')) {
            $size = getFileSize('coverPhoto');
            $coverPhotos = [];

            foreach ($request->file('cover_photos') as $file) {
                try {
                    $coverPhoto              = new CoverPhoto();
                    $coverPhoto->cover_photo = fileUploader($file, $path, $size);
                    $coverPhotos[]           = $coverPhoto;
                } catch (\Exception $e) {
                    throw ValidationException::withMessages(['error' =>  'Couldn\'t upload the cover photo']);
                }
            }

            $owner->coverPhotos()->saveMany($coverPhotos);
        }
    }

    private function hotelSettingValidation($request, $id)
    {
        $countryIds  = Country::active()->pluck('id')->toArray();
        $cityIds     = City::where('country_id', $request->country_id)->pluck('id')->toArray();
        $locationIds = Location::where('city_id', $request->city_id)->pluck('id')->toArray();

        $request->validate([
            'name'                      => 'required|max:255|unique:hotel_settings,name,' . $id,
            'star_rating'               => 'required|integer|min:1|max:' . gs('max_star_rating'),
            'hotel_address'             => 'required|string',
            'latitude'                  => 'required|numeric|between:-90,90',
            'longitude'                 => 'required|numeric|between:-180,180',
            'country_id'                => 'required|integer|in:' . implode(',', $countryIds),
            'city_id'                   => 'required|in:' . implode(',', $cityIds),
            'location_id'               => 'required|in:' . implode(',', $locationIds),
            'tax_name'                  => 'required',
            'tax_percentage'            => 'required|numeric|gte:0',
            'checkin_time'              => 'required|date_format:H:i',
            'checkout_time'             => 'required|date_format:H:i',
            'upcoming_checkin_days'     => 'required|numeric|min:1',
            'upcoming_checkout_days'    => 'required|numeric|min:1',
            'description'               => 'required|string',
            'image'                      => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cover_photos'              => 'nullable|array',
            'cover_photos.*'            => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cancellation_policy'       => 'required'
        ]);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act' => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $owner = Owner::owner()->findOrFail($id);
        $amount = $request->amount;
        $trx = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $owner->balance += $amount;

            $transaction->trx_type = '+';
            $transaction->remark = 'balance_add';

            $notifyTemplate = 'BAL_ADD';

            $notify[] = ['success', gs('cur_sym') . $amount . ' added successfully'];
        } else {
            if ($amount > $owner->balance) {
                $notify[] = ['error', $owner->fullname . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $owner->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark = 'balance_subtract';

            $notifyTemplate = 'BAL_SUB';
            $notify[] = ['success', gs('cur_sym') . $amount . ' subtracted successfully'];
        }

        $owner->save();

        $transaction->owner_id = $owner->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $owner->balance;
        $transaction->charge = 0;
        $transaction->trx =  $trx;
        $transaction->details = $request->remark;
        $transaction->save();

        notify($owner, $notifyTemplate, [
            'trx' => $trx,
            'amount' => showAmount($amount),
            'remark' => $request->remark,
            'post_balance' => showAmount($owner->balance)
        ]);

        return back()->withNotify($notify);
    }

    public function status(Request $request, $id)
    {
        $owner = Owner::owner()->findOrFail($id);
        if ($owner->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);

            $owner->status = Status::USER_BAN;
            $owner->ban_reason = $request->reason;
            $notify[] = ['success', 'Vendor banned successfully'];
        } else {
            $owner->status = Status::USER_ACTIVE;
            $owner->ban_reason = null;
            $notify[] = ['success', 'Vendor unbanned successfully'];
        }

        $owner->save();
        return back()->withNotify($notify);
    }

    public function notificationLog($id)
    {
        $owner = Owner::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $owner->fullname;
        $logs = NotificationLog::where('owner_id', $id)->with('owner')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'owner'));
    }

    public function showNotificationSingleForm($id)
    {
        $owner = Owner::owner()->findOrFail($id);
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.owners.detail', $owner->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $owner->fullname;
        return view('admin.owners.notification_single', compact('pageTitle', 'owner'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);

        $owner = Owner::owner()->findOrFail($id);
        notify($owner, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }
        $notifyToOwner = Owner::notifyToOwner();
        $owners = Owner::owner()->active()->count();
        $pageTitle = 'Notification to Verified Vendors';
        return view('admin.owners.notification_all', compact('pageTitle', 'owners', 'notifyToOwner'));
    }

    public function sendNotificationAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message'                       => 'required',
            'subject'                       => 'required',
            'start'                         => 'required',
            'batch'                         => 'required',
            'being_sent_to'                 => 'required',
            'owner'                         => 'required_if:being_sent_to,selectedOwners',
            'number_of_top_deposited_owner' => 'required_if:being_sent_to,topDepositedOwners|integer|gte:0',
            'number_of_days'                => 'required_if:being_sent_to,notLoginOwners|integer|gte:0',
        ], [
            'number_of_days.required_if'                => "Number of days field is required",
            'number_of_top_deposited_owner.required_if' => "Number of top deposited vendor field is required",
        ]);

        if ($validator->fails()) return response()->json(['error' => $validator->errors()->all()]);

        $scope = $request->being_sent_to;
        $owners = Owner::owner()->oldest()->active()->$scope()->skip($request->start)->limit($request->batch)->get();
        foreach ($owners as $owner) {
            notify($owner, 'DEFAULT', [
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
        }

        return response()->json([
            'total_sent' => $owners->count(),
        ]);
    }

    public function list()
    {
        $query = Owner::owner()->active();

        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%')->orWhere('username', 'like', '%' . request()->search . '%');
            });
        }

        $owners = $query->orderBy('id', 'desc')->paginate(getPaginate());

        return response()->json([
            'success'  => true,
            'owners'   => $owners,
            'more'     => $owners->hasMorePages()
        ]);
    }

    private function ownersData($scope = null)
    {
        $owners = Owner::owner();

        if ($scope) {
            $owners = $owners->$scope();
        } else {
            $owners = $owners->where('status', '!=', 2);
        }

        if (request()->search) {
            $search = request()->search;
            $owners = $owners->where('email', 'like', "%$search%")->orWhere(function ($query) use ($search) {
                $query->whereRaw("CONCAT(firstname, ' ',lastname) LIKE?", ["%$search%"]);
            })->orWhere(function ($query) use ($search) {
                $query->whereHas('hotelSetting', function ($hotelSetting) use ($search) {
                    $hotelSetting->where('name', 'like', "%$search%");
                });
            });
        }
        return $owners->latest()->with('hotelSetting', 'hotelSetting.country', 'hotelSetting.city', 'hotelSetting.location')->paginate(getPaginate());
    }

    public function updateFeatureStatus($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->is_featured = $owner->is_featured == Status::YES ? Status::NO : Status::YES;
        $owner->save();

        $notify[] = ['success', 'Feature status updated successfully'];
        return back()->withNotify($notify);
    }

    public function login($id)
    {
        Auth::guard('owner')->loginUsingId($id);
        return to_route('owner.dashboard');
    }
}
