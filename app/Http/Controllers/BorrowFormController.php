<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsrNconT1;
use App\Models\CsrConT1;
use App\Models\BorrowLog;
use Carbon\Carbon;

class BorrowFormController extends Controller
{
    public function create()
    {
        $nconMaterials = CsrNconT1::all();
        $conMaterials = CsrConT1::all();
        $clinicalInstructors = \App\Models\ClinicalInstructor::all();

        return view('borrow-form.create', compact('nconMaterials', 'conMaterials', 'clinicalInstructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'clinical_instructor' => 'required|string|max:255',
            'expected_returned_date' => 'required|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.equipment_composite' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $itemsToProcess = [];

        // Validation phase: check all items before saving any
        foreach ($request->items as $index => $item) {
            $parts = explode('_', $item['equipment_composite']);
            if (count($parts) !== 2) {
                return back()->withErrors(['items' => 'Invalid equipment selected.'])->withInput();
            }
            $type = $parts[0];
            $id = $parts[1];
            $qty = $item['quantity'];

            if ($type === 'NCON') {
                $material = CsrNconT1::findOrFail($id);
            } else {
                $material = CsrConT1::findOrFail($id);
            }

            if ($qty > $material->supply_on_hand) {
                return back()->withErrors(['items' => 'Not enough items available. Only ' . $material->supply_on_hand . ' remaining for ' . $material->item_name . '.'])->withInput();
            }

            $itemsToProcess[] = [
                'material' => $material,
                'quantity' => $qty,
                'name' => $material->item_name
            ];
        }

        // Execution phase: decrement supply and collect names/quantities
        $equipmentNames = [];
        $totalQuantity = 0;

        foreach ($itemsToProcess as $item) {
            $material = $item['material'];
            
            // Decrement supply_on_hand
            $material->supply_on_hand -= $item['quantity'];
            $material->save();

            $equipmentNames[] = $item['name'] . ' (x' . $item['quantity'] . ')';
            $totalQuantity += $item['quantity'];
        }

        // Save into BorrowLog as a single entry
        BorrowLog::create([
            'student_name' => $request->student_name,
            'contact_info' => $request->contact_info,
            'clinical_instructor' => $request->clinical_instructor,
            'procedure' => 'N/A', // Removed from form, keeping fallback for DB schema
            'equipment' => implode("\n", $equipmentNames),
            'quantity' => $totalQuantity,
            'status' => 'Borrowed',
            'date_borrowed' => Carbon::today(),
            'expected_returned_date' => $request->expected_returned_date,
        ]);

        return redirect()->back()->with('success', 'Borrow request submitted successfully!');
    }
}
