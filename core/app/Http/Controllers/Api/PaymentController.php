<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function methods($bookingId)
    {
        $booking = Booking::active()->where('user_id', auth()->id())->find($bookingId);

        if (!$booking) {
            $notify[] = 'Booking not found';
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        $notify[] = 'Payment methods';

        return response()->json([
            'remark' => 'payment_methods',
            'message' => ['success' => $notify],
            'data' => [
                'booking' => $booking,
                'methods' => $gatewayCurrency
            ],
        ]);
    }

    public function paymentInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'      => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency'    => 'required',
            'booking_id'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = auth()->user();
        $booking = Booking::active()->where('user_id', $user->id)->where('id', $request->booking_id)->first();

        if (!$booking) {
            $notify[] = 'Booking not found';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        if ($request->amount > $booking->due_amount) {
            $notify[] = 'Amount should be less than or equal to due amount';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $amount =  $request->amount;
        $deposit = new Deposit();

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();

        if (!$gate) {
            $notify[] = 'Invalid gateway';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = 'Please follow the limit';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $charge = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable = $amount + $charge;
        $finalAmo = $payable * $gate->rate;

        $deposit->user_id = $user->id;
        $deposit->owner_id = $booking->owner_id;
        $deposit->booking_id = $booking->id;
        $deposit->method_code = $gate->method_code;
        $deposit->method_currency = strtoupper($gate->currency);
        $deposit->amount = $amount;
        $deposit->charge = $charge;
        $deposit->rate = $gate->rate;
        $deposit->final_amo = $finalAmo;
        $deposit->btc_amo = 0;
        $deposit->btc_wallet = "";
        $deposit->trx = getTrx();
        $deposit->save();

        $notify[] =  'Payment inserted';

        return response()->json([
            'remark' => 'payment_inserted',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'payment' => $deposit,
                'redirect_url' => route('deposit.app.confirm', encrypt($deposit->id))
            ]
        ]);
    }
}
