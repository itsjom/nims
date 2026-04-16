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

        return view('borrow-form.create', compact('nconMaterials', 'conMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'clinical_instructor' => 'required|string|max:255',
            'equipment_type' => 'required|in:NCON,CON',
            'equipment_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'expected_returned_date' => 'required|date|after_or_equal:today',
        ]);

        $equipmentName = '';

        if ($request->equipment_type === 'NCON') {
            $material = CsrNconT1::findOrFail($request->equipment_id);
            $available = $material->supply_on_hand;
            
            if ($request->quantity > $available) {
                return back()->withErrors(['quantity' => 'Not enough items available. Only ' . $available . ' remaining for ' . $material->item_name . '.'])->withInput();
            }

            $equipmentName = $material->item_name;
            
            // Decrement supply_on_hand
            $material->supply_on_hand -= $request->quantity;
            $material->save();
        } else {
            $material = CsrConT1::findOrFail($request->equipment_id);
            $available = $material->supply_on_hand;
            
            if ($request->quantity > $available) {
                return back()->withErrors(['quantity' => 'Not enough items available. Only ' . $available . ' remaining for ' . $material->item_name . '.'])->withInput();
            }

            $equipmentName = $material->item_name;

            // Decrement supply_on_hand
            $material->supply_on_hand -= $request->quantity;
            $material->save();
        }

        // Save into BorrowLog
        BorrowLog::create([
            'student_name' => $request->student_name,
            'contact_info' => $request->contact_info,
            'clinical_instructor' => $request->clinical_instructor,
            'procedure' => 'N/A', // Removed from form, keeping fallback for DB schema
            'equipment' => $equipmentName,
            'quantity' => $request->quantity,
            'status' => 'Borrowed',
            'date_borrowed' => Carbon::today(),
            'expected_returned_date' => $request->expected_returned_date,
        ]);

        return redirect()->back()->with('success', 'Borrow request submitted successfully!');
    }
}
