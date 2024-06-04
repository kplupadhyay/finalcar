@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('owner_request.content', true);
        $elements = getContent('owner_request.element', orderById: true);
    @endphp
    <section class="owner-request mt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center gy-4">
                <div class="col-lg-5">
                    <div class="get-facilities pe-lg-5">
                        <div class="section-heading style-left">
                            <h3 class="section-heading__title" s-break="-2">{{ __(@$content->data_values->heading) }}</h3>
                            <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                        </div>
                        @foreach ($elements as $item)
                            <div class="get-facilities__item">
                                <span class="get-facilities__icon"> @php echo $item->data_values->icon; @endphp </span>
                                <div class="get-facilities__conent">
                                    <h6 class="get-facilities__title">{{ __($item->data_values->title) }}</h6>
                                    <p class="get-facilities__desc">{{ __($item->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="owner-form">
                        <div class="card custom--card custom--card--lg">
                            <div class="card-header bg-transparent">
                                <h4 class="title fw-bold mb-2">{{ __(@$content->data_values->form_title) }}</h4>
                                <p class="desc fs-14">{{ __(@$content->data_values->form_subtitle) }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vendor.request.send') }}" method="POST" class="verify-gcaptcha">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Hotel Name')</label>
                                                <input type="text" class="form--control" name="hotel_name" value="{{ old('hotel_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Star Rating')</label>
                                                <select name="star_rating" class="form-select form--control">
                                                    <option value="" selected disabled>@lang('Select One')</option>
                                                    @for ($i = 1; $i <= $general->max_star_rating; $i++)
                                                        <option value="{{ $i }}" @selected(old('star_rating') == $i)>{{ $i }} @lang('Star')</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Country')</label>
                                                <select name="country" class="form-select form--control" required>
                                                    <option value="" selected disabled>@lang('Select One')</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" data-code="{{ $country->code }}" data-mobile_code="{{ $country->dial_code }}" @selected(old('country') == $country->id)>{{ __($country->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('City')</label>
                                                <select name="city" class="form-select form--control" required>
                                                    <option value="" selected disabled>@lang('Select Country First')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Location')</label>
                                                <select name="location" class="form-select form--control" required>
                                                    <option value="" selected disabled>@lang('Select City First')</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Vendor First Name')</label>
                                                <input type="text" name="firstname" class="form--control" value="{{ old('firstname') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Vendor Last Name')</label>
                                                <input type="text" name="lastname" class="form--control" value="{{ old('lastname') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="hidden" name="country_code" value="{{ old('country_code') }}">
                                            <input type="hidden" name="mobile_code" value="{{ old('mobile_code') }}">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Mobile')</label>
                                                <div class="input-group">
                                                    <span class="input-group-text mobileCode"></span>
                                                    <input type="number" name="mobile" class="form-control form--control checkUser" value="{{ old('mobile') }}" required>
                                                </div>
                                                <small class="text--danger mobileExist"></small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            @php
                                                $email = old('email');
                                                if (request()->email) {
                                                    $email = request()->email;
                                                }
                                            @endphp
                                            <div class="form-group">
                                                <label class="form-label">@lang('Email')</label>
                                                <input type="email" name="email" class="form--control checkUser" value="{{ $email }}" required>
                                                <small class="text--danger emailExist"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <x-captcha />
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn--base w-100">@lang('Send Request')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        "use strict";
        (function($) {
            let cities = @json($cities);
            let locations = @json($locations);

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobileCode').text('+' + $('select[name=country] :selected').data('mobile_code'));

                let countryId = $(this).val();
                let options = `<option value="" selected disabled>@lang('Select One')</option>`;
                $.each(cities, function(index, city) {
                    if (city.country_id == countryId) {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    }
                });

                $('select[name=city]').html(options);
            });

            $('select[name=city]').on('change', function() {
                let cityId = $(this).val();
                let options = `<option value="" selected disabled>@lang('Select One')</option>`;
                $.each(locations, function(index, location) {
                    if (location.city_id == cityId) {
                        options += `<option value="${location.id}">${location.name}</option>`;
                    }
                });

                $('select[name=location]').html(options);
            });


            var mobileCode = @json($mobileCode);

            if (mobileCode != null && $(`option[data-mobile_code="${mobileCode}"]`).length > 0) {
                $(`option[data-mobile_code=${mobileCode}]`).attr('selected', '');
            } else {
                $('select[name=country]').find('option:nth-child(2)').attr('selected', true);
            }

            $('select[name=country]').trigger("change");

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobileCode').text('+' + $('select[name=country] :selected').data('mobile_code'));


            @if (old('city'))
                $('select[name=country]').trigger("change");
                var cityId = "{{ old('city') }}";
                $('select[name=city]').val(cityId);
            @endif

            @if (old('location'))
                $('select[name=city]').trigger("change");
                var locationId = "{{ old('location') }}";
                $('select[name=location]').val(locationId);
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = "{{ route('vendor.check.user') }}";
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobileCode').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
