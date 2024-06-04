<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\City;
use App\Models\Country;
use App\Models\Form;
use App\Models\HotelSetting;
use App\Models\Location;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerRequestController extends Controller
{

    public function ownerRequest()
    {
        if (gs('is_enable_owner_request') == Status::DISABLE) {
            return to_route('home');
        }

        $pageTitle  = "Register Your Hotel";

        $ownerId    = session()->get('OWNER_ID');
        $step       = session()->get('STEP');

        if ($step == 2) {
            $view = 'registration_completed';
        } elseif ($step == 1 && $ownerId != null) {
            $view = 'request_form_data';
        } else {
            $view = 'owner_request';
        }

        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);

        $countries  = Country::active()->whereHas('cities', function ($cities) {
            $cities->whereHas('locations');
        })->orderBy('name')->get();

        $cities     = City::active()->orderBy('name')->get();
        $locations  = Location::active()->orderBy('name')->get();

        return view($this->activeTemplate . $view, compact('pageTitle', 'mobileCode', 'countries', 'cities', 'locations'));
    }

    public function checkOwner(Request $request)
    {
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = Owner::where('email', $request->email)->exists();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = Owner::where('mobile', $request->mobile)->exists();
            $exist['type'] = 'mobile';
        }
        return response($exist);
    }

    public function sendRequest(Request $request)
    {
        $countries    = Country::active()->get();
        $countryIds   = $countries->pluck('id')->toArray();
        $countryCodes = $countries->pluck('code')->toArray();
        $mobileCodes  = $countries->pluck('dial_code')->toArray();
        $cityIds      = City::active()->pluck('id')->toArray();
        $locationIds  = Location::active()->pluck('id')->toArray();

        $request->validate([
            'hotel_name'   => 'required|string',
            'star_rating'  => 'required|integer|max:' . gs('max_star_rating'),
            'country'      => 'required|in:' . implode(",", $countryIds),
            'mobile_code'  => 'required|in:' . implode(",", $mobileCodes),
            'country_code' => 'required|in:' . implode(",", $countryCodes),
            'city'         => 'required|in:' . implode(",", $cityIds),
            'location'     => 'required|in:' . implode(",", $locationIds),
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'captcha'      => 'sometimes|required',
            'email'        => 'required|email|unique:owners',
            'mobile'       => 'required|regex:/^([0-9]*)$/'
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $exist = Owner::where('mobile', $request->mobile_code . $request->mobile)->first();

        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        $owner = new Owner;
        $owner->firstname = $request->firstname;
        $owner->lastname = $request->lastname;
        $owner->email = $request->email;
        $owner->country_code = $request->country_code;
        $owner->mobile = $request->mobile_code . $request->mobile;
        $owner->req_step = 1;
        $owner->status = 5;
        $owner->save();

        session()->put('OWNER_ID', $owner->id);
        session()->put('STEP', 1);

        $hotelSetting = new HotelSetting;
        $hotelSetting->owner_id = $owner->id;
        $hotelSetting->name = $request->hotel_name;
        $hotelSetting->star_rating = $request->star_rating;
        $hotelSetting->country_id = $request->country;
        $hotelSetting->city_id = $request->city;
        $hotelSetting->location_id = $request->location;
        $hotelSetting->save();

        return back();
    }

    public function storeFormData(Request $request, $id)
    {
        $owner = Owner::where('status', 5)->findOrFail($id);
        $form  = Form::where('act', 'owner_form')->first();

        $formData           = $form->form_data;
        $formProcessor      = new FormProcessor();
        $formValidationRule = $formProcessor->valueValidation($formData);

        $request->validate($formValidationRule);
        $ownerData = $formProcessor->processFormData($request, $formData);

        $owner->form_data = $ownerData;
        $owner->req_step  = 2;
        $owner->status    = 2;
        $owner->save();

        session()->put('STEP', 2);

        $adminNotification            = new AdminNotification();
        $adminNotification->owner_id  = $owner->id;
        $adminNotification->title     = 'One person requested to be an owner';
        $adminNotification->click_url = urlPath('admin.owners.detail', $owner->id);
        $adminNotification->save();

        $notify[] = ['success', 'Your hotel registration request send successfully'];
        return back()->withNotify($notify);
    }
}
