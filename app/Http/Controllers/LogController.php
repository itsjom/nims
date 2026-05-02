<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowLog;
use App\Models\ReturnLog;

class LogController extends Controller
{
    public function borrowing()
    {
        $logs = BorrowLog::orderBy('borrow_id', 'desc')->get();
        return view('logs.borrowing', compact('logs'));
    }

    public function returned()
    {
        $logs = ReturnLog::orderBy('return_id', 'desc')->get();
        return view('logs.returned', compact('logs'));
    }
}
