<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\BarangController;
use App\Http\Controllers\master_data\BarangEceranController;
use App\Http\Controllers\master_data\MasterSimpananController;

Route::get('/inventaris/unit-sp', [BarangController::class, 'index'])->name('mds-inventaris');
Route::get('/inventaris-eceran/unit-sp', [BarangEceranController::class, 'index'])->name('mds-inventaris-eceran');
Route::get('/master-simpanan', [MasterSimpananController::class, 'index'])->name('mds-simpanan');
