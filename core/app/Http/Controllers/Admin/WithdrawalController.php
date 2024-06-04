<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\PaymentLog;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = $this->withdrawalData('pending');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Withdrawals';
        $withdrawals = $this->withdrawalData('approved');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = $this->withdrawalData('rejected');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function log()
    {
        $pageTitle = 'Withdrawals Log';
        $withdrawalData = $this->withdrawalData($scope = null, $summery = true);
        $withdrawals = $withdrawalData['data'];
        $summery = $withdrawalData['summery'];
        $successful = $summery['successful'];
        $pending = $summery['pending'];
        $rejected = $summery['rejected'];


        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'successful', 'pending', 'rejected'));
    }

    protected function withdrawalData($scope = null, $summery = false)
    {
        if ($scope) {
            $withdrawals = Withdrawal::$scope();
        } else {
            $withdrawals = Withdrawal::where('status', '!=', Status::PAYMENT_INITIATE);
        }

        if (request()->search) {
            $search = request()->search;
            $withdrawals = $withdrawals->where('trx', 'like', "%$search%")->orWhere(function ($query) use ($search) {
                $query->whereHas('owner', function ($owner) use ($search) {
                    $owner->whereRaw("CONCAT(firstname, ' ',lastname) LIKE?", ["%$search%"])->orWhere('email', 'like', "%$search%");
                });
            });
        }

        $withdrawals = $withdrawals->dateFilter();

        $request = request();
        if ($request->method) {
            $withdrawals = $withdrawals->where('method_id', $request->method);
        }
        if (!$summery) {
            return $withdrawals->with(['owner', 'method'])->orderBy('id', 'desc')->paginate(getPaginate());
        } else {

            $successful = clone $withdrawals;
            $pending = clone $withdrawals;
            $rejected = clone $withdrawals;

            $successfulSummery = $successful->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
            $pendingSummery = $pending->where('status', Status::PAYMENT_PENDING)->sum('amount');
            $rejectedSummery = $rejected->where('status', Status::PAYMENT_REJECT)->sum('amount');


            return [
                'data' => $withdrawals->with(['owner', 'method'])->orderBy('id', 'desc')->paginate(getPaginate()),
                'summery' => [
                    'successful' => $successfulSummery,
                    'pending' => $pendingSummery,
                    'rejected' => $rejectedSummery,
                ]
            ];
        }
    }

    public function details($id)
    {
        $withdrawal = Withdrawal::where('id', $id)->where('status', '!=', Status::PAYMENT_INITIATE)->with(['owner', 'method'])->firstOrFail();
        $pageTitle = @$withdrawal->owner->fullname . ' Withdraw Requested ' . showAmount($withdrawal->amount) . ' ' . gs('cur_text');
        $details = $withdrawal->withdraw_information ? json_encode($withdrawal->withdraw_information) : null;

        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal', 'details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->with('owner', 'method')->firstOrFail();
        $withdraw->status = Status::PAYMENT_SUCCESS;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        notify($withdraw->owner, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal approved successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->with('owner')->firstOrFail();

        $withdraw->status = Status::PAYMENT_REJECT;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $owner = $withdraw->owner;
        $owner->balance += $withdraw->amount;
        $owner->save();

        $transaction = new Transaction();
        $transaction->owner_id = $withdraw->owner_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $owner->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->remark = 'withdraw_reject';
        $transaction->details = showAmount($withdraw->amount) . ' ' . gs('cur_text') . ' Refunded from withdrawal rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();


        notify($owner, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($owner->balance),
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal rejected successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }
}
