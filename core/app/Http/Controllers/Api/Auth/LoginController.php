<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        parent::__construct();
        $this->username = $this->findUsername();
    }

    public function login(Request $request)
    {

        $validator = $this->validateLogin($request);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $credentials           = request([$this->username, 'password']);
        $credentials['status'] = Status::USER_ACTIVE;

        if (!Auth::attempt($credentials)) {
            $response[] = "credential doesn't match";
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $response],
            ]);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('auth_token')->plainTextToken;
        $this->authenticated($user);
        $response[] = 'Login Successful';
        return response()->json([
            'remark' => 'login_success',
            'status' => 'success',
            'message' => ['success' => $response],
            'data' => [
                'user' => auth()->user(),
                'access_token' => $tokenResult,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    public function socialLogin(Request $request)
    {
        $rules = [
            'social_id' => 'required',
            'email' => 'required|email',
            'name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = User::where('social_id', $request->social_id)->where('email', $request->email)->first();

        if (!$user) {
            $checkSocialId = User::where('social_id', $request->social_id)->exists();
            if ($checkSocialId) {
                $notify[] = 'Invalid social id provided';
                return response()->json([
                    'remark' => 'validation_error',
                    'status' => 'error',
                    'message' => ['error' => $notify],
                ]);
            }

            $checkEmail = User::where('email', $request->email)->exists();
            if ($checkEmail) {
                $notify[] = 'Invalid email provided';
                return response()->json([
                    'remark' => 'validation_error',
                    'status' => 'error',
                    'message' => ['error' => $notify],
                ]);
            }

            $nameData = explode(" ", $request->name);

            $firstName = $nameData[0];
            $lastName = $nameData[1] ?? null;

            $user = new User();
            $user->firstname = $firstName;
            $user->lastname = $lastName;
            $user->social_id = $request->social_id;
            $user->email = $request->email;
            $user->password = Hash::make('111111');
            $user->ev = Status::VERIFIED;
            $user->sv = Status::VERIFIED;
            $user->profile_complete = Status::NO;
            $user->save();

            $user->username = explode("@", $request->email)[0] . $user->id;
            $user->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'New member registered';
            $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
            $adminNotification->save();
        }


        Auth::login($user);
        $tokenResult = $user->createToken('auth_token')->plainTextToken;
        $this->authenticated($user);

        $notify[] = 'Successfully logged in';
        return response()->json([
            'remark' => 'login_success',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'user' => $user,
                'token_type' => 'Bearer',
                'access_token' => $tokenResult
            ]
        ]);
    }

    public function findUsername()
    {
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin(Request $request)
    {
        $validation_rule = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $validation_rule);
        return $validate;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        $notify[] = 'Logout successful';
        return response()->json([
            'remark' => 'logout',
            'status' => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function deleteAccount()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        $user->delete();

        $notify[] = 'Account deleted successfully';
        return response()->json([
            'remark' => 'account_delete',
            'status' => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function authenticated($user)
    {
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',', $info['long']);
            $userLogin->latitude =  @implode(',', $info['lat']);
            $userLogin->city =  @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();
    }
}
