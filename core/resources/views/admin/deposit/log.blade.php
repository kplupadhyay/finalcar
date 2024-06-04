@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        @if (request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.method') || request()->routeIs('admin.users.deposits') || request()->routeIs('admin.users.deposits.method'))
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 b-radius--5 bg--success has-link">
                    <a class="item-link" href="{{ route('admin.deposit.successful') }}"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($successful) }}</h2>
                        <p class="text-white">@lang('Successful Deposit')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 b-radius--5 bg--6 has-link">
                    <a class="item-link" href="{{ route('admin.deposit.pending') }}"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($pending) }}</h2>
                        <p class="text-white">@lang('Pending Deposit')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 has-link b-radius--5 bg--pink">
                    <a class="item-link" href="{{ route('admin.deposit.rejected') }}"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($rejected) }}</h2>
                        <p class="text-white">@lang('Rejected Deposit')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 has-link b-radius--5 bg--dark">
                    <a class="item-link" href="{{ route('admin.deposit.initiated') }}"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ showAmount($initiated) }}</h2>
                        <p class="text-white">@lang('Initiated Deposit')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
        @endif

        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway | Transaction')</th>
                                    <th>@lang('Initiated At')</th>
                                    <th>@lang('Initiated By')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Conversion')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $deposit)
                                    @php
                                        $details = $deposit->detail ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-bold"> <a href="{{ appendQuery('method', @$deposit->gateway->alias) }}">{{ __(@$deposit->gateway->name) }}</a> </span>
                                            <br>
                                            <small> {{ $deposit->trx }} </small>
                                        </td>

                                        <td>
                                            {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                        </td>
                                        <td>
                                            @if ($deposit->user_id)
                                                <a href="{{ appendQuery('search', @$deposit->user->username) }}"><span>@</span>{{ $deposit->user->username }}</a><br>
                                                <small class="text-muted">@lang('User')</small>
                                            @elseif($deposit->owner_id)
                                                <a href="{{ appendQuery('search', @$deposit->owner->firstname) }}">{{ $deposit->owner->fullname }}</a> <br>
                                                <small class="text-muted">@lang('Vendor')</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span class="text-danger" title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                            </strong>
                                        </td>
                                        <td>
                                            1 {{ __($general->cur_text) }} = {{ showAmount($deposit->rate) }} {{ __($deposit->method_currency) }}
                                            <br>
                                            <strong>{{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</strong>
                                        </td>
                                        <td>
                                            @php echo $deposit->statusBadge @endphp
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary ms-1" href="{{ route('admin.deposit.details', $deposit->id) }}">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
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
                @if ($deposits->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($deposits) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if (!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method') && !request()->routeIs('admin.owners.deposits') && !request()->routeIs('admin.owners.deposits.method'))
        <div class="input-group w-auto flex-fill">
            <select class="from-control bg--white" form="searchForm" name="payment_by">
                <option value="">@lang('Initiated By All')</option>
                <option @selected(request()->payment_by == 'user_id') value="user_id">@lang('User')</option>
                <option @selected(request()->payment_by == 'owner_id') value="owner_id">@lang('Vendor')</option>
            </select>
        </div>
        <x-search-form dateSearch='yes' />
    @endif
@endpush

@push('script')
    <script>
        "use strict";

        $('[name=payment_by]').on('change', function() {
            $('#searchForm').submit();
        });
    </script>
@endpush
