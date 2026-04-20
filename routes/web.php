<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsrNconT1Controller;
use App\Http\Controllers\CsrConT1Controller;
use App\Http\Controllers\MasterEquipmentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\BorrowFormController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// Auth Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Borrow Form Routes
Route::get('/borrow-equipment', [BorrowFormController::class, 'create'])->name('borrow.create');
Route::post('/borrow-equipment', [BorrowFormController::class, 'store'])->name('borrow.store');

// Protected Routes
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/return-equipment', [App\Http\Controllers\ReturnFormController::class, 'create'])->name('return.create');
    Route::post('/return-equipment', [App\Http\Controllers\ReturnFormController::class, 'store'])->name('return.store');

    Route::get('/logs/borrowing', [LogController::class, 'borrowing'])->name('logs.borrowing');
    Route::get('/logs/returned', [LogController::class, 'returned'])->name('logs.returned');

    Route::get('/ci-monitoring', [App\Http\Controllers\CiMonitoringController::class, 'index'])->name('ci-monitoring.index');
    Route::post('/ci-monitoring', [App\Http\Controllers\CiMonitoringController::class, 'store'])->name('ci-monitoring.store');
    Route::delete('/ci-monitoring/{id}', [App\Http\Controllers\CiMonitoringController::class, 'destroy'])->name('ci-monitoring.destroy');

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
    Route::get('/master-equipment/print', [MasterEquipmentController::class, 'print'])->name('master-equipment.print');
});
