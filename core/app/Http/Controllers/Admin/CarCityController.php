<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\CarCity;
use App\Models\CarCountry;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;

class CarCityController extends Controller
{
    public function all()
    {
        $pageTitle     = 'All Cities';
        $cities        = CarCity::searchable(['name', 'country:name'])->latest()->with('country')->withCount('locations as total_location')->paginate(getPaginate());
        $countries     = CarCountry::orderBy('name')->get();
        return view('admin.carcities', compact('pageTitle', 'cities', 'countries'));
    }

    public function add(Request $request, $id = 0)
    {
        $imageValidation = 'required';

        if ($id) {
            $imageValidation = 'nullable';
        }

        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|unique:cities,name,' . $id,
            'image'  => [$imageValidation, new FileTypeValidate(['png', 'jpg', 'jpg'])]
        ]);

        if ($id) {
            $city = CarCity::findOrFail($id);
            $message = 'City updated successfully';
        } else {
            $city = new CarCity;
            $message = 'City added successfully';
        }

        $city->country_id = $request->country_id;
        $city->name       = $request->name;
        $city->is_popular = $request->has('is_popular') ? Status::YES : Status::NO;

        if ($request->hasFile('image')) {
            try {
                $path = getFilePath('city');
                $size = getFileSize('city');
                $city->image = fileUploader($request->image, $path, $size, @$city->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }

        $city->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }
}
