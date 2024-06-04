@php
    $content = getContent('cta.content', true);
@endphp

<div class="cta-section bg-img wow fadeInUp" data-wow-duration="1">
    <div class="cta-section bg-img wow fadeInUp" data-wow-duration="1">
        <div class="container custom-container">
            <div class="cta-section__wrapper  bg-img" style="background-image: url({{ getImage('assets/images/frontend/cta/' . @$content->data_values->background_image, '1365x370') }});">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cta-left">
                            <div class="cta-left__thumb">
                                <img src="{{ getImage('assets/images/frontend/cta/' . @$content->data_values->image, '325x420') }}" alt="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 ps-lg-0">
                        <form action="{{ route('vendor.request') }}" method="GET">
                            <div class="cta-content">
                                <h2 class="cta-content__title">{{ __(@$content->data_values->heading) }}</h2>
                                <p class="cta-content__desc fs-18">{{ __(@$content->data_values->subheading) }}</p>
                                <div class="form-group cta-content__btn">
                                    <input type="email" class="form--control email_register" placeholder="@lang('Enter your Email')" name="email" value="{{ request()->email }}" required>
                                    <button type="submit" class="btn btn--base"> @lang('Register') </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
