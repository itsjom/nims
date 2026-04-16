<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsrNconT1;
use App\Models\CsrConT1;

class MasterEquipmentController extends Controller
{
    public function index()
    {
        $nconMaterials = CsrNconT1::all();
        $conMaterials = CsrConT1::all();
        
        $materials = collect()->merge($nconMaterials)->merge($conMaterials)->sortBy('item_code');
        
        return view('master-equipment.index', compact('materials'));
    }
}
