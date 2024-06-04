@extends('owner.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="card bl--5-primary mb-3">
                <div class="card-body">
                    <form action="{{ route('owner.update.auto.payment.status') }}" class="autoPaymentForm" method="POST">
                        @csrf
                        <div class="d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">@lang('Auto Payment')</p>
                                <p class="mb-0">
                                    <small>@lang('If auto-payment is enabled, your monthly payment is handled automatically by the system.')</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input @if (authOwner()->auto_payment) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Off')" data-offstyle="-danger" data-on="@lang('On')" data-onstyle="-success" data-size="large" data-width="100%" name="auto_payment" type="checkbox">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <form action="{{ route('owner.deposit.insert') }}" method="post">
                @csrf
                <input name="currency" type="hidden">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Subscription Payment')</h5>
                        <p class="mb-0">
                            <small class="">@lang('You can pay for maximum') <span class="fw-bold">{{ $general->maximum_payment_month }} @lang('months').</span>
                                <i class="text--warning">@lang('Your subscription expired on') {{ showDateTime(authOwner()->expire_at, 'd M,Y') }}.</i>
                            </small>
                        </p>
                    </div>
                    <div class="card-body">
                        @if ($pendingPayment)
                            <div class="alert alert-info p-3">
                                <p>@lang('You have a pending payment of') {{ $general->cur_sym . showAmount($pendingPayment->amount) }} @lang('for') {{ $pendingPayment->pay_for_month }} @lang('months. Please wait for super admin response. You can see your payment history by click') <a href="{{ route('owner.payment.history') }}">@lang('here...')</a></p>
                            </div>
                        @endif

                        <div class="d-flex justify-content-center flex-wrap gap-2 my-3">
                            @php
                                $counter = floor($general->maximum_payment_month / 4);
                            @endphp

                            @for ($i = 1; $i <= $counter; $i++)
                                @php
                                    $months = $i * 4;
                                    $title = 'Pay For ' . $months . ' Months';
                                @endphp

                                <div class="paying_month" data-pay_for="{{ $months }}">
                                    <span class="title">{{ __($title) }}</span>
                                </div>
                            @endfor
                        </div>

                        <div class="form-group">
                            <label>@lang('Pay For')</label>
                            <div class="input-group">
                                <input type="number" min="0" max="{{ $general->maximum_payment_month }}" class="form-control" name="pay_for_month" required>
                                <span class="input-group-text">@lang('Months')</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Payment Via')</label>
                            <select class="gateway-select-box" name="gateway" required>
                                <option data-title="@lang('Select One')" value="">@lang('Select One')</option>
                                <option value="-1" data-charge="{{ $general->cur_sym . '0.00' }}" data-title="@lang('Wallet Balance') - {{ __($general->cur_text) }} ({{ $general->cur_sym . showAmount(authOwner()->balance) }})">@lang('Wallet Balance')</option>
                                @foreach ($gatewayCurrency as $data)
                                    <option data-gateway="{{ $data }}" data-title="{{ __($data->name) }} ({{ gs('cur_sym') }}{{ showAmount($data->min_amount) }} to {{ gs('cur_sym') }}{{ showAmount($data->max_amount) }})" data-charge="{{ gs('cur_sym') }} {{ showAmount($data->fixed_charge) }} + {{ getAmount($data->percent_charge) }}%"
                                        value="{{ $data->method_code }}" @selected(old('gateway') == $data->method_code)>
                                        {{ __($data->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Per Month Bill')</span>
                                <span><span class="fw-bold">{{ showAmount($general->bill_per_month) }}</span> {{ __($general->cur_text) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Charge')</span>
                                <span><span class="charge fw-bold">0</span> {{ __($general->cur_text) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span>
                                    {{ __($general->cur_text) }}</span>
                            </li>
                            <li class="list-group-item justify-content-between d-none rate-element">

                            </li>
                            <li class="list-group-item justify-content-between d-none in-site-cur">
                                <span>@lang('In') <span class="base-currency"></span></span>
                                <span class="final_amo fw-bold">0</span>
                            </li>
                            <li class="list-group-item justify-content-center crypto_currency d-none">
                                <span>@lang('Conversion with') <span class="method_currency"></span> @lang('and final value will Show on next step')</span>
                            </li>
                        </ul>
                        <button class="btn btn--primary h-45 w-100 mt-3" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('owner.payment.history') }}" class="btn btn-sm btn--primary"><i class="las la-list"></i>@lang('View History')</a>
@endpush

@push('script')
    <script>
        "use strict";

        var gatewayOptions = $('.gateway-select-box').find('option');
        var gatewayHtml = `
            <div class="gateway-select">
                <div class="selected-gateway d-flex justify-content-between align-items-center">
                    <p class="gateway-title">@lang('Select One')</p>
                    <div class="icon-area">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
                <div class="gateway-list d-none">
        `;
        $.each(gatewayOptions, function(key, option) {
            option = $(option);
            if (option.data('title')) {
                gatewayHtml += `<div class="single-gateway" data-value="${option.val()}">
                            <p class="gateway-title">${option.data('title')}</p>`;
                if (option.data('charge')) {
                    gatewayHtml += `<p class="gateway-charge">Charge: ${option.data('charge')}</p>`;
                }

                gatewayHtml += `</div>`;
            }
        });
        gatewayHtml += `</div></div>`;
        $('.gateway-select-box').after(gatewayHtml);
        var selectedGateway = $('.gateway-select-box :selected');
        $(document).find('.selected-gateway .gateway-title').text(selectedGateway.data('title'))

        $('.selected-gateway').on("click",function() {
            $('.gateway-list').toggleClass('d-none');
            $(this).find('.icon-area').find('i').toggleClass('la-angle-up');
            $(this).find('.icon-area').find('i').toggleClass('la-angle-down');
        });

        $(document).on('click', '.single-gateway', function() {
            $('.selected-gateway').find('.gateway-title').text($(this).find('.gateway-title').text());
            $('.gateway-list').addClass('d-none');
            $('.selected-gateway').find('.icon-area').find('i').toggleClass('la-angle-up');
            $('.selected-gateway').find('.icon-area').find('i').toggleClass('la-angle-down');
            $('.gateway-select-box').val($(this).data('value'));
            $('.gateway-select-box').trigger('change');
        });

        function selectPostType(whereClick, whichHide) {
            if (!whichHide) return;

            $(document).on("click", function(event) {
                var target = $(event.target);
                if (!target.closest(whereClick).length) {
                    $(document).find('.icon-area i').addClass("la-angle-down").removeClass('la-angle-up');
                    whichHide.addClass("d-none");
                }
            });
        }
        selectPostType(
            $('.selected-gateway'),
            $(".gateway-list")
        );

        (function($) {

            $('.paying_month').on('click', function() {
                $('.paying_month').not($(this)).removeClass('selected');
                if ($(this).hasClass('selected')) {
                    $('[name=pay_for_month]').val('');
                } else {
                    let month = $(this).data('pay_for');
                    $('[name=pay_for_month]').val(month);
                }

                $(this).toggleClass('selected');
            })

            $('[name=pay_for_month]').on('change', function() {
                var payFor = Number($(this).val());

                var maxPaymentMonth = @json($general->maximum_payment_month);
                if (payFor > maxPaymentMonth) {
                    notify('error', `@lang('You can pay for maximum ${maxPaymentMonth} months')`);
                    $('[name=pay_for_month]').val('');
                }

                var monthlyBill = Number("{{ $general->bill_per_month }}");
                calculate();
            });

            $('select[name=gateway]').change(function() {
                if (!$('select[name=gateway]').val()) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }

                calculate();
            });

            function calculate() {
                if ($('select[name=gateway] option:selected').val() == -1) {
                    $('.list-group').addClass('d-none');
                    $('input[name=currency]').val("{{ $general->cur_text }}");
                    return;
                } else {
                    $('.list-group').removeClass('d-none');
                }

                var resource = $('select[name=gateway] option:selected').data('gateway');

                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                if (resource.method.crypto == 1) {
                    var toFixedDigit = 8;
                    $('.crypto_currency').removeClass('d-none');
                } else {
                    var toFixedDigit = 2;
                    $('.crypto_currency').addClass('d-none');
                }

                var payFor = $('[name=pay_for_month]').val() * 1;
                var billPerMonth = @json($general->bill_per_month);
                var amount = payFor * billPerMonth;

                if (!amount) {
                    amount = 0;
                }
                if (amount <= 0) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                $('.preview-details').removeClass('d-none');
                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(toFixedDigit);
                $('.final_amo').text(final_amo);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement = `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span>  <span class="method_currency">${resource.currency}</span></span></span>`;
                    $('.rate-element').html(rateElement)
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                } else {
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                $('.method_currency').text(resource.currency);
                $('input[name=currency]').val(resource.currency);
            }

            $('[name=auto_payment]').on('change', function() {
                $('.autoPaymentForm').submit();
            })
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .gateway-select {
            position: relative;
        }

        .selected-gateway {
            padding: 0.625rem 1.25rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
            cursor: pointer;
        }

        .gateway-list {
            border: 1px solid #ced4da;
            border-radius: 5px;
            position: absolute;
            width: 100%;
            top: 50px;
            height: auto;
            z-index: 9;
            background: #fff;
            max-height: 300px;
            overflow: auto;
        }

        .gateway-list::-webkit-scrollbar {
            background-color: #ced4da;
            width: 5px !important;
        }

        .gateway-list::-webkit-scrollbar-thumb {
            background: #706f6f73;
            border-radius: 15px;
        }

        .single-gateway {
            padding: 0.625rem 1.25rem;
            border-bottom: 1px solid #ced4da;
            cursor: pointer;
        }

        .single-gateway:hover {
            background: #F1F1F1;
        }

        .single-gateway:last-child {
            margin-bottom: 0;
            border-bottom: 0;
        }

        .gateway-title {
            font-weight: 600;
            font-size: 14px;
        }

        .single-gateway .gateway-charge {
            font-size: 12px;
        }

        .gateway-select-box {
            opacity: 0;
            height: 0;
            width: 0;
        }

        .paying_month {
            border: 1px solid #ebebeb;
            padding: 20px 30px;
            border-radius: 10px;
            cursor: pointer;
            background: #ebebeb75;
        }

        .paying_month.selected {
            background-color: #4634ff;
        }

        .paying_month.selected .title {
            color: #fff;
        }
    </style>
@endpush
