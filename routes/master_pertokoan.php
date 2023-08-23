<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\BarangController;
use App\Http\Controllers\master_data\PenyediaController;
use App\Http\Controllers\master_data\BarangEceranController;

Route::get('/persediaan/unit-pertokoan', [BarangController::class, 'index'])->name('mdt-persediaan');
Route::get('/inventaris/unit-pertokoan', [BarangController::class, 'index'])->name('mdt-inventaris');
Route::get('/persediaan-eceran/unit-pertokoan', [BarangEceranController::class, 'index'])->name('mdt-persediaan-eceran');
Route::get('/inventaris-eceran/unit-pertokoan', [BarangEceranController::class, 'index'])->name('mdt-inventaris-eceran');
Route::get('/vendor', [PenyediaController::class, 'index'])->name('mdt-vendor');
