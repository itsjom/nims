<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FnpMaterial;
use App\Models\HaMaterial;

class MasterEquipmentController extends Controller
{
    public function index()
    {
        $fnpMaterials = FnpMaterial::all();
        $haMaterials = HaMaterial::all();
        
        $materials = collect()->merge($fnpMaterials)->merge($haMaterials)->sortBy('track_id');
        
        return view('master-equipment.index', compact('materials'));
    }
}
