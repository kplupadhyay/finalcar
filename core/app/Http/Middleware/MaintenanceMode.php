<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (gs('maintenance_mode') == Status::ENABLE) {
            if ($request->is('api/*')) {
                $notify[] = 'Our application is currently in maintenance mode';
                return response()->json([
                    'remark' => 'maintenance_mode',
                    'status' => 'error',
                    'message' => ['error' => $notify]
                ]);
            } else {
                return to_route('maintenance');
            }
        }
        return $next($request);
    }
}
