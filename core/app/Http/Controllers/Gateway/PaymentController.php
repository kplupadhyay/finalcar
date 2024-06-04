<?php

namespace App\Http\Controllers\Gateway;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\OwnerNotification;
use App\Models\Booking;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Owner;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        $pageTitle = 'Payment Methods';
        $pendingPayment = null;

        if (currentAuth()['type'] == 'owner') {
            $pageTitle = 'Subscription';
            $view = 'owner.payment.deposit';
            $pendingPayment = Deposit::pending()->where('owner_id', getOwnerParentId())->latest()->first();
        } else {
            abort('404');
        }

        return view($view, compact('gatewayCurrency', 'pageTitle', 'pendingPayment'));
    }

    public function depositInsert(Request $request)
    {
        $currentAuth = currentAuth();
        $payFor = 'nullable';
        $amountValidation = 'required|numeric|gt:0';

        if ($currentAuth['type'] == 'owner') {
            $payFor = 'required|integer|gt:0|lte:' . gs('maximum_payment_month');
            $amountValidation = 'nullable|numeric|gt:0';
        }


        $request->validate([
            'amount'        => $amountValidation,
            'gateway'       => 'required',
            'currency'      => 'required',
            'pay_for_month' => $payFor
        ]);

        $owner   = null;
        $booking = null;
        $amount  = $request->amount;
        $ownerId = 0;

        if ($currentAuth['type'] == 'owner') {
            $owner = authOwner();
            $ownerId = $owner->id;
            $amount = $request->pay_for_month * gs('bill_per_month');

            if ($request->gateway == -1) {
                if ($amount > $owner->balance) {
                    $notify[] = ['error', 'Insufficient balance'];
                    return back()->withNotify($notify);
                }

                $this->billPayByWalletBalance($request, $amount);

                $notify[] = ['success', 'Payment completed successfully'];
                return to_route('owner.dashboard')->withNotify($notify);
            }
        }

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        //for user booking  only
        if ($currentAuth['type'] == 'user') {
            $bookingId = session()->get('booking_id');
            $booking = Booking::find($bookingId);
            $ownerId = $booking->owner_id;

            if ($amount > ($booking->total_amount - $booking->paid_amount)) {
                $notify[] = ['error', 'Amount should be less than or equal to payable amount'];
                return back()->withNotify($notify);
            }
        }
        //for user booking  only end

        $charge      = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable     = $amount + $charge;
        $finalAmount = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->user_id         = auth()->user() ? auth()->user()->id : 0;
        $data->owner_id        =  $ownerId;
        $data->pay_for_month   = $request->pay_for_month ?? 0;
        $data->booking_id      =  $booking->id ?? 0;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amo       = $finalAmount;
        $data->btc_amo         = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->save();
        session()->put('Track', $data->trx);

        if ($currentAuth['type'] == 'owner') {
            $redirectTo = 'owner.deposit.confirm';
        } else {
            $redirectTo = 'user.deposit.confirm';
        }

        return to_route($redirectTo);
    }

    private function billPayByWalletBalance($request, $amount)
    {
        $owner = authOwner();
        $nextExpireDate = Carbon::parse($owner->expire_at)->addMonths($request->pay_for_month)->subDay();

        $owner->balance -= $amount;
        $owner->expire_at = $nextExpireDate;
        $owner->save();

        $transaction                = new Transaction();
        $transaction->owner_id      = $owner->id;
        $transaction->amount        = $amount;
        $transaction->post_balance  = $owner->balance;
        $transaction->charge        = 0;
        $transaction->trx_type      = '-';
        $transaction->details       = 'Payment for ' . $request->pay_for_month . ' months';
        $transaction->trx           = getTrx();
        $transaction->remark        = 'monthly_bill_payment';
        $transaction->save();

        notify($owner, 'BILL_PAYMENT_COMPLETED', [
            'amount_per_month' => showAmount($transaction->amount / $request->pay_for_month),
            'total_month'      => $request->pay_for_month,
            'amount'           => showAmount($transaction->amount),
            'charge'           => showAmount($transaction->charge),
            'final_amount'     => showAmount($transaction->amount),
            'expire_at'        => showDateTime($owner->expire_at, 'd M, Y'),
            'trx'              => $transaction->trx
        ]);
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function depositConfirm()
    {
        $track   = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();
        if ($deposit->method_code >= 1000) {
            if ($deposit->user_id) {
                return to_route('user.deposit.manual.confirm');
            } else {
                return to_route('owner.deposit.manual.confirm');
            }
        }

        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';

        if (currentAuth()['type'] == 'owner') {
            $view = $data->view;
        } else {
            $view = $this->activeTemplate . $data->view;
        }

        return view($view, compact('data', 'pageTitle', 'deposit'));
    }

    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            if ($deposit->pay_for_month != 0) {
                $owner = Owner::find($deposit->owner_id);
                $owner->balance += $deposit->amount;
                $owner->save();

                $transaction               = new Transaction();
                $transaction->owner_id     = $owner->id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $owner->balance;
                $transaction->charge       = $deposit->charge;
                $transaction->trx_type     = '+';
                $transaction->details      = 'Deposited via ' . $deposit->gatewayCurrency()->name;
                $transaction->trx          = $deposit->trx;
                $transaction->remark       = 'deposit';
                $transaction->save();

                $nextExpireDate = Carbon::parse($owner->expire_at)->addMonths($deposit->pay_for_month)->subDay();
                $owner->expire_at = $nextExpireDate;
                $owner->balance -= $deposit->amount;
                $owner->save();

                $transaction               = new Transaction();
                $transaction->owner_id     = $owner->id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $owner->balance;
                $transaction->charge       = $deposit->charge;
                $transaction->trx_type     = '-';
                $transaction->details      = 'Payment via ' . $deposit->gatewayCurrency()->name . ' for ' . $deposit->pay_for_month . ' months';
                $transaction->trx          = $deposit->trx;
                $transaction->remark       = 'monthly_bill_payment';
                $transaction->save();

                notify($owner, 'BILL_PAYMENT_COMPLETED', [
                    'amount_per_month' => showAmount($deposit->amount / $deposit->pay_for_month),
                    'total_month'      => $deposit->pay_for_month,
                    'amount'           => showAmount($deposit->amount),
                    'charge'           => showAmount($transaction->charge),
                    'final_amount'     => showAmount($deposit->final_amo),
                    'expire_at'        => showDateTime($owner->expire_at, 'd M, Y'),
                    'trx'              => $transaction->trx
                ]);
            } else {
                $user = User::find($deposit->user_id);
                //update booking
                $booking = Booking::find($deposit->booking_id);
                $booking->paid_amount += $deposit->amount;
                $booking->save();

                //payment log
                $booking->createPaymentLog($deposit->amount, 'BOOKING_PAYMENT_RECEIVED', @$deposit->gateway->name, true, $booking->owner_id);

                $owner = Owner::find($booking->owner_id);
                $owner->balance += $deposit->amount;
                $owner->save();

                $transaction               = new Transaction();
                $transaction->owner_id     = $owner->id;
                $transaction->user_id      = $user->id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $owner->balance;
                $transaction->charge       = $deposit->charge;
                $transaction->trx_type     = '+';
                $transaction->details      = 'Payment for booking via ' . $deposit->gatewayCurrency()->name;
                $transaction->trx          = $deposit->trx;
                $transaction->remark       = 'booking_payment';
                $transaction->save();


                $ownerNotification = new OwnerNotification();
                $ownerNotification->owner_id  = $owner->id;
                $ownerNotification->user_id   = $user->id;
                $ownerNotification->title     = 'Payment for booking via ' . $deposit->gatewayCurrency()->name;
                $ownerNotification->click_url = urlPath('owner.report.payments.received') . '?search=' . $booking->booking_number;
                $ownerNotification->save();

                notify($user, $isManual ? 'PAYMENT_MANUAL_APPROVED' : 'DIRECT_PAYMENT_SUCCESSFUL', [
                    'booking_number' => $booking->booking_number,
                    'amount'          => showAmount($deposit->amount),
                    'charge'          => showAmount($deposit->charge),
                    'rate'            => showAmount($deposit->rate),
                    'method_name'     => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount'   => showAmount($deposit->final_amo),
                    'trx' => $deposit->trx,
                ]);
            }
        }
    }


    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;

            if ($data->user_id) {
                return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
            } else {
                return view('owner.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
            }
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::initiated()->with('gateway')->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);


        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();

        if ($data->user_id) {
            $ownerNotification = new OwnerNotification();
            $ownerNotification->user_id = $data->user->id;
            $ownerNotification->title = 'Payment request from ' . $data->user->username;
            $ownerNotification->click_url = urlPath('owner.deposit.details', $data->id);
            $ownerNotification->save();

            $user    = user::find($data->user_id);
            $booking = Booking::find($data->booking_id);

            notify($user, 'PAYMENT_MANUAL_REQUEST', [
                'booking_number'  => $booking->booking_number,
                'amount'          => showAmount($data->amount),
                'charge'          => showAmount($data->charge),
                'rate'            => showAmount($data->rate),
                'method_name'     => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount'   => showAmount($data->final_amo),
                'trx' => $data->trx
            ]);

            $url = 'user.booking.all';
        } else {
            $adminNotification = new AdminNotification();
            $adminNotification->owner_id = $data->owner_id;
            $adminNotification->title = 'Monthly Bill payment request from ' . $data->owner->fullname;
            $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
            $adminNotification->save();

            $owner = $data->owner;

            notify($owner, 'BILL_PAYMENT_MANUAL', [
                'total_month'    => $data->pay_for_month,
                'amount'          => showAmount($data->amount),
                'charge'          => showAmount($data->charge),
                'rate'            => showAmount($data->rate),
                'method_name'     => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount'   => showAmount($data->final_amo),
                'trx'             => $data->trx
            ]);

            $url = 'owner.payment.history';
        }

        $notify[] = ['success', 'Your payment request has been taken'];
        return to_route($url)->withNotify($notify);
    }
}
