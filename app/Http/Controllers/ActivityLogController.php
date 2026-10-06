<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->latest();

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        if ($request->filled('activity')) {
            $query->where(
                'activity',
                'like',
                '%' . $request->activity . '%'
            );
        }

        $logs = $query
            ->paginate(15)
            ->withQueryString();

        return view('activity_logs.index', compact('logs'));
    }
}