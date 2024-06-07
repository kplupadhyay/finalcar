@extends('admin.layouts.app')
@section('panel')
    <div class="row ">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.owners.hotel.setting.update', $setting->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xxl-4">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader :imagePath="getImage(getFilePath('hotelImage') . '/' . @$setting->image, getFileSize('hotelImage'))" :required="false" class="w-100" type="hotelImage" />
                                </div>
                            </div>
                            <div class="col-xxl-8">
                                <div class="row">
                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Name')</label>
                                            <input class="form-control" name="name" required type="text" value="{{ old('name', @$setting->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Star Rating')</label>
                                            <select class="form-control" name="star_rating" required>
                                                <option disabled selected value="">@lang('Select One')</option>
                                                @for ($i = 1; $i <= $general->max_star_rating; $i++)
                                                    <option @selected(old('star_rating', @$setting->star_rating) == $i) value="{{ $i }}">{{ $i }} @lang('Star')</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Address')</label>
                                            <input class="form-control" name="hotel_address" required type="text" value="{{ old('hotel_address', @$setting->hotel_address) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Latitude')</label>
                                            <input class="form-control" name="latitude" required step="any" type="number" value="{{ old('latitude', @$setting->latitude ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Longitude')</label>
                                            <input class="form-control" name="longitude" required step="any" type="number" value="{{ old('longitude', @$setting->longitude ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group select2-parent position-relative">
                                            <label> @lang('Country')</label>
                                            <select class="select2-basic allCountries" name="country_id" required>
                                                <option disabled selected value="">@lang('Select One')</option>
                                                @foreach ($countries as $country)
                                                    <option @selected(old('country_id', @$setting->country_id) == $country->id) data-cities="{{ $country->cities }}" value="{{ $country->id }}">{{ __($country->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group select2-parent position-relative">
                                            <label>@lang('City')</label>
                                            <select class="select2-basic allCities" name="city_id" required>
                                                <option disabled selected value="">@lang('Select Country First')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group select2-parent position-relative">
                                            <label>@lang('Location')</label>
                                            <select class="select2-basic allLocations" name="location_id" required>
                                                <option disabled selected value="">@lang('Select City First')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label>@lang('Tax Name')</label>
                                            <input class="form-control" name="tax_name" required type="text" value="{{ old('tax_name', @$setting->tax_name) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label>@lang('Tax Percentage')</label>
                                            <div class="input-group">
                                                <input class="form-control" min="0" name="tax_percentage" required step="any" type="number" value="{{ old('tax_percentage', @$setting->tax_percentage) }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Check In Time')</label>
                                            <div class="input-group">
                                                <input autocomplete="off" class="form-control" name="checkin_time" placeholder="--:--" required type="time" value="{{ old('checkin_time', @$setting->checkin_time ? showDateTime(@$setting->checkin_time, 'H:i') : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-4">
                                        <div class="form-group">
                                            <label> @lang('Checkout Time')</label>
                                            <div class="input-group">
                                                <input autocomplete="off" class="form-control" name="checkout_time" placeholder="--:--" required type="time" value="{{ old('checkout_time', @$setting->checkout_time ? showDateTime(@$setting->checkout_time, 'H:i') : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('Upcoming Check-In List') <i class="las la-info-circle" title="@lang('The number of days of data you want to see in the upcoming check-in list.')"></i></label>
                                            <div class="input-group">
                                                <input class="form-control" min="1" name="upcoming_checkin_days" required type="number" value="{{ old('upcoming_checkin_days', @$setting->upcoming_checkin_days) }}">
                                                <span class="input-group-text">@lang('Days')</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('Upcoming Checkout List') <i class="las la-info-circle" title="@lang('The number of days of data you want to see in the upcoming checkout list.')"></i></label>
                                            <div class="input-group">
                                                <input class="form-control" min="1" name="upcoming_checkout_days" required type="number" value="{{ old('upcoming_checkout_days', @$setting->upcoming_checkout_days) }}">
                                                <span class="input-group-text">@lang('Days')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Description')</label>
                                    <textarea class="form-control" name="description" required rows="6">{{ old('description', @$setting->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Cancellation Policy')</label>
                                    <textarea name="cancellation_policy" rows="6" class="form-control" required>{{ old('cancellation_policy', @$setting->cancellation_policy) }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <div class="d-flex justify-content-start flex-wrap gap-2">
                                        <label>@lang('Cover Photo')</label>
                                        
                                    </div>
                                    <div class="input-images"></div>
                                    <small class="fs-12">@lang('Supported Files'): <b>@lang('.png'), @lang('.jpg'), @lang('.jpeg')</b>. @lang('Image will be resized into') <b>{{ getFileSize('coverPhoto') }}</b>@lang('px')</small>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/image-uploader.min.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/image-uploader.min.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            @if (isset($images))
                let preloaded = @json($images);
            @else
                let preloaded = [];
            @endif

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'cover_photos',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 6
            });

            $('.select2-auto-tokenize').select2({
                dropdownParent: $('.select2Parent'),
                tags: true,
                tokenSeparators: [',']
            });

            $('.allCountries').on('change', function() {
                let cities = $(this).find('option:selected').data('cities');
                if (cities != undefined && cities.length > 0) {
                    var options = `<option value="" selected disabled>@lang('Select One')</option>`;
                    $.each(cities, function(index, city) {
                        var locationsString = encodeURIComponent(JSON.stringify(city.locations));
                        options += `<option value="${city.id}" data-locations="${locationsString}">${city.name}</option>`
                    });

                    $('.allCities').html(options);

                    options = `<option value="" selected disabled>@lang('Select City First')</option>`;
                    $('.allLocations').html(options);
                }
            }).change();

            @if (@$setting || old('city_id'))
                var cityId = "{{ old('city_id', @$setting->city_id) }}";
                $('.allCities').val(cityId);
            @endif

            $('.allCities').on('change', function() {
                let locations = $(this).find('option:selected').data('locations');
                if (locations != undefined) {
                    locations = JSON.parse(decodeURIComponent(locations));
                    if (locations.length > 0) {
                        var options = `<option value="" selected disabled>@lang('Select One')</option>`;

                        $.each(locations, function(index, location) {
                            options += `<option value="${location.id}">${location.name}</option>`
                        });

                        $('.allLocations').html(options);
                    }
                }
            }).change();

            @if (@$setting || old('location_id'))
                var locationId = "{{ old('location_id', @$setting->location_id) }}";
                $('.allLocations').val(locationId);
            @endif

            $.each($('.select2-basic'), function(index, element) {
                var dropdownParent = $(this).parents('.select2-parent');
                $(element).select2({
                    dropdownParent: dropdownParent
                })
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .select2-container {
            z-index: unset !important;
        }

    </style>
@endpush
