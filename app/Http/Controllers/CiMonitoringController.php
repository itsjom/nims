<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClinicalInstructor;
use App\Models\BorrowLog;
use App\Models\ReturnLog;
use Carbon\Carbon;

class CiMonitoringController extends Controller
{
    public function index()
    {
        $instructors = ClinicalInstructor::all();
        $monitoringData = [];

        foreach ($instructors as $ci) {
            $totalBorrowed = BorrowLog::where('clinical_instructor', $ci->name)->sum('quantity');

            $borrowIds = BorrowLog::where('clinical_instructor', $ci->name)->pluck('borrow_id');
            $formattedBorrowIds = $borrowIds->map(function($id) {
                return 'BOR-' . str_pad($id, 2, '0', STR_PAD_LEFT);
            });

            $totalReturned = ReturnLog::whereIn('borrow_id', $formattedBorrowIds)->sum('quantity_returned');

            $missingEquipment = ReturnLog::whereIn('borrow_id', $formattedBorrowIds)
                                         ->where(function($q) {
                                             $q->where('condition', 'like', '%Missing%');
                                         })
                                         ->sum('quantity_returned');

            $damagedEquipment = ReturnLog::whereIn('borrow_id', $formattedBorrowIds)
                                         ->where(function($q) {
                                             $q->where('condition', 'like', '%Damage%')
                                               ->orWhere('condition', 'like', '%Defect%');
                                         })
                                         ->sum('quantity_returned');

            $overdueItems = BorrowLog::where('clinical_instructor', $ci->name)
                                     ->where('status', 'Borrowed')
                                     ->whereDate('expected_returned_date', '<', Carbon::today())
                                     ->sum('quantity');

            $monitoringData[] = (object) [
                'id' => $ci->id,
                'name' => $ci->name,
                'total_borrowed' => $totalBorrowed,
                'total_returned' => $totalReturned,
                'missing_equipment' => $missingEquipment,
                'damaged_equipment' => $damagedEquipment,
                'overdue_items' => $overdueItems,
            ];
        }

        return view('ci-monitoring.index', compact('monitoringData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:clinical_instructors,name'
        ]);

        ClinicalInstructor::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Clinical Instructor added successfully!');
    }

    public function destroy($id)
    {
        $ci = ClinicalInstructor::findOrFail($id);
        $ci->delete();

        return redirect()->back()->with('success', 'Clinical Instructor removed successfully!');
    }
}
