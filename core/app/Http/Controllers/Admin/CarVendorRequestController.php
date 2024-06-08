<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\CarSetting;
use App\Models\CarOw;
use Illuminate\Support\Facades\Hash;

class CarVendorRequestController extends Controller
{

    // public function vendorRequests()

    // {
    //     $pageTitle = 'Vendor Requests';
    //     $owners = CarOw::owner()->ownerRequest()->searchable(['firstname', 'lastname', 'email', 'mobile'])->with('hotelSetting', 'hotelSetting.location', 'hotelSetting.city', 'hotelSetting.country')->paginate(getPaginate());
    //     return view('admin.carvendor_request.list', compact('pageTitle', 'owners'));
    // }

    public function vendorRequests()
    {
        $pageTitle = 'Vendor Requests';
        $owners = CarOw::owner()->ownerRequest()->searchable(['firstname', 'lastname', 'email', 'mobile'])->with('hotelSetting', 'hotelSetting.location', 'hotelSetting.city', 'hotelSetting.country')->paginate(getPaginate());
        return view('admin.carvendor_request.list', compact('pageTitle', 'owners'));
    }

    public function requestDetail($id){
        $owner     = CarOw::ownerRequest()->with('hotelSetting', 'hotelSetting.country', 'hotelSetting.city', 'hotelSetting.location')->findOrFail($id);
        $pageTitle = 'Vendor Request';

        return view('admin.carvendor_request.detail', compact('pageTitle', 'owner'));
    }

    public function rejectRequest($id)
    {
        $owner = CarOw::ownerRequest()->findOrFail($id);
        CarSetting::where('owner_id', $owner->id)->delete();

        notify($owner, 'OWNER_REQUEST_REJECTED', [
            'username' => $owner->fullname
        ], createLog: false);

        $owner->delete();

        $notify[] = ['success', 'Request rejected successfully'];
        return to_route('admin.carvendor.request')->withNotify($notify);
    }

    public function approveRequest($id)
    {
        $owner = CarOw::ownerRequest()->findOrFail($id);
        $password = generateStrongPassword();

        $owner->password = Hash::make($password);
        $owner->status = Status::USER_ACTIVE;
        $owner->save();

        notify($owner, 'OWNER_REQUEST_APPROVED', [
            'email'  => $owner->email,
            'password' => $password,
            'login_url' => route('carowner.login')
        ]);

        $notify[] = ['success', 'Request approved successfully'];
        return to_route('admin.carvendor.request')->withNotify($notify);
    }
}
