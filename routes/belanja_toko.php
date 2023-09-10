<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\HutangController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\BelanjaBarangController;


Route::get('/belanja-barang/unit-pertokoan', [BelanjaBarangController::class, 'index'])->name('btk-belanja-barang');
Route::get('/belanja-lain/unit-pertokoan', [BelanjaController::class, 'index'])->name('btk-belanja-lain');
Route::get('/hutang/unit-pertokoan', [HutangController::class, 'index'])->name('btk-hutang');
