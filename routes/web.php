<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');
    Route::resource('/category', \App\Http\Controllers\CategoryController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/supplier', \App\Http\Controllers\SupplierController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/item', \App\Http\Controllers\ItemController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/transaction', \App\Http\Controllers\TransactionController::class)->only(['index', 'create', 'store', 'show'])->middleware('role:Superadmin,Admin,Manajer,Staf Gudang');

    Route::get('/report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index')->middleware('role:Superadmin,Admin,Manajer');
    Route::get('/report/print', [\App\Http\Controllers\ReportController::class, 'print'])->name('report.print')->middleware('role:Superadmin,Admin,Manajer');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
