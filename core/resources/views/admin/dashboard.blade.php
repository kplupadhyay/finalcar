@extends('admin.layouts.app')

@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-warning mb-3 text-white">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version') {{ json_decode($general->system_info)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border--primary border" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget color="primary" icon="las la-users" link="admin.users.all" style="2" overlay_icon="0" title="Total Users" value="{{ $widget['total_users'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="primary" icon="las la-user-friends" link="admin.owners.all" style="2" overlay_icon="0" title="Total Hotel" value="{{ $widget['total_owners'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="warning" icon="las la-wallet" link="admin.deposit.pending" style="2" overlay_icon="0" title="Pending Payments" value="{{ $widget['payment_pending'] }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget color="dark" icon="las la-ticket-alt" link="admin.ticket.pending" style="2" overlay_icon="0" title="Pending Tickets" value="{{ $widget['pending_tickets'] }}" />
        </div>
    </div>

    <div class="row gy-4 mt-0">
        <div class="col-xxl-6 col-md-12">
            <h5 class="mb-1">@lang('Top Hotels')</h5>
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Vendor')</th>
                                    <th>@lang('Total Booking')</th>
                                    <th>@lang('Location')</th>
                                    <th>@lang('Country')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topHotels as $hotel)
                                    <tr> 
                                        <td>{{ __(strLimit(@$hotel->hotelSetting->name,15)) }}</td>
                                        <td><a href="{{ route('admin.owners.detail', $hotel->id) }}">{{ __($hotel->fullname) }}</a></td>
                                        <td>{{ $hotel->total_booking }}</td>
                                        <td>{{ __(@$hotel->hotelSetting->city->name) }}</td>
                                        <td>{{ __(@$hotel->hotelSetting->city->country->name) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-md-12">
            <h5 class="mb-1">@lang('Most Booked Cities')</h5>
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Total Hotel')</th>
                                    <th>@lang('Total Booking')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mostBookedCities as $mostBookedCity)
                                    <tr>
                                        <td>{{ __($mostBookedCity->name) }}</td>
                                        <td>{{ __($mostBookedCity->country) }}</td>
                                        <td>{{ $mostBookedCity->total_hotel }}</td>
                                        <td>{{ $mostBookedCity->total_booking }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-0">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Bill Payment & Withdraw Report') (@lang('Last 12 Month'))</h5>
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $lastCron = Carbon\Carbon::parse($general->last_cron)->diffInSeconds();
    @endphp

    @if ($lastCron >= 900)
        @include('admin.partials.cron')
    @endif
@endsection

@push('breadcrumb-plugins')
    <span class="{{ $lastCron >= 900 ? 'text--danger' : 'text--primary' }}">@lang('Last Cron Run:')
        <strong>{{ diffForHumans($general->last_cron) }}</strong>
    </span>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script>
        "use strict";

        var options = {
            series: [{
                name: 'Total Bill Payment',
                data: [
                    @foreach ($months as $month)
                        {{ getAmount(@$billPayments->where('months', $month)->first()->amount) }},
                    @endforeach
                ]
            }, {
                name: 'Total Withdraw',
                data: [
                    @foreach ($months as $month)
                        {{ getAmount(@$withdrawalMonth->where('months', $month)->first()->withdrawAmount) }},
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
                    columnWidth: '50%'
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
        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();
    </script>
@endpush
