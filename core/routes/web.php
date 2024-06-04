<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});


Route::get('cron', 'CronController@cron')->name('cron');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('/new', 'openSupportTicket')->name('open');
    Route::post('/create', 'storeSupportTicket')->name('store');
    Route::get('/view/{ticket}', 'viewTicket')->name('view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('OwnerRequestController')->name('vendor.')->group(function () {
    Route::get('register-your-hotel', 'ownerRequest')->name('request');
    Route::post('check', 'checkOwner')->name('check.user');
    Route::post('send-request', 'sendRequest')->name('request.send');
    Route::post('send-form-data/{id}', 'storeFormData')->name('send.form.data');
});

Route::controller('SiteController')->group(function () {
    Route::post('/add/device/token', 'getDeviceToken')->name('add.device.token');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});
