<?php

namespace App\Http\Controllers\Owner;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\CoverPhoto;
use App\Models\HotelSetting;
use App\Models\PaymentSystem;
use App\Models\Owner;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HotelSettingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Hotel Setting';
        $setting = HotelSetting::where('owner_id', getOwnerParentId())->with('city')->first();
        $coverPhotos = CoverPhoto::where('owner_id', getOwnerParentId())->get();

        $images      = [];
        foreach ($coverPhotos as $key => $image) {
            $img['id']  = $image->id;
            $img['src'] = getImage(getFilePath('coverPhoto') . '/' . $image->cover_photo);
            $images[]   = $img;
        }

        return view('owner.hotel.setting', compact('pageTitle', 'setting', 'images'));
    }

    public function update(Request $request, $id)
    {
        $this->validation($request);
        $hotelSetting = HotelSetting::currentOwner()->findOrFail($id);

        $hotelSetting->hotel_address           = $request->hotel_address;
        $hotelSetting->latitude                = $request->latitude;
        $hotelSetting->longitude               = $request->longitude;
        $hotelSetting->tax_name                = $request->tax_name;
        $hotelSetting->tax_percentage          = $request->tax_percentage;
        $hotelSetting->checkin_time            = $request->checkin_time;
        $hotelSetting->checkout_time           = $request->checkout_time;
        $hotelSetting->upcoming_checkin_days   = $request->upcoming_checkin_days;
        $hotelSetting->upcoming_checkout_days  = $request->upcoming_checkout_days;
        $hotelSetting->description             = $request->description;
        $hotelSetting->cancellation_policy     = $request->cancellation_policy;

        if ($request->hasFile('image')) {
            try {
                $hotelSetting->image = fileUploader($request->image, getFilePath('hotelImage'), null, @$hotelSetting->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        $this->uploadCoverPhoto($request);
        $hotelSetting->save();

        $notify[] = ['success', 'Hotel setting updated successfully'];
        return back()->withNotify($notify);
    }

    private function validation($request)
    {
        $request->validate([
            'hotel_address'             => 'required|string',
            'latitude'                  => 'required|numeric|between:-90,90',
            'longitude'                 => 'required|numeric|between:-180,180',
            'tax_name'                  => 'required',
            'tax_percentage'            => 'required|numeric|gte:0',
            'checkin_time'              => 'required|date_format:H:i',
            'checkout_time'             => 'required|date_format:H:i',
            'upcoming_checkin_days'     => 'required|numeric|min:1',
            'upcoming_checkout_days'    => 'required|numeric|min:1',
            'description'               => 'required|string',
            'image'                     => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cover_photos'              => 'nullable|array',
            'cover_photos.*'            => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cancellation_policy'       => 'required'
        ]);
    }

    private function uploadCoverPhoto($request)
    {
        $path = getFilePath('coverPhoto');
        $owner = Owner::where('id', getOwnerParentId())->with('coverPhotos')->first();
        $previousImages = $owner->coverPhotos->pluck('id')->toArray();
        $imageToRemove  = array_values(array_diff($previousImages, $request->old ?? []));

        // remove previous file
        foreach ($imageToRemove as $item) {
            $coverPhoto   = CoverPhoto::currentOwner()->find($item);
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

    public function paymentSystems()
    {
        $pageTitle = 'Payment Systems';
        $paymentSystems = PaymentSystem::currentOwner()->get();
        return view('owner.hotel.payment_systems', compact('pageTitle', 'paymentSystems'));
    }

    public function addPaymentSystem(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|'
        ]);

        $exist = PaymentSystem::currentOwner()->where('name', $request->name)->where('id', '!=', $id)->exists();
        if ($exist) {
            $notify[] = ['error', 'The name already exists'];
            return back()->withNotify($notify);
        }

        if ($id) {
            $paymentSystem = PaymentSystem::currentOwner()->findOrFail($id);
            $notification = 'Payment system updated successfully';
        } else {
            $paymentSystem = new PaymentSystem();
            $paymentSystem->owner_id = getOwnerParentId();
            $notification = 'Payment system added successfully';
        }

        $paymentSystem->name = $request->name;
        $paymentSystem->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function updatePaymentSystemStatus($id)
    {
        $paymentSystem = PaymentSystem::currentOwner()->findOrFail($id);

        $paymentSystem->status = $paymentSystem->status == Status::ENABLE ? Status::DISABLE : Status::ENABLE;
        $paymentSystem->save();

        $notify[] = ['success', 'Status updated successfully'];
        return back()->withNotify($notify);
    }
}
