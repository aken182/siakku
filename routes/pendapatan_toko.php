<?php

use App\Http\Controllers\transaksi\PelunasanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\PendapatanController;


Route::get('/penjualan/unit-pertokoan', [PenjualanController::class, 'index'])->name('ptk-penjualan');
Route::get('/penjualan/unit-pertokoan/list', [PenjualanController::class, 'dataTablePenjualan'])->name('ptk-penjualan.list');
Route::get('/penjualan/unit-pertokoan/create-barang', [PenjualanController::class, 'createBarang'])->name('ptk-penjualan.create-barang');
Route::get('/penjualan/unit-pertokoan/show/{id}', [PenjualanController::class, 'show'])->name('ptk-penjualan.show');
Route::get('/penjualan/unit-pertokoan/pelunasan/{id}', [PelunasanController::class, 'create'])->name('ptk-penjualan.create-pelunasan');
Route::get('/penjualan/unit-pertokoan/create-lainnya', [PenjualanController::class, 'createLainnya'])->name('ptk-penjualan.create-lainnya');
Route::get('/pendapatan/unit-pertokoan', [PendapatanController::class, 'index'])->name('ptk-pendapatan');
