<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedure;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::orderBy('procedure_id', 'asc')->get();
        return view('procedures.index', compact('procedures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        Procedure::create([
            'name' => $request->name,
            'department' => $request->department,
        ]);

        return redirect()->route('procedures.index')->with('success', 'Procedure added successfully.');
    }
}
