<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowLog;
use App\Models\ReturnLog;

class LogController extends Controller
{
    public function borrowing()
    {
        $logs = BorrowLog::orderBy('borrow_id', 'asc')->get();
        return view('logs.borrowing', compact('logs'));
    }

    public function returned()
    {
        $logs = ReturnLog::orderByDesc('created_at')->get();
        return view('logs.returned', compact('logs'));
    }
}
