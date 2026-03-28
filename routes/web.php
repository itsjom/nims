<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FnpMaterialController;
use App\Http\Controllers\HaMaterialController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProcedureController;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/logs/borrowing', [LogController::class, 'borrowing'])->name('logs.borrowing');
Route::get('/logs/returned', [LogController::class, 'returned'])->name('logs.returned');

Route::get('/ci-monitoring', function() {
    return view('ci-monitoring.index');
})->name('ci-monitoring.index');

Route::get('/procedures', [ProcedureController::class, 'index'])->name('procedures.index');
Route::post('/procedures', [ProcedureController::class, 'store'])->name('procedures.store');

Route::get('/fnp-materials', [FnpMaterialController::class, 'index'])->name('fnp-materials.index');
Route::post('/fnp-materials', [FnpMaterialController::class, 'store'])->name('fnp-materials.store');

Route::get('/ha-materials', [HaMaterialController::class, 'index'])->name('ha-materials.index');
Route::post('/ha-materials', [HaMaterialController::class, 'store'])->name('ha-materials.store');
