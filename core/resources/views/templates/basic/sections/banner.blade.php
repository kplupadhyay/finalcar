@php
    $bannerContent = getContent('banner.content', true);
@endphp
<section class="banner-section section-style">
    <div class="hero-section bg-overlay" style="background-image: url({{ getImage('assets/images/frontend/banner/' . @$bannerContent->data_values->image, '1885x995') }});">
        <div class="hero-section-content">
            <div class="custom-container container">
                <div class="row justify-content-center gy-5 align-items-center">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h1 class="hero-title" data-color="title-base" data-break="-3">{{ @$bannerContent->data_values->heading }}</h1>

                            <p class="hero-description"> {{ @$bannerContent->data_values->subheading }} </p>

                            <div class="hero-content">
                                <div class="d-flex hero-button-wrapper justify-content-center flex-wrap gap-2">
                                    <a class="btn btn--base" href="{{ @$bannerContent->data_values->android_download_link }}" target="_blank">
                                        <i class="fab fa-google-play"></i> @lang('Play Store')</a>

                                    <a class="btn btn-outline--base" href="{{ @$bannerContent->data_values->iso_download_link }}" target="_blank"><i class="fab fa-app-store"></i> @lang('App Store')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include($activeTemplate . 'sections.dashboard')

@push('script-lib')
    <script>
        (function($) {
            "use strict";

            let elements = document.querySelectorAll('[data-break]');

            Array.from(elements).forEach(element => {
                let html = element.innerHTML;
                if (typeof html != 'string') {
                    return false;
                }
                let breakLength = parseInt(element.getAttribute('data-break'));
                html = html.split(" ");
                var colorText = [];
                if (breakLength < 0) {
                    colorText = html.slice(breakLength);
                } else {
                    colorText = html.slice(0, breakLength);
                }
                let solidText = [];
                html.filter(ele => {
                    if (!colorText.includes(ele)) {
                        solidText.push(ele);
                    }
                });

                var color = element.getAttribute('data-color');
                var mainColor = colorText.slice(0, 2);
                var available = colorText.slice(2, 3);

                colorText = `<span class="${color}">${mainColor.toString().replaceAll(',', ' ')} <span class="text-white">${available}</span></span>`;
                solidText = solidText.toString().replaceAll(',', ' ');
                breakLength < 0 ? element.innerHTML = `${solidText} ${colorText}` : element.innerHTML = `${colorText} ${solidText}`
            });

        })(jQuery);
    </script>
@endpush
