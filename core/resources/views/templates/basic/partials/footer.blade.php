@php
    $policyPages = getContent('policy_pages.element', false, null, true);
    $socialElements = getContent('social_icon.element', orderById: true);
@endphp

@include($activeTemplate . 'sections.cta')
<footer class="footer">
    <div class="footer__inner">
        <div class="custom-container container">
            <div class="footer-wrapper">
                <div class="row g-4 justify-content-xl-between justify-content-center">
                    <div class="col-lg-2">
                        <a class="logo" href="{{ route('home') }}">
                            <img src="{{ siteLogo() }}" alt="">
                        </a>
                    </div>
                    <div class="col-lg-8">
                        <ul class="footer-list">
                            @foreach ($policyPages as $policy)
                                <li class="footer-list__item">
                                    <a class="link" href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"> {{ __($policy->data_values->title) }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <ul class="social-list">
                            @foreach ($socialElements as $socialElement)
                                <li class="social-list__item"><a class="social-list__link flex-center" href="{{ @$socialElement->data_values->url }}" target="_blank"> @php echo $socialElement->data_values->social_icon @endphp</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="footer-bottom">
                        <p class="footer-bottom__desc">
                            @lang('Copyright') &copy; {{ date('Y') }}. @lang('All Rights Reserved By') <a class="t-link" href="{{ route('home') }}">{{ __($general->site_name) }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
