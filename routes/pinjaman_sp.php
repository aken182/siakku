<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PinjamanController;
use App\Http\Controllers\transaksi\PelunasanController;

Route::get('/pinjaman/unit-sp/pinjaman-history', [PinjamanController::class, 'index'])->name('pp-pinjaman');
Route::get('/pinjaman/unit-sp/angsuran-history', [PelunasanController::class, 'index'])->name('pp-angsuran');
