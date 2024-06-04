<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Deposit;
use App\Models\DeviceToken;
use App\Models\GeneralSetting;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\Advertisement;
use App\Models\BookedRoom;
use App\Models\City;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home()
    {
        $ads    = Advertisement::whereDate('end_date', '>', now())->inRandomOrder()->limit(5)->get();

        $popularHotels = Owner::active()->notExpired()->whereHas('hotelSetting')
            ->withCount(['bookings as total_bookings' => function ($query) {
                $query->where('status', Status::BOOKING_ACTIVE)->whereDate('created_at', '>=', Carbon::now()->subDays(gs('popularity_count_from')));
            }])->having('total_bookings', '>', 0)->orderBy('total_bookings')->with('hotelSetting')->withMin(['roomTypes as minimum_fare' => function ($query) {
                $query->active();
            }], 'fare');

        $totalOwners = (clone $popularHotels)->count();
        $owners      = $popularHotels->limit(5)->get();


        $featuredOwners      = Owner::owner()->active()->notExpired()->featured()->whereHas('hotelSetting')->with('hotelSetting');
        $totalFeaturedOwners = (clone $featuredOwners)->count();
        $featuredOwners      = $featuredOwners->limit(5)->get();

        $popularCities = City::active()->popular()->withCount(['hotelSettings as total_hotel' => function ($hotelSetting) {
            $hotelSetting->whereHas('owner', function ($owner) {
                $owner->where('status', Status::USER_ACTIVE)->whereDate('owners.expire_at', '>=', now())->whereHas('roomTypes', function ($roomTypes) {
                    $roomTypes->where('status', Status::ROOM_TYPE_ACTIVE);
                });
            });
        }])->having('total_hotel', '>', 0)->with('country:id,name')->orderBy('total_hotel', 'DESC');

        $totalPopularCities = (clone $popularCities)->count();
        $popularCities      = $popularCities->limit(4)->get();

        $notify[] = 'User dashboard';
        return response()->json([
            'remark'  => 'user_dashboard',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'ads'                   => $ads,
                'owners'                => $owners,
                'total_owners'          => $totalOwners,
                'popular_cities'        => $popularCities,
                'total_popular_cities'  =>  $totalPopularCities,
                'featured_owners'       => $featuredOwners,
                'total_featured_owners' => $totalFeaturedOwners
            ]
        ]);
    }

    public function dashboard()
    {
        $notify[] = 'User dashboard';
        return response()->json([
            'remark'  => 'user_dashboard',
            'status'  => 'success',
            'message' => ['success' => $notify]
        ]);
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            $notify[] = 'You\'ve already completed your profile';
            return response()->json([
                'remark' => 'already_completed',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
        ];

        if ($user->social_id != null) {
            $rules['country_code'] = 'required';
            $rules['mobile'] = 'required|regex:/^([0-9]*)$/';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }


        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];

        $user->profile_complete = 1;

        if ($request->mobile && $user->social_id != null) {
            $user->country_code = $request->country_code;
            $user->mobile       = $request->mobile;
        }

        $user->save();

        $notify[] = 'Profile completed successfully';
        return response()->json([
            'remark' => 'profile_completed',
            'status' => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function paymentHistory(Request $request)
    {
        $deposits = Deposit::where('user_id', auth()->id())->where('status', '!=', Status::PAYMENT_INITIATE);
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with('booking')->orderBy('id', 'desc')->apiQuery();
        $notify[] = 'Payment history';
        return response()->json([
            'remark' => 'deposits',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'deposits' => $deposits
            ]
        ]);
    }

    public function transactions(Request $request)
    {
        $remarks = Transaction::distinct('remark')->get('remark');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $type = $request->type == 'plus' ? '+' : '-';
            $transactions = $transactions->where('trx_type', $type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->orderBy('id', 'desc')->apiQuery();
        $notify[] = 'Transactions data';
        return response()->json([
            'remark' => 'transactions',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'transactions' => $transactions,
                'remarks' => $remarks,
            ]
        ]);
    }

    public function submitProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->save();

        $notify[] = 'Profile updated successfully';
        return response()->json([
            'remark' => 'profile_updated',
            'status' => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = 'Password changed successfully';
            return response()->json([
                'remark' => 'password_changed',
                'status' => 'success',
                'message' => ['success' => $notify],
            ]);
        } else {
            $notify[] = 'The password doesn\'t match!';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }
    }

    public function userInfo()
    {
        $notify[] = 'User information';
        return response()->json([
            'remark' => 'user_info',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'user' => auth()->user()
            ]
        ]);
    }

    public function bookingHistory()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('bookedRooms', 'bookedRooms.room.roomType:id,name',  'owner.hotelSetting')
            ->latest()
            ->apiQuery();

        $notify[] = 'Booking history';
        return response()->json([
            'remark'  => 'booking_history',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'bookings' => $bookings
            ]
        ]);
    }

    public function notificationLog()
    {
        $notifications = NotificationLog::where('user_id', auth()->id())->select('id', 'subject', 'created_at')->apiQuery();

        $notify[] = 'All notifications';
        return response()->json([
            'remark'  => 'all_notifications',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'notifications' => $notifications
            ]
        ]);
    }

    public function saveDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $deviceToken = DeviceToken::where('user_id', auth()->id())->where('token', $request->token)->first();

        if ($deviceToken) {
            $notify[] = 'Already exists';
            return response()->json([
                'remark' => 'save_device_token',
                'status' => 'success',
                'message' => ['success' => $notify],
            ]);
        }

        $deviceToken = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token = $request->token;
        $deviceToken->is_app = 1;
        $deviceToken->save();

        $notify[] = 'Token save successfully';
        return response()->json([
            'remark' => 'save_device_token',
            'status' => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function bookingDetail($id)
    {
        $booking = Booking::where('user_id', auth()->id())->with([
            'usedExtraService.room',
            'usedExtraService.extraService',
            'payments',
            'guest',
            'owner:id,firstname',
            'owner.hotelSetting:id,owner_id,location_id,city_id,country_id,name,image,tax_name',
            'owner.hotelSetting.location',
            'owner.hotelSetting.city',
            'owner.hotelSetting.country'
        ])->where('id', $id)->first();

        $bookedRooms = BookedRoom::where('booking_id', $booking->id)->with('room', 'roomType:id,name')->get()->groupBy('booked_for');

        $paymentInfo = [
            'subtotal'            => $booking->booking_fare - $booking->total_discount,
            'total_amount'        => $booking->total_amount,
            'canceled_fare'       => $booking->bookedRooms->where('status', Status::ROOM_CANCELED)->sum('fare'),
            'canceled_tax_charge' => $booking->bookedRooms->where('status', Status::ROOM_CANCELED)->sum('tax_charge'),
            'payment_received'    => $booking->payments->where('type', 'BOOKING_PAYMENT_RECEIVED')->sum('amount'),
            'refunded'            => $booking->payments->where('type', 'BOOKING_PAYMENT_RETURNED')->sum('amount'),
        ];


        if (!$booking) {
            $notify[] = 'Booking not found';
            return response()->json([
                'remark' => 'booking_detail',
                'status' => 'error',
                'message' => ['success' => $notify],
            ]);
        }

        $notify[] = 'Booking Detail';
        return response()->json([
            'remark' => 'booking_detail',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'booking' => $booking,
                'bookedRooms' => $bookedRooms,
                'paymentInfo' =>  $paymentInfo
            ]
        ]);
    }
}
