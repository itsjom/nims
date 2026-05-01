<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsrNconT1;
use App\Models\CsrConT1;
use App\Models\BorrowLog;
use App\Models\ReturnLog;
use Carbon\Carbon;

class ReturnFormController extends Controller
{
    public function create()
    {
        $nconMaterials = CsrNconT1::all();
        $conMaterials = CsrConT1::all();
        $borrowLogs = BorrowLog::where('status', 'Borrowed')->orderBy('borrow_id', 'desc')->get();
        $clinicalInstructors = \App\Models\ClinicalInstructor::all();

        return view('return-form.create', compact('nconMaterials', 'conMaterials', 'borrowLogs', 'clinicalInstructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrow_id' => 'required|integer',
            'equipment_type' => 'required|in:NCON,CON',
            'equipment_id' => 'required|integer',
            'quantity_returned' => 'required|integer|min:1',
            'condition' => 'required|string',
            'received_by' => 'required|string|max:255',
        ]);

        $borrowLog = BorrowLog::findOrFail($request->borrow_id);

        $equipmentName = '';

        if ($request->equipment_type === 'NCON') {
            $material = CsrNconT1::findOrFail($request->equipment_id);
            $equipmentName = $material->item_name;
            
            // Increment supply_on_hand
            $material->supply_on_hand += $request->quantity_returned;
            
            // Limit supply_on_hand to total_stock
            if ($material->supply_on_hand > $material->total_stock) {
                $material->supply_on_hand = $material->total_stock;
            }
            
            $material->save();
        } else {
            $material = CsrConT1::findOrFail($request->equipment_id);
            $equipmentName = $material->item_name;

            // Increment supply_on_hand
            $material->supply_on_hand += $request->quantity_returned;
            
            // Limit supply_on_hand to total_stock
            if ($material->supply_on_hand > $material->total_stock) {
                $material->supply_on_hand = $material->total_stock;
            }
            
            $material->save();
        }

        // Update BorrowLog status
        $borrowLog->status = 'Returned';
        $borrowLog->save();

        // Create ReturnLog
        ReturnLog::create([
            'borrow_id' => $borrowLog->formatted_id,
            'equipment' => $equipmentName,
            'quantity_returned' => $request->quantity_returned,
            'condition' => $request->condition,
            'received_by' => $request->received_by,
            'date_returned' => Carbon::today(),
        ]);

        return redirect()->back()->with('success', 'Equipment returned successfully!');
    }
}
