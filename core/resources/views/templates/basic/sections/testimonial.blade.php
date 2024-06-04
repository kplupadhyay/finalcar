@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', orderById: true);
    $singleTestomonial = ceil($testimonialElements->count() / 2);
    $testimonialElements = $testimonialElements->chunk($singleTestomonial);
@endphp

<section class="testimonials  pb-80" id="testimonial">
    <div class="container custom-container">
        <div class="section-heading ">
            <span class="section-heading__subtitle fs-24"> {{ __(@$testimonialContent->data_values->heading) }} </span>
            <h2 class="section-heading__title"> {{ __(@$testimonialContent->data_values->sub_heading) }} </h2>
        </div>
        <div class="testimonial-slider   wow fadeInUp" data-wow-duration="600ms">
            @foreach ($testimonialElements[0] as $testimonialElement)
                <div class="testimonials-card wow fadeInUp" data-wow-duration="1">
                    <div class="testimonial-item">
                        <div class="testimonial-item__content">
                            <div class="testimonial-item__rating">
                                @php
                                    $rating = @$testimonialElement->data_values->rating;
                                    $noRating = 5 - @$rating;
                                @endphp

                                <ul class="rating-list rating-two">
                                    @for ($i = 0; $rating > $i; $i++)
                                        <li class="rating-list__item"><i class="fas fa-star"></i></li>
                                    @endfor
                                    @for ($i = 0; $noRating > $i; $i++)
                                        <li class="rating-list__item"><i class="far fa-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <p class="testimonial-item__desc">
                                {{ __(@$testimonialElement->data_values->review) }}
                            </p>
                            <div class="testimonial-item__info">
                                <div class="testimonial-item__thumb">
                                    <img src="{{ getImage('assets/images/frontend/testimonial/' . @$testimonialElement->data_values->photo, '55x55') }}" class="fit-image" alt="profile Photo">
                                </div>
                                <div class="testimonial-item__details">
                                    <h6 class="testimonial-item__name"> {{ __(@$testimonialElement->data_values->name) }} </h6>
                                    <span class="testimonial-item__designation"> {{ __(@$testimonialElement->data_values->designation) }} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="testimonial-slider-rtl  wow fadeInUp" data-wow-duration="600ms" dir="rtl">
            @foreach ($testimonialElements[1] as $testimonialElement)
                <div class="testimonials-card wow fadeInUp" data-wow-duration="1">
                    <div class="testimonial-item">
                        <div class="testimonial-item__content">
                            <div class="testimonial-item__rating">
                                @php
                                    $rating = @$testimonialElement->data_values->rating;
                                    $noRating = 5 - @$rating;
                                @endphp

                                <ul class="rating-list rating-two">
                                    @for ($i = 0; $rating > $i; $i++)
                                        <li class="rating-list__item"><i class="fas fa-star"></i></li>
                                    @endfor
                                    @for ($i = 0; $noRating > $i; $i++)
                                        <li class="rating-list__item"><i class="far fa-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <p class="testimonial-item__desc">{{ __(@$testimonialElement->data_values->review) }}</p>
                            <div class="testimonial-item__info">
                                <div class="testimonial-item__details">
                                    <h6 class="testimonial-item__name"> {{ __(@$testimonialElement->data_values->name) }} </h6>
                                    <span class="testimonial-item__designation"> {{ __(@$testimonialElement->data_values->designation) }}</span>
                                </div>
                                <div class="testimonial-item__thumb">
                                    <img src="{{ getImage('assets/images/frontend/testimonial/' . @$testimonialElement->data_values->photo, '55x55') }}" class="fit-image" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
