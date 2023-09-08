<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laporan\JurnalController;
use App\Http\Controllers\laporan\LabaRugiController;
use App\Http\Controllers\laporan\BukuBesarController;
use App\Http\Controllers\laporan\NeracaSaldoController;
use App\Http\Controllers\laporan\LaporanGudangController;
use App\Http\Controllers\laporan\LaporanSimpananController;
use App\Http\Controllers\laporan\LaporanPenjualanController;
use App\Http\Controllers\laporan\LaporanTransaksiController;

Route::get('/laporan-gudang/unit-pertokoan', [LaporanGudangController::class, 'index'])->name('lut-gudang');
Route::get('/laporan-penjualan/unit-pertokoan', [LaporanPenjualanController::class, 'index'])->name('lut-penjualan');
Route::get('/laporan-transaksi/unit-pertokoan', [LaporanTransaksiController::class, 'index'])->name('lut-transaksi');
Route::get('/kartu-toko', [LaporanSimpananController::class, 'index'])->name('lut-kartu-toko');
Route::get('/jurnal/unit-pertokoan', [JurnalController::class, 'index'])->name('lut-jurnal');
Route::get('/buku-besar/unit-pertokoan', [BukuBesarController::class, 'index'])->name('lut-buku-besar');
Route::get('/laba-rugi/unit-pertokoan', [LabaRugiController::class, 'index'])->name('lut-laba-rugi');
Route::get('/neraca-saldo/unit-pertokoan', [NeracaSaldoController::class, 'index'])->name('lut-neraca');
