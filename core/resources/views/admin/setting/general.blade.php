@extends('admin.layouts.app')
@section('panel')
    <div class="row ">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body ">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Site Title')</label>
                                    <input class="form-control" name="site_name" required type="text" value="{{ $general->site_name }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Site Currency')</label>
                                    <input class="form-control" name="cur_text" required type="text" value="{{ $general->cur_text }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Currency Symbol')</label>
                                    <input class="form-control" name="cur_sym" required type="text" value="{{ $general->cur_sym }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group select2-parent">
                                    <label> @lang('Timezone')</label>
                                    <select class="select2-basic" name="timezone">
                                        @foreach($timezones as $key => $timezone)
                                        <option value="{{ @$key}}">{{ __($timezone) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Site Base Color')</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 p-0">
                                            <input class="form-control colorPicker" type='text' value="{{ $general->base_color }}" />
                                        </span>
                                        <input class="form-control colorCode" name="base_color" type="text" value="{{ $general->base_color }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Maximum Star Rating')</label>
                                    <input class="form-control" min="3" name="max_star_rating" required type="number" value="{{ $general->max_star_rating ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>
                                        @lang('Popularity Count From')
                                        <i class="las la-info-circle text--info" title="@lang('The most popular hotels in recent times are determined by the number of bookings they have received. To ascertain their popularity, system count the bookings over a specific period of time, which you can set according to your preferences.')"></i>
                                    </label>
                                    <input autocomplete="off" class="form-control" min="1" name="popularity_count_from" required type="number" value="{{ $general->popularity_count_from ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Bill Per Month')</label>
                                    <div class="input-group">
                                        <input class="form-control" min="0" name="bill_per_month" required step="any" type="number" value="{{ getAmount($general->bill_per_month) }}">
                                        <span class="input-group-text site_currency">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Payment Before') <i class="las la-info-circle text--info" title="@lang('The owner must pay the monthly bill before the specified number of days has passed')"></i></label>
                                    <div class="input-group">
                                        <input class="form-control" min="0" name="payment_before" required type="number" value="{{ $general->payment_before }}">
                                        <span class="input-group-text">@lang('Days')</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Maximum Payment Month') <i class="las la-info-circle text--info" title="@lang('The owner can make a payment for the maximum allowable number of months')"></i></label>
                                    <div class="input-group">
                                        <input class="form-control" min="0" name="maximum_payment_month" required type="number" value="{{ $general->maximum_payment_month }}">
                                        <span class="input-group-text">@lang('Month')</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group select2-multiselect-parent">
                                    <label>@lang('Upcoming Bill Payment Remind Before')</label>
                                    <select class="select2-multi-select" multiple name="remind_before_days[]" required>
                                        @for ($i = 1; $i < $general->payment_before; $i++)
                                            <option @selected(in_array($i, $general->remind_before_days ?? [])) value="{{ $i }}">{{ $i . ' ' . __('Day Ago') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>
                                        @lang('App Video')
                                        <em><small class="text-muted text--info">@lang('Supported Files: mp4, mov, ogg, gt')</small></em>
                                    </label>
                                    <input type="file" name="app_video" class="form-control" @required($general->app_video == null)>
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
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/spectrum.css') }}" rel="stylesheet">
@endpush

@push('style')
    <style>
        .select2-parent,
        .select2-multiselect-parent {
            position: relative;
        }

        .tooltip {
            z-index: 9999999999;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

            $('select[name=timezone]').val("{{ $currentTimezone }}").select2();
            $('.select2-basic').select2({
                dropdownParent: $('.select2-parent')
            });

            $('[name=cur_text]').on('focusout', function() {
                var curText = $(this).val();
                $('.site_currency').text(curText);
            });

            $('.select2-multi-select').select2({
                dropdownParent: $('.select2-multiselect-parent')
            });
        })(jQuery);
    </script>
@endpush
