<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link href="{{ asset($activeTemplateTrue . 'css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/style.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">

    @stack('style-lib')

    @stack('style')

    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    @include($activeTemplate . 'partials.header')

    @if (!request()->routeIs('home'))
        <section class="text-cetner  pt-80 page-title-section">
            <h2 class="text-center">{{ @$pageTitle }}</h2>
        </section>
    @endif

    <main data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary" tabindex="0">
        @yield('content')
    </main>

    @include($activeTemplate . 'partials.footer')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie') && !Route::is('deposit.*'))
        <!-- cookies dark version start -->
        <div class="cookies-card custom-card hide text-center">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="cookies-card__content mt-4">{{ $cookie->data_values->short_desc }} <a class="text--base" href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
            <div class="cookies-card__btn mt-4">
                <a class="btn btn--base w-100 policy" href="javascript:void(0)">@lang('Allow')</a>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/bootstrap.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/popper.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/aos.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/navscroll.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/plugins.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @include('partials.plugins')

    @stack('script')

    @include('partials.notify')
    @include('partials.push_script')

    <script>
        (function($) {
            "use strict";


            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            var inputElements = $('[type=text],[type=password],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);


            let elements = document.querySelectorAll('[s-break]');

            Array.from(elements).forEach(element => {
                let html = element.innerHTML;

                if (typeof html != 'string') {
                    return false;
                }

                let breakFrom = parseInt(element.getAttribute('s-break'));
                html = html.split(" ");
                let breakLength = element.getAttribute('s-length') != null ? parseInt(element.getAttribute('s-length')) : html.length;

                var prepend = [];
                var styledText = [];
                var append = [];

                if (breakFrom < 0) {
                    var startFrom = html.length + breakFrom;
                    prepend = html.slice(0, startFrom);
                    styledText = html.slice(startFrom, breakLength);
                    append = html.slice(startFrom + breakLength, html.length);

                } else {
                    breakFrom = breakFrom - 1;
                    prepend = html.slice(0, breakFrom);
                    styledText = html.slice(breakFrom, breakFrom + breakLength);
                    append = html.slice(breakFrom + breakLength, html.length);
                }

                var classLists = element.getAttribute('s-class') || "fw--bolder";

                styledText = `<span class="${classLists}">${styledText.toString().replaceAll(',', ' ')}</span>`;
                prepend = prepend.toString().replaceAll(',', ' ');
                append = append.toString().replaceAll(',', ' ');

                element.innerHTML = `${prepend} ${styledText} ${append}`;
            });

            $('#payment-form').on('submit', function() {
                $(this).find('button[type=submit]').html(`<span class="spinner-border spinner-border-sm"></span>`)
            })
        })(jQuery);
    </script>
</body>

</html>
