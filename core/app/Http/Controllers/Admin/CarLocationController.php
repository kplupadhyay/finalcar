<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarCountry;
use App\Models\CarLocation;
use Illuminate\Http\Request;

class CarLocationController extends Controller
{
    public function all()
    {
        $pageTitle = 'Car Locations';
        $countries = CarCountry::orderBy('name')->with('cities')->get();
        $locations = CarLocation::searchable(['name', 'city:name', 'city.country:name'])->latest()->with('city.country')->paginate(getPaginate());

        return view('admin.carlocation', compact('pageTitle', 'countries', 'locations'));
    }

    public function add(Request $request, $id = 0)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required'
        ]);

        if ($id) {
            $location = CarLocation::findOrFail($id);
            $message = 'Location updated successfully';
        } else {
            $location = new CarLocation;
            $message = 'Location added successfully';
        }

        $location->city_id = $request->city_id;
        $location->name = $request->name;
        $location->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }
}
