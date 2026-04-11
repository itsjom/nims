<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FnpMaterial;
use App\Models\Procedure;

class FnpMaterialController extends Controller
{
    public function index()
    {
        $materials = FnpMaterial::all();
        $procedures = Procedure::orderBy('name', 'asc')->get();
        return view('fnp-materials.index', compact('materials', 'procedures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'used_in_procedure' => 'nullable|array',
            'used_in_procedure.*' => 'string|max:255',
            'total_quantity' => 'required|integer|min:0',
            'storage_location' => 'nullable|string|max:255',
            'condition' => 'required|in:Good,New,Damage',
        ]);

        $data = $request->all();
        if(isset($data['used_in_procedure']) && is_array($data['used_in_procedure'])) {
            $data['used_in_procedure'] = implode(', ', $data['used_in_procedure']);
        }

        $maxFnp = \App\Models\FnpMaterial::max('track_id') ?? 0;
        $maxHa = \App\Models\HaMaterial::max('track_id') ?? 0;
        $data['track_id'] = max($maxFnp, $maxHa) + 1;

        FnpMaterial::create($data);

        return redirect()->route('fnp-materials.index')->with('success', 'Equipment added successfully.');
    }
}
