<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class OwnerValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $owner = getParentOwner();

        $paymentDeadLine = null;
        if ($owner->expire_at != null) {
            $paymentDeadLine = Carbon::parse($owner->expire_at)->addDays(gs('payment_before'));
        }

        if (now() >= $paymentDeadLine) {
            if (!authOwner()->parent_id) {
                $notify[] = ['error', 'Your payment deadline has been exceed, you have to pay first'];
                return to_route('owner.dashboard')->withNotify($notify);
            }

            $notify[] = ['error', 'Payment deadline has been exceed'];
            return to_route('owner.profile')->withNotify($notify);
        }

        return $next($request);
    }
}
