<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\HutangController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\BelanjaBarangController;

Route::get('/belanja-barang/unit-sp', [BelanjaBarangController::class, 'index'])->name('bsp-belanja-barang');
Route::get('/belanja-lain/unit-sp', [BelanjaController::class, 'index'])->name('bsp-belanja-lain');
Route::get('/hutang/unit-sp', [HutangController::class, 'index'])->name('bsp-hutang');
