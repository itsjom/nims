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
    Route::post('/ci-monitoring', [App\Http\Controllers\CiMonitoringController::class, 'store'])->name('ci-monitoring.store')->middleware('can:manage ci monitoring');
    Route::delete('/ci-monitoring/{id}', [App\Http\Controllers\CiMonitoringController::class, 'destroy'])->name('ci-monitoring.destroy')->middleware('can:manage ci monitoring');

    Route::get('/procedures', [ProcedureController::class, 'index'])->name('procedures.index');
    Route::post('/procedures', [ProcedureController::class, 'store'])->name('procedures.store')->middleware('can:manage procedures');

    Route::get('/csr-ncon-t1', [CsrNconT1Controller::class, 'index'])->name('csr-ncon-t1.index');
    Route::post('/csr-ncon-t1', [CsrNconT1Controller::class, 'store'])->name('csr-ncon-t1.store')->middleware('can:manage inventory');
    Route::put('/csr-ncon-t1/{id}', [CsrNconT1Controller::class, 'update'])->name('csr-ncon-t1.update')->middleware('can:manage inventory');
    Route::delete('/csr-ncon-t1/{id}', [CsrNconT1Controller::class, 'destroy'])->name('csr-ncon-t1.destroy')->middleware('can:manage inventory');

    Route::get('/csr-con-t1', [CsrConT1Controller::class, 'index'])->name('csr-con-t1.index');
    Route::post('/csr-con-t1', [CsrConT1Controller::class, 'store'])->name('csr-con-t1.store')->middleware('can:manage inventory');
    Route::put('/csr-con-t1/{id}', [CsrConT1Controller::class, 'update'])->name('csr-con-t1.update')->middleware('can:manage inventory');
    Route::delete('/csr-con-t1/{id}', [CsrConT1Controller::class, 'destroy'])->name('csr-con-t1.destroy')->middleware('can:manage inventory');

    Route::get('/master-equipment', [MasterEquipmentController::class, 'index'])->name('master-equipment.index');
    Route::get('/master-equipment/print', [MasterEquipmentController::class, 'print'])->name('master-equipment.print');

    // Administration Routes (Only accessible by admin role)
    Route::middleware(['role:System Admin'])->group(function () {
        // Role Management Routes
        Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [\App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [\App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [\App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');

        // User Management Routes
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
});
