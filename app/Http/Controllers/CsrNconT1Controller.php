<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CsrNconT1;

class CsrNconT1Controller extends Controller
{
    public function index()
    {
        $items = CsrNconT1::all();
        return view('csr-ncon-t1.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'ideal_stocks' => 'required|integer|min:0',
            'total_stock' => 'required|integer|min:0',
            'supply_on_hand' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'item_condition' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        CsrNconT1::create($data);

        return redirect()->route('csr-ncon-t1.index')->with('success', 'Item added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = CsrNconT1::findOrFail($id);
        
        $request->validate([
            'item_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'ideal_stocks' => 'required|integer|min:0',
            'total_stock' => 'required|integer|min:0',
            'supply_on_hand' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'item_condition' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $item->update($data);

        return redirect()->route('csr-ncon-t1.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = CsrNconT1::findOrFail($id);
        $item->delete();
        
        return redirect()->route('csr-ncon-t1.index')->with('success', 'Item deleted successfully.');
    }
}
