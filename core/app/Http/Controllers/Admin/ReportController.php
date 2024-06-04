<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\OwnerLogin;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction(Request $request)
    {
        $pageTitle = 'Transaction Logs';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::searchable(['trx', 'owner:firstname', 'owner:lastname', 'user:username'])->filter(['trx_type', 'remark'])->dateFilter()->orderBy('id', 'desc')->with('owner', 'user')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function userLoginHistory(Request $request)
    {
        $pageTitle = 'Users Login History';
        $loginLogs = UserLogin::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.user_logins', compact('pageTitle', 'loginLogs'));
    }

    public function userLoginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.user_logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function ownerLoginHistory(Request $request)
    {
        $pageTitle = 'Vendors Login History';
        $loginLogs = OwnerLogin::orderBy('id', 'desc')->searchable(['owner:email'])->with('owner')->paginate(getPaginate());
        return view('admin.reports.owner_logins', compact('pageTitle', 'loginLogs'));
    }

    public function ownerLoginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = OwnerLogin::where('owner_ip', $ip)->orderBy('id', 'desc')->with('owner')->paginate(getPaginate());
        return view('admin.reports.owner_logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function notificationHistory()
    {
        $pageTitle = 'Notification History';

        $logs = NotificationLog::query();
        if (request()->type == 'user') {
            $logs = $logs->where('user_id', '!=', 0);
        }

        if (request()->type == 'owner') {
            $logs = $logs->where('owner_id', '!=', 0);
        }

        $logs = $logs->searchable(['user:username', 'owner:email,name'])->with('user', 'owner')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }
}
