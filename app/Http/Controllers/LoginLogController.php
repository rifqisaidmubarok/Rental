<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{
    public function index(Request $request)
    {
        $query = LoginLog::with('user')
            ->latest('login_time');

        // Filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('login_time', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('login_time', '<=', $request->date_to);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->paginate(15)->withQueryString();

        $users = \App\Models\User::orderBy('name')->get();

        return view('login_logs.index', compact(
            'logs',
            'users'
        ));
    }
}