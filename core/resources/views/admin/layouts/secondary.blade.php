<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>

    <link href="{{ getImage(getFilePath('logoIcon') . '/favicon.png') }}" rel="shortcut icon" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">
    @stack('style-lib')
    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">

    <style>
        .body-wrapper,
        .navbar-wrapper {
            margin-left: 0;
        }

        .topnav-logo {
            width: 210px;
            height: 40px;
        }
    </style>
    @stack('style')
</head>

<body>
    <div class="page-wrapper default-version">
        @include('admin.partials.secondary_topnav')
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">{{ __($pageTitle) }}</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        @if (authAdmin()->role_id == Status::CASHIER)
                            <a class="btn btn-sm @if (Route::is('admin.cashier.pos')) btn--primary @else btn-outline--primary @endif" href="{{ route('admin.cashier.pos') }}"><i class="las la-shopping-cart"></i>@lang('POS')</a>
                            <a @if (Route::is('admin.cashier.pos')) target="_blank" @endif class="btn btn-sm @if (Route::is('admin.cashier.food.list')) btn--primary @else btn-outline--primary @endif" href="{{ route('admin.cashier.food.list') }}"><i class="las la-hamburger"></i>@lang('Food List')</a>
                            <a @if (Route::is('admin.cashier.pos')) target="_blank" @endif class="btn btn-sm @if (Route::is('admin.cashier.sales')) btn--primary @else btn-outline--primary @endif" href="{{ route('admin.cashier.sales') }}"><i class="las la-money-check-alt"></i>@lang('Sales')</a>
                        @endif
                        @stack('breadcrumb-plugins')
                    </div>
                </div>
                
                @yield('panel')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/jquery.slimscroll.min.js') }}"></script>

    @include('partials.notify')
    @stack('script-lib')

    <script src="{{ asset('assets/admin/js/vendor/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    @stack('script')

</body>

</html>
