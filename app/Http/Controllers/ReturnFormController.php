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
            'items' => 'required|array|min:1',
            'items.*.equipment_type' => 'required|in:NCON,CON',
            'items.*.equipment_id' => 'required|integer',
            'items.*.quantity_returned' => 'required|integer|min:1',
            'items.*.condition' => 'required|string',
            'items.*.name' => 'required|string',
            'received_by' => 'required|string|max:255',
        ]);

        $borrowLog = BorrowLog::findOrFail($request->borrow_id);

        foreach ($request->items as $itemData) {
            $equipmentType = $itemData['equipment_type'];
            $equipmentId = $itemData['equipment_id'];
            $quantityReturned = $itemData['quantity_returned'];
            $condition = $itemData['condition'];
            $equipmentName = $itemData['name'];

            if ($equipmentType === 'NCON') {
                $material = CsrNconT1::findOrFail($equipmentId);
            } else {
                $material = CsrConT1::findOrFail($equipmentId);
            }

            // Increment supply_on_hand
            $material->supply_on_hand += $quantityReturned;
            
            // Limit supply_on_hand to total_stock
            if ($material->supply_on_hand > $material->total_stock) {
                $material->supply_on_hand = $material->total_stock;
            }
            
            $material->save();

            // Create ReturnLog
            ReturnLog::create([
                'borrow_id' => $borrowLog->formatted_id,
                'equipment' => $equipmentName,
                'quantity_returned' => $quantityReturned,
                'condition' => $condition,
                'received_by' => $request->received_by,
                'date_returned' => Carbon::today(),
            ]);
        }

        // Update BorrowLog status
        $borrowLog->status = 'Returned';
        $borrowLog->save();

        return redirect()->back()->with('success', 'Equipment returned successfully!');
    }
}
