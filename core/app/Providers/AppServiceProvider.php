<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\OwnerNotification;
use App\Models\Booking;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\BookingRequest;
use App\Models\Owner;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!cache()->get('SystemInstalled')) {
            $envFilePath = base_path('.env');
            $envContents = file_get_contents($envFilePath);
            if (empty($envContents)) {
                header('Location: install');
                exit;
            } else {
                cache()->put('SystemInstalled', true);
            }
        }

        $general        = gs();
        $activeTemplate = activeTemplate();

        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['emptyMessage']       = 'No data found';

        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'            => User::banned()->count(),
                'emailUnverifiedUsersCount'   => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'  => User::mobileUnverified()->count(),
                'pendingTicketCount'          => SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingDepositsCount'        => Deposit::pending()->count(),
                'bannedOwnersCount'           => Owner::owner()->banned()->count(),
                'pendingDepositsCount'        => Deposit::pending()->count(),
                'ownerRequestCount'           => Owner::ownerRequest()->count(),
                'pendingWithdrawCount'        => Withdrawal::pending()->count(),
            ]);
        });


        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'     => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });


        view()->composer('owner.partials.sidenav', function ($view) {
            $view->with([
                'bookingRequestCount'    => BookingRequest::currentOwner()->initial()->count(),
                'delayedCheckoutCount'       => Booking::currentOwner()->delayedCheckout()->count(),
                'refundableBookingCount'     => Booking::currentOwner()->refundable()->count(),
                'pendingCheckInsCount'    => Booking::currentOwner()->active()->keyNotGiven()->whereDate('check_in', '<=', now())->count()
            ]);
        });

        view()->composer('owner.partials.topnav', function ($view) {
            $view->with([
                'ownerNotifications'     => OwnerNotification::currentOwner()->where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'ownerNotificationCount' => OwnerNotification::currentOwner()->where('is_read', Status::NO)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();
    }
}
