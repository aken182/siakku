<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PiutangController;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\PendapatanController;


Route::get('/penjualan/unit-pertokoan', [PenjualanController::class, 'index'])->name('ptk-penjualan');
Route::get('/pendapatan/unit-pertokoan', [PendapatanController::class, 'index'])->name('ptk-pendapatan');
Route::get('/piutang-barang/unit-pertokoan', [PiutangController::class, 'index'])->name('ptk-piutang');
