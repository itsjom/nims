<?php

namespace App\Http\Controllers;

use App\Models\FnpMaterial;
use App\Models\HaMaterial;
use App\Models\BorrowLog;
use App\Models\ReturnLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Equipments (FNP + HA Database count)
        $totalEquipments = FnpMaterial::count() + HaMaterial::count();

        // 2. Total Borrowed (Active items not returned, based on number of borrow transactions NOT total sum of quantity)
        $totalBorrowed = BorrowLog::where('status', '!=', 'Returned')->count();

        // 3. Total Returned
        $totalReturned = ReturnLog::count();

        // 4. Missing Items (Calculated as: not returned, and it's been 2 days AFTER expected return date)
        $missingThreshold = Carbon::now()->subDays(2)->startOfDay();
        $missingItems = BorrowLog::where('status', '!=', 'Returned')
            ->where('expected_returned_date', '<=', $missingThreshold)
            ->count();

        // 5. Damaged Items
$damagedItems = ReturnLog::where('condition', 'damaged')->count();
        return view('dashboard', compact(
            'totalEquipments',
            'totalBorrowed',
            'totalReturned',
            'missingItems',
            'damagedItems'
        ));
    }
}
