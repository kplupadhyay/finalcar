<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->middleware('admin')->name('logout');
    });

    // Admin Password Reset
    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('reset');
        Route::post('reset', 'sendResetCodeEmail');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::middleware('admin')->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit')->name('request.report.submit');

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    // Users Manager
    Route::controller('ManageUsersController')->name('users.')->prefix('guests')->group(function () {
        Route::get('all', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email-verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');

        Route::get('deleted', 'deletedUsers')->name('deleted');
        Route::post('delete/{id}', 'deleteUser')->name('delete');
        Route::post('restore/{id}', 'restoreDeletedUser')->name('restore');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');

        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('list', 'list')->name('list');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
    });

    //manage vendor request 
    Route::controller('VendorRequestController')->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('request', 'vendorRequests')->name('request');
        Route::get('vendor-request/detail/{id}', 'requestDetail')->name('request.detail');
        Route::post('request/reject/{id}', 'rejectRequest')->name('request.reject');
        Route::post('request/approve/{id}', 'approveRequest')->name('request.approve');
    });

    //manage car vendor request
    Route::controller('VendorRequestController')->prefix('carvendor')->name('carvendor.')->group(function () {
        Route::get('request', 'vendorRequests')->name('request');
        Route::get('vendor-request/detail/{id}', 'requestDetail')->name('request.detail');
        Route::post('request/reject/{id}', 'rejectRequest')->name('request.reject');
        Route::post('request/approve/{id}', 'approveRequest')->name('request.approve');
    });

    // Owner Manager
    Route::controller('ManageOwnersController')->name('owners.')->prefix('hotels')->group(function () {
        Route::get('all', 'allOwners')->name('all');
        Route::get('active', 'activeOwners')->name('active');
        Route::get('banned', 'bannedOwners')->name('banned'); 

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');

        Route::get('setting/{id}', 'hotelSetting')->name('hotel.setting');
        Route::post('update-setting/{id}', 'updateHotelSetting')->name('hotel.setting.update');

        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');

        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('list', 'list')->name('list');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
        Route::post('feature/status/{id}', 'updateFeatureStatus')->name('feature.status.update');
    });


    //carowner manager
    Route::controller('CarManageOwnersController')->name('carowner.')->prefix('cars')->group(function () {
        Route::get('all', 'allOwners')->name('all');
        Route::get('active', 'activeOwners')->name('active');
        Route::get('banned', 'bannedOwners')->name('banned'); 

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');

        Route::get('setting/{id}', 'hotelSetting')->name('hotel.setting');
        Route::post('update-setting/{id}', 'updateHotelSetting')->name('hotel.setting.update');

        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');

        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('list', 'list')->name('list');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
        Route::post('feature/status/{id}', 'updateFeatureStatus')->name('feature.status.update');
    });

    //Location Setting
    Route::name('location.')->group(function () {
        Route::controller('CountryController')->name('country.')->prefix('country')->group(function () {
            Route::get('all', 'all')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
            Route::post('status/update/{id}', 'updateStatus')->name('status.update');
        });

        Route::controller('CityController')->name('city.')->prefix('city')->group(function () {
            Route::get('', 'all')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
        });

        Route::controller('LocationController')->prefix('location')->group(function () {
            Route::get('', 'all')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
        });
    });

    // carr
    Route::name('carlocation.')->group(function () {
        Route::controller('CarCountryController')->name('countr.')->prefix('countr')->group(function () {
            Route::get('all', 'all')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
            Route::post('status/update/{id}', 'updateStatus')->name('status.update');
        });

        Route::controller('CarCityController')->name('cit.')->prefix('cit')->group(function () {
            Route::get('', 'all')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
        });

        Route::controller('CarLocationController')->prefix('locatio')->group(function () {
            Route::get('', 'all')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
        });
    });

    Route::name('hotel.')->group(function () {
        //Amenity
        Route::controller('AmenitiesController')->name('amenity.')->prefix('amenities')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('save/{id?}', 'save')->name('save');
            Route::post('status/{id}', 'status')->name('status');
        });

        //Facility
        Route::controller('FacilityController')->name('facility.')->prefix('facility')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('add/{id?}', 'add')->name('add');
            Route::post('status/{id}', 'status')->name('status');
        });

        //Bed Type
        Route::controller('BedTypeController')->name('bed.')->prefix('bed')->group(function () {
            Route::get('', 'index')->name('all');
            Route::post('save/{id?}', 'save')->name('save');
        });
    });


    //ads management
    Route::controller('AdsController')->name('ads.')->prefix('ads')->group(function () {
        Route::get('all', 'all')->name('all');
        Route::post('add/{id?}', 'add')->name('add');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

    Route::controller('AdsController')->name('carads.')->prefix('carads')->group(function () {
        Route::get('all', 'all')->name('all');
        Route::post('add/{id?}', 'add')->name('add');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->group(function () {
        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->prefix('automatic')->name('automatic.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{code}', 'update')->name('update');
            Route::post('remove/{id}', 'remove')->name('remove');
            Route::post('status/{id}', 'status')->name('status');
        });

        // Manual Methods
        Route::controller('ManualGatewayController')->prefix('manual')->name('manual.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('new', 'create')->name('create');
            Route::post('new', 'store')->name('store');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });

    // DEPOSIT SYSTEM
    Route::controller('DepositController')->prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });

    //car deposit sysytem

    Route::controller('CarDepositController')->prefix('cardeposi')->name('cardeposi.')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });

    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('withdraw')->group(function () {

        Route::controller('WithdrawalController')->group(function () {
            Route::get('pending', 'pending')->name('pending');
            Route::get('approved', 'approved')->name('approved');
            Route::get('rejected', 'rejected')->name('rejected');
            Route::get('log', 'log')->name('log');
            Route::get('details/{id}', 'details')->name('details');
            Route::post('approve', 'approve')->name('approve');
            Route::post('reject', 'reject')->name('reject');
        });
//car withdraw



        // Withdraw Method
        Route::controller('WithdrawMethodController')->prefix('method')->name('method.')->group(function () {
            Route::get('/', 'methods')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('create', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });



    
    // Report
    Route::controller('ReportController')->prefix('report')->name('report.')->group(function () {
        Route::get('transaction', 'transaction')->name('transaction');
        Route::get('login/user/history', 'userLoginHistory')->name('user.login.history');
        Route::get('login/user/ipHistory/{ip}', 'userLoginIpHistory')->name('user.login.ipHistory');
        Route::get('login/owner/history', 'ownerLoginHistory')->name('owner.login.history');
        Route::get('login/owner/ipHistory/{ip}', 'ownerLoginIpHistory')->name('owner.login.ipHistory');
        Route::get('notification/history', 'notificationHistory')->name('notification.history');
        Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
    });

    // Admin Support
    Route::controller('SupportTicketController')->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/', 'tickets')->name('index');
        Route::get('pending', 'pendingTicket')->name('pending');
        Route::get('closed', 'closedTicket')->name('closed');
        Route::get('answered', 'answeredTicket')->name('answered');
        Route::get('view/{id}', 'ticketReply')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{ticket}', 'ticketDownload')->name('download');
        Route::post('delete/{id}', 'ticketDelete')->name('delete');
    });

    // Language Manager
    Route::controller('LanguageController')->prefix('language')->name('language.')->group(function () {
        Route::get('/', 'langManage')->name('manage');
        Route::post('/', 'langStore')->name('manage.store');
        Route::post('delete/{id}', 'langDelete')->name('manage.delete');
        Route::post('update/{id}', 'langUpdate')->name('manage.update');
        Route::get('edit/{id}', 'langEdit')->name('key');
        Route::post('import', 'langImport')->name('import.lang');
        Route::post('store/key/{id}', 'storeLanguageJson')->name('store.key');
        Route::post('delete/key/{id}', 'deleteLanguageJson')->name('delete.key');
        Route::post('update/key/{id}', 'updateLanguageJson')->name('update.key');
        Route::get('get-keys', 'getKeys')->name('get.key');
    });

    //Owner Request Form Setting
    Route::controller('OwnerFormController')->prefix('owner-form')->group(function () {
        Route::get('setting', 'setting')->name('owner.form.setting');
        Route::post('setting', 'settingUpdate');
    });

    Route::controller('GeneralSettingController')->group(function () {
        // General Setting
        Route::get('general-setting', 'index')->name('setting.index');
        Route::post('general-setting', 'update')->name('setting.update');

        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::post('setting/system-configuration', 'systemConfigurationSubmit')->name('setting.system.configuration.submit');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css', 'customCss')->name('setting.custom.css');
        Route::post('custom-css', 'customCssSubmit')->name('setting.custom.css.submit');

        //Cookie
        Route::get('cookie', 'cookie')->name('setting.cookie');
        Route::post('cookie', 'cookieSubmit')->name('setting.cookie.submit');

        //maintenance_mode
        Route::get('maintenance-mode', 'maintenanceMode')->name('maintenance.mode');
        Route::post('maintenance-mode', 'maintenanceModeSubmit')->name('maintenance.mode.submit');
    });

    Route::controller('CronConfigurationController')->name('cron.')->prefix('cron')->group(function () {
        Route::get('index', 'cronJobs')->name('index');
        Route::post('store', 'cronJobStore')->name('store');
        Route::post('update', 'cronJobUpdate')->name('update');
        Route::post('delete/{id}', 'cronJobDelete')->name('delete');
        Route::get('schedule', 'schedule')->name('schedule');
        Route::post('schedule/store', 'scheduleStore')->name('schedule.store');
        Route::post('schedule/status/{id}', 'scheduleStatus')->name('schedule.status');
        Route::get('schedule/pause/{id}', 'schedulePause')->name('schedule.pause');
        Route::get('schedule/logs/{id}', 'scheduleLogs')->name('schedule.logs');
        Route::post('schedule/log/resolved/{id}', 'scheduleLogResolved')->name('schedule.log.resolved');
        Route::post('schedule/log/flush/{id}', 'logFlush')->name('log.flush');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global', 'global')->name('global');
        Route::post('global/update', 'globalUpdate')->name('global.update');
        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate')->name('email.update');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate')->name('sms.update');
        Route::post('sms/test', 'smsTest')->name('sms.test');

        //Push setting
        Route::get('notification/push/setting', 'pushSetting')->name('push');
        Route::post('notification/push/setting', 'pushSettingUpdate');
    });

    // Plugin
    Route::controller('ExtensionController')->prefix('extensions')->name('extensions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });

    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
        Route::get('info', 'systemInfo')->name('info');
        Route::get('server-info', 'systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
        Route::get('system-update', 'systemUpdate')->name('update');
        Route::post('update-upload', 'updateUpload')->name('update.upload');
    });

    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo');

    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {

        Route::controller('FrontendController')->group(function () {
            Route::get('frontend-sections/{key}', 'frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
            Route::post('remove/{id}', 'remove')->name('remove');
            Route::post('import-content/{key}', 'importContent')->name('import');
        });

        // Page Builder
        Route::controller('PageBuilderController')->group(function () {
            Route::get('manage-pages', 'managePages')->name('manage.pages');
            Route::post('manage-pages/update', 'managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete/{id}', 'managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'manageSectionUpdate')->name('manage.section.update');
        });
    });
});
