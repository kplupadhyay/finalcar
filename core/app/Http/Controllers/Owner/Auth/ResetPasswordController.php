<?php

namespace App\Http\Controllers\Owner\Auth;

use App\Constants\Status;
use App\Models\Owner;
use App\Models\OwnerPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{
    /*
        |--------------------------------------------------------------------------
        | Password Reset Controller
        |--------------------------------------------------------------------------
        |
        | This controller is responsible for handling password reset requests
        | and uses a simple trait to include this behavior. You're free to
        | explore this trait and override any methods you wish to tweak.
        |
        */

    use ResetsPasswords;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/owner/dashboard';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('owner.guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token)
    {
        $pageTitle = "Account Recovery";
        $resetToken = OwnerPasswordReset::where('token', $token)->where('status', Status::ENABLE)->first();

        if (!$resetToken) {
            $notify[] = ['error', 'Verification code mismatch'];
            return to_route('owner.password.reset')->withNotify($notify);
        }
        $email = $resetToken->email;
        return view('owner.auth.passwords.reset', compact('pageTitle', 'email', 'token'));
    }


    public function reset(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|confirmed|min:4',
        ]);

        $reset = OwnerPasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $owner = Owner::where('email', $reset->email)->first();
        if ($reset->status == Status::DISABLE) {
            $notify[] = ['error', 'Invalid code'];
            return to_route('owner.login')->withNotify($notify);
        }

        $owner->password = Hash::make($request->password);
        $owner->save();
        $reset->status = Status::DISABLE;
        $reset->save();

        $ipInfo  = getIpInfo();
        $browser = osBrowser();
        notify($owner, 'PASS_RESET_DONE', [
            'operating_system' => $browser['os_platform'],
            'browser' => $browser['browser'],
            'ip'      => $ipInfo['ip'],
            'time'    => $ipInfo['time']
        ],['email'],false);

        $notify[] = ['success', 'Password changed'];
        return to_route('owner.login')->withNotify($notify);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('owners');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard('owner');
    }
}
