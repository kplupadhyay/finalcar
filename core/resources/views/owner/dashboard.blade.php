@extends('owner.layouts.app')

@section('panel')
    @if (authOwner()->parent_id == 0 && (authOwner()->expire_at == null || authOwner()->expire_at < now()->format('Y-m-d')))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bl--5-danger">
                    <div class="card-body">
                        <p class="fw-bold text--danger">@lang('Bill Payment Alert')</p>
                        <p>@lang('You won\'t be able to use the system without making your monthly bill payment. You can make your monthly bill payment') <a href="{{ route('owner.deposit.index') }}">@lang('here')...</a></p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget color="danger" icon="la la-sign-out transform-rotate-180" overlay_icon="0" link="owner.delayed.booking.checkout" style="2" title="Delayed Checkout" value="{{ $widget['delayed_checkout'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="warning" icon="la la-sign-in" link="owner.pending.booking.checkin" style="2" overlay_icon="0" title="Pending Check-In" value="{{ $widget['pending_checkin'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="info" icon="la la-sign-in" link="owner.upcoming.booking.checkin" style="2" overlay_icon="0" title="Upcoming Check-In" value="{{ $widget['upcoming_checkin'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="info" icon="la la-sign-out transform-rotate-180" link="owner.upcoming.booking.checkout" style="2" overlay_icon="0" title="Upcoming Checkout" value="{{ $widget['upcoming_checkout'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="dark" icon="la la-check-circle" icon_style="false" link="owner.booking.todays.booked" style="2" overlay_icon="0" title="Today's Booked Rooms" value="{{ $widget['today_booked'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="info" icon="la la-hospital-alt" icon_style="false" link="owner.booking.todays.booked" query_string="type=not_booked" style="2" overlay_icon="0" title="Today's Available Rooms" value="{{ $widget['today_available'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="success" icon="la la-clipboard-check" icon_style="false" link="owner.booking.active" style="2" overlay_icon="0" title="Active Booking" value="{{ $widget['active'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="primary" icon="la la-city" icon_style="false" link="owner.booking.all" style="2" overlay_icon="0" title="Total Bookings" value="{{ $widget['total'] }}" />
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap gap-1">
                        <h5 class="card-title">@lang('Monthly Booking Report') (@lang('Last 12 Months'))</h5>
                        <small>@lang('Excluding Tax')</small>
                    </div>
                    <div id="apex-bar-chart-1"> </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Payment Report') (@lang('Last 30 Days'))</h5>
                    <div id="apex-line"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/owner/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/owner/js/vendor/chart.js.2.8.0.js') }}"></script>

    <script>
        "use strict";

        var options = {
            series: [{
                name: 'Total Booking Amount',
                data: [
                    @foreach ($months as $month)
                        {{ getAmount(@$bookingMonth->where('months', $month)->first()->bookingAmount) }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 450,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($months),
            },
            yaxis: {
                title: {
                    text: "{{ __($general->cur_sym) }}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "{{ __($general->cur_sym) }}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart-1"), options);
        chart.render();

        var options = {
            chart: {
                height: 450,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#28c76f', '#ea5455', '#546E7A', '#E91E63', '#FF9800'],
            series: [{
                    name: "Received",
                    data: [
                        @foreach ($trxReport['date'] as $trxDate)
                            {{ @$plusTrx->where('date', $trxDate)->first()->amount ?? 0 }},
                        @endforeach
                    ]
                },
                {
                    name: "Returned",
                    data: [
                        @foreach ($trxReport['date'] as $trxDate)
                            {{ @$minusTrx->where('date', $trxDate)->first()->amount ?? 0 }},
                        @endforeach
                    ]
                }
            ],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: [
                    @foreach ($trxReport['date'] as $trxDate)
                        "{{ $trxDate }}",
                    @endforeach
                ]
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex-line"), options);
        chart.render();
    </script>
@endpush
