<div class="card">
    <div class="card-body">
        <h5 class="card-title">@lang('Payment Summary')</h5>
        <div class="list">
            <div class="list-item">
                <span>@lang('Total Payment')</span>
                <span>+{{ $general->cur_sym . showAmount($booking->total_amount) }}</span>
            </div>

            <div class="list-item">
                <span>@lang('Payment Received')</span>
                <span>-{{ $general->cur_sym }}{{ showAmount($receivedPayments->sum('amount')) }}</span>
            </div>

            <div class="list-item">
                <span>@lang('Refunded')</span>
                <span>-{{ $general->cur_sym }}{{ showAmount($returnedPayments->sum('amount')) }}</span>
            </div>

            <div class="list-item fw-bold">
                @if ($due < 0)
                    <span class="text-danger">@lang('Refundable') </span>
                    <span class="text-danger"> = {{ $general->cur_sym }}{{ showAmount(abs($due)) }}</span>
                @else
                    <span>@lang('Receivable from User')</span>
                    <span> = {{ $general->cur_sym }}{{ showAmount(abs($due)) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
