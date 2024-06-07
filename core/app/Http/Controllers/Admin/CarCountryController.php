<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarCountry;
use Illuminate\Http\Request;

class CarCountryController extends Controller
{
    public function all()
    {
        $pageTitle = 'All Cars';
        $countries = CarCountry::query();
        
        if (request()->search) {
            $search = request()->search;
            $countries = $countries->where('name', 'like', "%$search%");
        }

        $countries = $countries->latest()->withCount('cities as total_city')->paginate(getPaginate());
        return view('admin.carcountry', compact('pageTitle', 'countries'));
    }

    // public function add(Request $request, $id = 0)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:countries,name,' . $id,
    //         'code' =>  ['required', 'regex:/^[A-Z]{2,3}$/', 'unique:countries,code,' . $id],
    //         'dial_code' => ['required', 'regex:/^(\+\d+|\d+)$/', 'unique:countries,dial_code,' . $id]
    //     ]);

    //     if ($id) {
    //         $country = CarCountry::findOrFail($id);
    //         $message = 'Country updated successfully';
    //     } else {
    //         $country = new CarCountry;
    //         $message = 'Country added successfully';
    //     }

    //     $country->name = $request->name;
    //     $country->code = $request->code;
    //     $country->dial_code = $request->dial_code;  
    //     $country->save();

    //     $notify[] = ['success', $message];
    //     return back()->withNotify($notify);
    // }


    public function add(Request $request, $id = 0)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|unique:countries,name,' . $id,  // 'name' must be unique, excluding the current record if $id is not 0
            'code' =>  ['required', 'regex:/^[A-Z]{2,3}$/', 'unique:countries,code,' . $id],  // 'code' must be a 2-3 uppercase letter code, unique excluding current record
            'dial_code' => ['required', 'regex:/^(\+\d+|\d+)$/', 'unique:countries,dial_code,' . $id]  // 'dial_code' must match regex, unique excluding current record
        ]);
    
        // Check if updating an existing country or adding a new one
        if ($id) {
            $country = CarCountry::findOrFail($id);  // Find the country by ID or fail
            $message = 'Country updated successfully';  // Message for update
        } else {
            $country = new CarCountry;  // Create a new instance for a new country
            $message = 'Country added successfully';  // Message for addition
        }
        // $country = new CarCountry();
    
        // Assign the validated data to the country model
        $country->name = $request->name;
        $country->code = $request->code;
        $country->dial_code = $request->dial_code;
        $country->save();  // Save the model to the database
    
        // Prepare a success notification
        $notify[] = ['success', $message];
        // $notify[] = ['success', "done"];
        return back()->withNotify($notify);  // Redirect back with the notification
    }
    
    public function updateStatus($id)
    {
        return CarCountry::changeStatus($id);
    }
}
