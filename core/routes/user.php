<?php

use Illuminate\Support\Facades\Route;



Route::name('user.')->group(function () {
    Route::middleware('auth')->group(function () {
     
        Route::middleware(['check.status'])->group(function () {


            // Payment
            Route::controller('Gateway\PaymentController')->prefix('payment')->name('deposit.')->group(function () {
                Route::any('/', 'deposit')->name('index');
                Route::post('insert', 'depositInsert')->name('insert');
                Route::get('confirm', 'depositConfirm')->name('confirm');
                Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
                Route::post('manual', 'manualDepositUpdate')->name('manual.update');
            });
        });
    });
});
