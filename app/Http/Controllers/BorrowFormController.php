<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedure;
use App\Models\FnpMaterial;
use App\Models\HaMaterial;
use App\Models\BorrowLog;
use Carbon\Carbon;

class BorrowFormController extends Controller
{
    public function create()
    {
        $procedures = Procedure::all();
        $fnpMaterials = FnpMaterial::all();
        $haMaterials = HaMaterial::all();

        return view('borrow-form.create', compact('procedures', 'fnpMaterials', 'haMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'clinical_instructor' => 'required|string|max:255',
            'procedure' => 'required|string|max:255',
            'equipment_type' => 'required|in:FNP,HA',
            'equipment_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'expected_returned_date' => 'required|date|after_or_equal:today',
        ]);

        $equipmentName = '';

        if ($request->equipment_type === 'FNP') {
            $material = FnpMaterial::findOrFail($request->equipment_id);
            $available = max(0, $material->total_quantity - $material->borrowed);
            
            if ($request->quantity > $available) {
                return back()->withErrors(['quantity' => 'Not enough items available. Only ' . $available . ' remaining for ' . $material->name . '.'])->withInput();
            }

            $equipmentName = $material->name;
            
            // Increment borrowed count safely
            $material->borrowed += $request->quantity;
            $material->save();
        } else {
            $material = HaMaterial::findOrFail($request->equipment_id);
            $available = max(0, $material->total_quantity - $material->borrowed);
            
            if ($request->quantity > $available) {
                return back()->withErrors(['quantity' => 'Not enough items available. Only ' . $available . ' remaining for ' . $material->name . '.'])->withInput();
            }

            $equipmentName = $material->name;

            // Increment borrowed count safely
            $material->borrowed += $request->quantity;
            $material->save();
        }

        // Save into BorrowLog
        BorrowLog::create([
            'student_name' => $request->student_name,
            'contact_info' => $request->contact_info,
            'clinical_instructor' => $request->clinical_instructor,
            'procedure' => $request->procedure,
            'equipment' => $equipmentName,
            'quantity' => $request->quantity,
            'status' => 'Borrowed',
            'date_borrowed' => Carbon::today(),
            'expected_returned_date' => $request->expected_returned_date,
        ]);

        return redirect()->back()->with('success', 'Borrow request submitted successfully!');
    }
}
