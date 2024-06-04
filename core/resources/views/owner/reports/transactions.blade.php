@extends('owner.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end">
                <button class="btn btn-outline--primary showFilterBtn btn-sm" type="button"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input autocomplete="off" class="datepicker-here form-control" data-language="en" data-multiple-dates-separator=" - " data-position='bottom right' data-range="true" name="date" type="text" value="{{ request()->date }}">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('TRX')</label>
                                <input class="form-control" name="search" type="text" value="{{ request()->search }}">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="form-control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    <option value="deposit">@lang('Deposit')</option>
                                    <option value="payment">@lang('Payment')</option>
                                    <option value="withdraw">@lang('Withdraw')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Type')</label>
                                <select class="form-control" name="trx_type">
                                    <option value="">@lang('All')</option>
                                    <option @selected(request()->trx_type == '+') value="+">@lang('Plus')</option>
                                    <option @selected(request()->trx_type == '-') value="-">@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('TRX')</th>
                                    <th>@lang('Transacted')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td>#{{ $trx->trx }}</td>

                                        <td>
                                            <em>{{ showDateTime($trx->created_at) }}</em>
                                            <br>
                                            <small class="text-muted">{{ diffForHumans($trx->created_at) }}</small>
                                        </td>

                                        <td class="budget">
                                            <span class="@if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                                {{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ $general->cur_text }}
                                            </span>
                                        </td>

                                        <td class="budget">
                                            {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                        </td>

                                        <td><small>{{ __($trx->details) }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($transactions->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($transactions) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

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
                $('.datepicker-here').datepicker();
            }
        })(jQuery)
    </script>
@endpush
