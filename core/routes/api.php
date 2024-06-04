<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->name('api.')->group(function () {
    Route::controller('AppController')->group(function () {
        Route::get('general-setting', 'generalSetting');
        Route::get('get-countries', 'countries');
        Route::get('popular-hotels', 'getPopularHotels');
        Route::get('popular-cities', 'popularCities');
        Route::get('search-cities', 'searchCities');
        Route::get('featured-hotels', 'featuredHotels');
        Route::get('language/{code}', 'language');
        Route::get('policies', 'policies');
    });

    Route::namespace('Auth')->group(function () {
        Route::post('login', 'LoginController@login');
        Route::post('social-login', 'LoginController@socialLogin');
        Route::post('register', 'RegisterController@register');

        Route::controller('ForgotPasswordController')->group(function () {
            Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
            Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
            Route::post('password/reset', 'reset')->name('password.update');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        //authorization
        Route::controller('AuthorizationController')->group(function () {
            Route::get('authorization', 'authorization')->name('authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
            Route::post('verify-email', 'emailVerification')->name('verify.email');
            Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
            Route::post('verify-g2fa', 'g2faVerification')->name('go2fa.verify');
        });

        Route::middleware(['check.status'])->group(function () {
            Route::post('user-data-submit', 'UserController@userDataSubmit')->name('data.submit');
            Route::post('save/device/token', 'UserController@saveDeviceToken');

            Route::middleware('registration.complete')->group(function () {

                Route::controller('UserController')->group(function () {
                    Route::get('home', 'home');
                    Route::get('dashboard', 'dashboard');
                    Route::get('user-info', 'userInfo');

                    //Report
                    Route::any('payment/history', 'paymentHistory');
                    Route::get('transactions', 'transactions')->name('transactions');

                    //Profile Setting 
                    Route::post('profile-setting', 'submitProfile');
                    Route::post('change-password', 'submitPassword');

                    //booking history
                    Route::get('booking/history', 'bookingHistory');
                    Route::get('booking/detail/{id}', 'bookingDetail');

                    //notification logs 
                    Route::get('notification-logs', 'notificationLog');
                });

                //Profile setting
                Route::controller('HotelController')->prefix('hotel')->group(function () {
                    Route::get('search', 'search');
                    Route::get('filter-by-city/{id}', 'filterByCity');
                    Route::get('filter-parameters', 'getFilterParameters');
                    Route::get('detail/{id}', 'detail');
                });

                //Booking Request
                Route::controller('BookingRequestController')->prefix('booking-request')->group(function () {
                    Route::get('history', 'history');
                    Route::post('delete/{id}', 'delete');
                    Route::post('send', 'sendRequest');
                });

                // Payment
                Route::controller('PaymentController')->prefix('payment')->group(function () {
                    Route::get('methods/{bookingId}', 'methods');
                    Route::post('insert', 'paymentInsert');
                    Route::get('confirm', 'paymentConfirm');
                    Route::get('manual', 'manualPaymentConfirm');
                    Route::post('manual', 'manualPaymentUpdate');
                });
            });
        });

        Route::get('logout', 'Auth\LoginController@logout');
        Route::post('delete-account', 'Auth\LoginController@deleteAccount');
    });
});
