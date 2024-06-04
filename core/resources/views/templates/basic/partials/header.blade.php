<header class="site-header {{ request()->routeIs('home') ? '' : 'header-two' }}" id="fixed-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt=""></a>

            <div class="purchase-button d-block d-lg-none">
                <a class="btn btn--base pill" href="{{ route('vendor.request') }}"> @lang('Register Your Hotel') </a>
            </div>
            <div class="purchase-button d-lg-block d-none">
                <a class="btn btn--base pill" href="{{ route('vendor.request') }}"> @lang('Register Your Hotel') </a>
            </div>
        </nav>
    </div>
</header>

@push('script')
    <script>
        (function($) {
            const whiteLogo = `{{ siteLogo() }}`;
            const darkLogo = `{{ siteLogo('dark') }}`;
            const logoContainer = $('.navbar-brand.logo');

            $(window).on('scroll', function() {
                if ($(window).scrollTop() >= 350) {
                    $('.site-header').addClass('fixed-header');
                    logoContainer.find('img').attr('src', darkLogo);
                } else {
                    $('.site-header').removeClass('fixed-header');
                    logoContainer.find('img').attr('src', whiteLogo);
                }
            });

        })(jQuery)
    </script>
@endpush
