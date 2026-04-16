<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsrNconT1Controller;
use App\Http\Controllers\CsrConT1Controller;
use App\Http\Controllers\MasterEquipmentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\BorrowFormController;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Public Borrow Form Routes
Route::get('/borrow-equipment', [BorrowFormController::class, 'create'])->name('borrow.create');
Route::post('/borrow-equipment', [BorrowFormController::class, 'store'])->name('borrow.store');

Route::get('/return-equipment', [App\Http\Controllers\ReturnFormController::class, 'create'])->name('return.create');
Route::post('/return-equipment', [App\Http\Controllers\ReturnFormController::class, 'store'])->name('return.store');


Route::get('/logs/borrowing', [LogController::class, 'borrowing'])->name('logs.borrowing');
Route::get('/logs/returned', [LogController::class, 'returned'])->name('logs.returned');

Route::get('/ci-monitoring', function() {
    return view('ci-monitoring.index');
})->name('ci-monitoring.index');

Route::get('/procedures', [ProcedureController::class, 'index'])->name('procedures.index');
Route::post('/procedures', [ProcedureController::class, 'store'])->name('procedures.store');

Route::get('/csr-ncon-t1', [CsrNconT1Controller::class, 'index'])->name('csr-ncon-t1.index');
Route::post('/csr-ncon-t1', [CsrNconT1Controller::class, 'store'])->name('csr-ncon-t1.store');
Route::put('/csr-ncon-t1/{id}', [CsrNconT1Controller::class, 'update'])->name('csr-ncon-t1.update');
Route::delete('/csr-ncon-t1/{id}', [CsrNconT1Controller::class, 'destroy'])->name('csr-ncon-t1.destroy');

Route::get('/csr-con-t1', [CsrConT1Controller::class, 'index'])->name('csr-con-t1.index');
Route::post('/csr-con-t1', [CsrConT1Controller::class, 'store'])->name('csr-con-t1.store');
Route::put('/csr-con-t1/{id}', [CsrConT1Controller::class, 'update'])->name('csr-con-t1.update');
Route::delete('/csr-con-t1/{id}', [CsrConT1Controller::class, 'destroy'])->name('csr-con-t1.destroy');

Route::get('/master-equipment', [MasterEquipmentController::class, 'index'])->name('master-equipment.index');
