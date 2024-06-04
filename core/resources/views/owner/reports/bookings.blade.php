@extends('owner.layouts.app')

@section('panel')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <x-widget overlay_icon="0" color="primary" icon="las la-list" style="2" icon_style="solid" title="Total Bookings" value="{{ $insights['total_bookings'] }}" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget overlay_icon="0" color="dark" icon="las la-money-bill" style="2" icon_style="solid" title="Total Amount" value="{{ $general->cur_sym . showAmount($insights['total_amount']) }}" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget overlay_icon="0" color="success" icon="las la-wallet" style="2" icon_style="solid" title="Total Paid Amount" value="{{ $general->cur_sym . showAmount($insights['paid_amount']) }}" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget overlay_icon="0" color="danger" icon="las la-hand-holding-usd" style="2" icon_style="solid" title="Total Due Amount" value="{{ $general->cur_sym . showAmount($insights['due_amount']) }}" />
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Booking Number')</th>
                                    <th>@lang('Booked At')</th>
                                    <th>@lang('Check-In')</th>
                                    <th>@lang('Checkout')</th>
                                    <th>@lang('Guest')</th>
                                    <th>@lang('Days')</th>
                                    <th>@lang('Rooms')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Paid')</th>
                                    <th>@lang('Due')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td><a href="{{ route('owner.booking.details', $booking->id) }}">#{{ $booking->booking_number }}</a></td>
                                        <td>{{ showDateTime($booking->created_at, 'd M, Y h:iA') }}</td>
                                        <td>{{ showDateTime($booking->check_in, 'd M, Y') }}</td>
                                        <td>{{ showDateTime($booking->check_out, 'd M, Y') }}</td>
                                        <td>
                                            @if ($booking->user_id)
                                                <span class="fw-bold">{{ $booking->user->fullname }}</span>
                                            @elseif($booking->guest_id)
                                                <span class="fw-bold">{{ $booking->guest->name }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->stayingDays() }}</td>
                                        <td>{{ $booking->bookedRooms->count() }}</td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($booking->total_amount) }} {{ __($general->cur_text) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text--success">
                                                {{ showAmount($booking->paid_amount) }} {{ __($general->cur_text) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text--danger">
                                                {{ showAmount($booking->due_amount) }} {{ __($general->cur_text) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($bookings->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($bookings) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">@lang('Filter Bookings')</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="" method="GET">
                <div class="form-group">
                    <label>@lang('Check-In')</label>
                    <input autocomplete="off" class="datepicker-here form-control" data-language="en" data-multiple-dates-separator=" - " data-position='bottom right' data-range="true" name="check_in" type="text" value="{{ request()->check_in }}">
                </div>

                <div class="form-group">
                    <label>@lang('Checkout')</label>
                    <input autocomplete="off" class="datepicker-here form-control" data-language="en" data-multiple-dates-separator=" - " data-position='bottom right' data-range="true" name="check_out" type="text" value="{{ request()->check_out }}">
                </div>

                <div class="form-group">
                    <label>@lang('Booked On')</label>
                    <input autocomplete="off" class="datepicker-here form-control" data-language="en" data-multiple-dates-separator=" - " data-position='bottom right' data-range="true" name="created_at" type="text" value="{{ request()->created_at }}">
                </div>

                <div class="form-group">
                    <label>@lang('Booking Number')</label>
                    <input class="form-control" name="booking_number" placeholder="@lang('Booking Number')" type="text" value="{{ request()->booking_number }}">
                </div>

                <div class="form-group">
                    <label>@lang('Guest')</label>
                    <input class="form-control" name="guest" type="text" placeholder="@lang('Name / Email')" value="{{ request()->guest }}">
                </div>

                <div class="form-group">
                    <label>@lang('Room Type')</label>
                    <select name="room_type_id" class="form-control">
                        <option value="">@lang('Any')</option>
                        @foreach ($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" @selected(request()->room_type_id == $roomType->id)>{{ __($roomType->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>@lang('Room')</label>
                    <select name="room_number" class="form-control">
                        <option value="">@lang('Any')</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_number }}" @selected(request()->room_number == $room->room_number)>{{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-grow-1 align-self-end">
                    <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn--primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"> <i class="las la-filter"></i>@lang('Filter')</button>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker({});
            }
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .btn-close:focus {
            outline: 0;
            box-shadow: none;
        }

        .datepickers-container {
            z-index: 9999 !important;
        }
    </style>
@endpush
