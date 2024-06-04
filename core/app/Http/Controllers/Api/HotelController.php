<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Location;
use App\Models\Facility;
use App\Models\Owner;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    public function search(Request $request)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $hotels  = $this->hotelData($request);

        $notify = 'Hotel Search';
        return response()->json([
            'remark' => 'hotel_search',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'image_path'     => asset(getFilePath('hotelImage')),
                'hotels'        => $hotels
            ]
        ]);
    }

    public function getFilterParameters()
    {
        $amenities  = Amenity::active()->get();
        $facilities = Facility::active()->get();
        $locations = Location::active()->get();

        $minFare = RoomType::active()->min('fare');
        $maxFare = RoomType::active()->max('fare');

        $notify = 'Filter Parameters';
        return response()->json([
            'remark' => 'filter_parameters',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'min_fare'        => getAmount($minFare),
                'max_fare'        => getAmount($maxFare),
                'amenities'       => $amenities,
                'facilities'      => $facilities,
                'locations'       => $locations,
                'max_star_rating' => gs('max_star_rating')
            ]
        ]);
    }

    private function validation($request)
    {
        $amenities      = Amenity::active()->pluck('id')->toArray();
        $facilities     = Facility::active()->pluck('id')->toArray();
        $cityIds        = City::active()->pluck('id')->toArray();
        $locationIds    = Location::active()->pluck('id')->toArray();

        $rules = [
            'city_id'             => 'required|in:' . implode(',', $cityIds),
            'check_in'            => 'required|date_format:Y-m-d|after:yesterday',
            'checkout'            => 'required|date_format:Y-m-d|after:check_in',
            'rooms'               => 'required|array',
            'rooms.*.total_adult' => 'required|integer|gte:0',
            'rooms.*.total_child' => 'required|integer|gte:0',
            'min_fare'            => 'nullable|numeric|gte:0',
            'max_fare'            => 'nullable|numeric|gt:min_fare',
            'star_rating'         => 'nullable|integer|between:1,' . gs('max_star_rating'),
            'amenities'           => 'nullable|array',
            'amenities.*'         => 'integer|in:' . implode(',', $amenities),
            'facilities'          => 'nullable|array',
            'facilities.*'        => 'integer|in:' . implode(',', $facilities),
            'location_id'         => 'nullable|integer|in:' . implode(',', $locationIds)
        ];

        $messages = [
            'city_id.required'             => 'The selected destination is invalid',
            'rooms.*.total_adult.required' => 'Number of adult is required',
            'rooms.*.total_child.required' => 'Number of child is required',
            'rooms.*.total_adult.gte'      => 'Total adult must be greater than or equal to zero',
            'rooms.*.total_child.gte'      => 'Total child must be greater than or equal to zero',
            'min_fare.gte'                 => 'Minimum fare must be greater than or equal to zero',
            'min_fare.numeric'             => 'Minimum fare must be a number',
            'max_fare.numeric'             => 'Maximum fare must be a number',
            'max_fare.gt'                  => 'Maximum fare should be greater than minimum fare',
            'amenities.*.in'               => 'Invalid amenity selected',
            'facilities.*.in'              => 'Invalid facility selected',
            'neighborhood.in'              => 'Invalid neighborhood selected'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }

    public function filterByCity($id)
    {
        $city = City::active()->find($id);

        if (!$city) {
            $notify[] = 'Invalid city provided';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $hotels = Owner::select('hotel_settings.*', 'cities.name as city')
            ->selectRaw('MIN(room_types.fare) as minimum_fare')
            ->selectRaw('MAX(room_types.fare) as maximum_fare')
            ->join('room_types', 'owners.id', '=', 'room_types.owner_id')
            ->join('hotel_settings', 'owners.id', '=', 'hotel_settings.owner_id')
            ->join('cities', 'hotel_settings.city_id', '=', 'cities.id')
            ->groupBy('owners.id')
            ->where('room_types.status', Status::ROOM_TYPE_ACTIVE)
            ->where('hotel_settings.city_id', $id)
            ->whereDate('owners.expire_at', '>=', now())
            ->where('owners.status', Status::USER_ACTIVE)->apiQuery();

        $notify[] = 'Hotel filter by city';
        return response()->json([
            'remark' => 'Hotel Filter',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'image_path'  => asset(getFilePath('hotelImage')),
                'hotels'     => $hotels,
            ]
        ]);
    }


    private function hotelData($request)
    {
        $totalAdult = array_sum(array_column($request->rooms, 'total_adult'));
        $totalChild = array_sum(array_column($request->rooms, 'total_child'));

        $checkIn = Carbon::parse($request->check_in);
        $checkout = Carbon::parse($request->checkout);

        $hotels = Owner::select('hotel_settings.*',  'countries.name as country', 'cities.name as city')
            ->selectRaw('SUM(valid_rooms.available_rooms) as available_rooms')
            ->selectRaw('SUM(room_types.total_adult * valid_rooms.available_rooms) as adult_capacity')
            ->selectRaw('SUM(room_types.total_child * valid_rooms.available_rooms) as child_capacity')
            ->selectRaw('MIN(room_types.fare) as minimum_fare')
            ->selectRaw('MAX(room_types.fare) as maximum_fare')
            ->join('room_types', 'owners.id', '=', 'room_types.owner_id')
            ->join('hotel_settings', 'owners.id', '=', 'hotel_settings.owner_id')
            ->join('cities', 'hotel_settings.city_id', '=', 'cities.id')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->joinSub(function ($query) use ($checkIn, $checkout) {
                $query->select('rooms.room_type_id', DB::raw('COUNT(rooms.id) as available_rooms'))
                    ->from('rooms')
                    ->where('rooms.status', Status::ROOM_ACTIVE)
                    ->whereNotIn('rooms.id', function ($subQuery) use ($checkIn, $checkout) {
                        $subQuery->select('room_id')
                            ->from('booked_rooms')
                            ->whereBetween('booked_for', [$checkIn, $checkout])
                            ->where('status', Status::BOOKING_ACTIVE);
                    })
                    ->groupBy('rooms.room_type_id');
            }, 'valid_rooms', 'room_types.id', '=', 'valid_rooms.room_type_id')
            ->groupBy('owners.id')
            ->where('room_types.status', Status::ROOM_TYPE_ACTIVE)
            ->having('adult_capacity', '>=', $totalAdult)
            ->having('child_capacity', '>=', $totalChild)
            ->where('hotel_settings.city_id', $request->city_id)
            ->whereDate('owners.expire_at', '>=', now())
            ->where('owners.status', Status::USER_ACTIVE);

        if ($request->star_rating) {
            $hotels = $hotels->where('star_rating', $request->star_rating);
        }

        if ($request->min_fare) {
            $hotels = $hotels->having('minimum_fare', '>=', $request->min_fare);
        }

        if ($request->max_fare) {
            $hotels = $hotels->having('maximum_fare', '<=', $request->max_fare);
        }

        if ($request->amenities) {
            $amenityIDs = $request->amenities;
            $hotels = $hotels->whereHas('roomTypes', function ($roomTypeQuery) use ($amenityIDs) {
                $roomTypeQuery->whereHas('amenities', function ($amenityQuery) use ($amenityIDs) {
                    $amenityQuery->whereIn('amenities.id', $amenityIDs);
                });
            });
        }

        if ($request->facilities) {
            $facilityIDs = $request->facilities;
            $hotels = $hotels->whereHas('roomTypes', function ($roomTypeQuery) use ($facilityIDs) {
                $roomTypeQuery->whereHas('facilities', function ($facilityQuery) use ($facilityIDs) {
                    $facilityQuery->whereIn('facilities.id', $facilityIDs);
                });
            });
        }

        if ($request->location_id) {
            $hotels = $hotels->where('location_id', $request->location_id);
        }

        $hotels = $hotels->apiQuery();
        return $hotels;
    }

    public function detail(Request $request, $id)
    {
        if (!empty($request->all())) {
            $validator = Validator::make($request->all(), [
                'check_in'            => 'required|date_format:Y-m-d|after:yesterday',
                'checkout'            => 'required|date_format:Y-m-d|after:check_in',
                'rooms'               => 'required|array',
                'rooms.*.total_adult' => 'required|integer|gte:0',
                'rooms.*.total_child' => 'required|integer|gte:0'
            ], [
                'rooms.*.total_adult.required' => 'Total adult is required',
                'rooms.*.total_child.required' => 'Total child is required',
                'rooms.*.total_adult.gte'      => 'Total adult must be greater than or equal to zero',
                'rooms.*.total_child.gte'      => 'Total child must be greater than or equal to zero',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'remark' => 'validation_error',
                    'status' => 'error',
                    'message' => ['error' => $validator->errors()->all()],
                ]);
            }

            $hotel = Owner::active()->notExpired()->where('id', $id)
                ->with(['hotelSetting', 'roomTypes' => function ($roomTypeQuery) use ($request) {
                    $roomTypeQuery->withCount(['rooms as total_rooms' => function ($q) {
                        $q->active();
                    }])
                        ->addSelect(['booked_rooms' => function ($subQuery) use ($request) {
                            $subQuery->selectRaw('COUNT(DISTINCT room_id)')
                                ->from('booked_rooms')
                                ->join('rooms', 'booked_rooms.room_id', 'rooms.id')
                                ->where('rooms.status', Status::ENABLE)
                                ->where('booked_rooms.status', Status::ROOM_ACTIVE)
                                ->whereBetween('booked_for', [Carbon::parse($request->check_in)->format('Y-m-d'), Carbon::parse($request->checkout)->format('Y-m-d')])
                                ->whereColumn('booked_rooms.room_type_id', 'room_types.id');
                        }])
                        ->where('room_types.status', Status::ROOM_TYPE_ACTIVE)
                        ->selectRaw('(SELECT total_rooms - booked_rooms) as available_rooms')
                        ->havingRaw('(total_rooms - booked_rooms) > 0');
                }, 'roomTypes.facilities', 'roomTypes.amenities', 'coverPhotos'])
                ->withMin('roomTypes as minimum_fare', 'fare')
                ->withMax('roomTypes as maximum_fare', 'fare')
                ->first();
        } else {
            $hotel = Owner::active()->whereDate('expire_at', '>=', now())->where('id', $id)->with(['hotelSetting', 'roomTypes' => function ($roomTypeQuery) {
                $roomTypeQuery->active();
            }, 'roomTypes.facilities', 'roomTypes.amenities', 'coverPhotos'])
                ->withMin('roomTypes as minimum_fare', 'fare')
                ->withMax('roomTypes as maximum_fare', 'fare')
                ->first();
        }

        if (!$hotel) {
            $notify[] = 'Hotel not found';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $facilities = Facility::whereHas('roomTypes', function ($roomType) use ($hotel) {
            $roomType->whereHas('owner', function ($owner) use ($hotel) {
                $owner->where('id', $hotel->id);
            });
        })->get();

        $amenities = Amenity::whereHas('roomTypes', function ($roomType) use ($hotel) {
            $roomType->whereHas('owner', function ($owner) use ($hotel) {
                $owner->where('id', $hotel->id);
            });
        })->get();

        $total = $facilities->count() + $amenities->count();

        $notify[] = 'Hotel details';
        return response()->json([
            'remark' => 'hotel_detail',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'room_type_image_url' => getFilePath('roomTypeImage'),
                'facilities' => $facilities,
                'amenities' => $amenities,
                'total_facilities' => $total,
                'hotel' => $hotel
            ]
        ]);
    }
}
