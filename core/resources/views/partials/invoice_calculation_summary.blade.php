@if ($canceledFare > 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Canceled Fare')</td>
        <td> - {{ showAmount($canceledFare) }} {{ __($general->cur_text) }}</td>
    </tr>
@endif

@if ($booking->total_discount > 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Discount')</td>
        <td> - {{ showAmount($booking->total_discount) }} {{ __($general->cur_text) }}</td>
    </tr>
@endif

@if ($booking->cancellation_fee > 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Cancellation Fee')</td>
        <td>{{ showAmount($booking->cancellation_fee) }} {{ __($general->cur_text) }}</td>
    </tr>
@endif
<tr class="custom-table__subhead">
    <td class="text-end" colspan="2">{{ __(hotelSetting('tax_name')) }}</td>
    <td> {{ showAmount($totalTaxCharge) }} {{ __($general->cur_text) }}</td>
</tr>

@if ($canceledTaxCharge > 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Canceled') {{ __(hotelSetting('tax_name')) }} @lang('Charge')</td>
        <td> - {{ showAmount($canceledTaxCharge) }} {{ __($general->cur_text) }}</td>
    </tr>
@endif

@if ($booking->extraCharge() > 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Other Charges')</td>
        <td> {{ showAmount($booking->extraCharge()) }} {{ __($general->cur_text) }}</td>
    </tr>
@endif

<tr class="custom-table__subhead">
    <td class="text-end" colspan="2">@lang('Total')</td>
    <td> = {{ showAmount($booking->total_amount) }} {{ __($general->cur_text) }}</td>
</tr>

@if ($due > 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Due')</td>
        <td> = {{ showAmount($due) }} {{ __($general->cur_text) }}</td>
    </tr>
@elseif($due < 0)
    <tr class="custom-table__subhead">
        <td class="text-end" colspan="2">@lang('Refundable')</td>
        <td> = {{ showAmount(abs($due)) }} {{ __($general->cur_text) }}</td>
    </tr>
@endif
