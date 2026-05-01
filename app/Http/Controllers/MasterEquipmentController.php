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

    public function print()
    {
        $nconMaterials = CsrNconT1::all();
        $conMaterials = CsrConT1::all();
        
        $materials = collect()->merge($nconMaterials)->merge($conMaterials)->sortBy('item_code');
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('master-equipment.pdf', compact('materials'));
        
        // Use stream() to open in browser, or download() to force download
        return $pdf->stream('master_equipment_' . date('Y-m-d') . '.pdf');
    }
}
