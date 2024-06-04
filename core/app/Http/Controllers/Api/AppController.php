<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function generalSetting()
    {
        $general = GeneralSetting::first();
        $notify[] = 'General setting data';
        return response()->json([
            'remark' => 'general_setting',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'general_setting' => $general,
            ],
        ]);
    }

    public function policies()
    {
        $policies = getContent('policy_pages.element', orderById: true);
        $notify[] = 'All policies';
        return response()->json([
            'remark' => 'policy_data',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'policies' => $policies,
            ],
        ]);
    }

    public function countries()
    {
        $countries = Country::active()->orderBy('name')->get();

        $notify[] = 'All countries';
        return response()->json([
            'remark' => 'country_data',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'countries' => $countries,
            ],
        ]);
    }

    public function getPopularHotels()
    {
        $owners = Owner::active()->notExpired()->whereHas('hotelSetting')
            ->withCount(['bookings as total_bookings' => function ($query) {
                $query->where('status', Status::BOOKING_ACTIVE)->whereDate('created_at', '>=', Carbon::now()->subDays(gs('popularity_count_from')));
            }])->having('total_bookings', '>', 0)->orderBy('total_bookings')->with('hotelSetting')->withMin(['roomTypes as minimum_fare' => function ($query) {
                $query->active();
            }], 'fare')->apiQuery();

        $notify[] = 'Popular hotels';
        return response()->json([
            'remark' => 'popular_hotels',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'owners' => $owners,
            ],
        ]);
    }

    public function popularCities()
    {
        $popularCities = City::active()->popular()->withCount(['hotelSettings as total_hotel' => function ($hotelSetting) {
            $hotelSetting->whereHas('owner', function ($owner) {
                $owner->where('status', Status::USER_ACTIVE)->whereDate('owners.expire_at', '>=', now())->whereHas('roomTypes', function ($roomTypes) {
                    $roomTypes->where('status', Status::ROOM_TYPE_ACTIVE);
                });
            });
        }])->having('total_hotel', '>', 0)->with('country:id,name')->orderBy('total_hotel', 'DESC')->apiQuery();


        $notify[] = 'Popular destination';
        return response()->json([
            'remark' => 'popular_destinations',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'popular_cities' => $popularCities,
            ],
        ]);
    }

    public function searchCities(Request $request)
    {
        $search = $request->keywords;
        $cities = City::active()->select('id', 'name', 'country_id', 'image')->where(function ($city) use ($search) {
            $city->where('name', 'like', "%$search%")
                ->orWhereHas('country', function ($country) use ($search) {
                    $country->where('name', 'like', "%$search%");
                });
        })->withCount(['hotelSettings as total_hotel' => function ($hotelSetting) {
            $hotelSetting->whereHas('owner', function ($owner) {
                $owner->where('status', Status::USER_ACTIVE)->whereDate('owners.expire_at', '>=', now())->whereHas('roomTypes', function ($roomTypes) {
                    $roomTypes->where('status', Status::ROOM_TYPE_ACTIVE);
                });
            });
        }])->with('country:id,name')->orderBy('total_hotel', 'DESC')->apiQuery();

        $notify[] = 'Search destinations';
        
        return response()->json([
            'remark' => 'search_destinations',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'cities' => $cities,
            ],
        ]);
    }

    public function featuredHotels()
    {
        $featuredHotels = Owner::owner()->active()->notExpired()->featured()->whereHas('hotelSetting')->with('hotelSetting')->apiQuery();
        $notify[] = 'Featured hotels';
        return response()->json([
            'remark'  => 'featured_hotels',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'featured_hotels' => $featuredHotels
            ]
        ]);
    }

    public function language($code)
    {
        $languages = Language::get();
        $languageCodes = $languages->pluck('code')->toArray();

        if (!in_array($code, $languageCodes)) {
            $notify[] = 'Invalid code given';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify]
            ]);
        }

        $jsonFile = file_get_contents(resource_path('lang/' . $code . '.json'));

        $notify[] = 'Language';
        return response()->json([
            'remark' => 'Language',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'languages' => $languages,
                'file' => $jsonFile,
            ],
        ]);
    }
}
