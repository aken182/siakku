<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laporan\JurnalController;
use App\Http\Controllers\laporan\LabaRugiController;
use App\Http\Controllers\laporan\BukuBesarController;
use App\Http\Controllers\laporan\NeracaSaldoController;
use App\Http\Controllers\laporan\LaporanPinjamanController;
use App\Http\Controllers\laporan\LaporanSimpananController;
use App\Http\Controllers\laporan\LaporanTransaksiController;

//9.laporan unit simpan pinjam
Route::get('/laporan-transaksi/unit-sp', [LaporanTransaksiController::class, 'index'])->name('lus-transaksi');
Route::get('/laporan-simpanan/unit-sp', [LaporanSimpananController::class, 'index'])->name('lus-simpanan');
Route::get('/laporan-simpanan-sukarela-berbunga/unit-sp', [LaporanSimpananController::class, 'index'])->name('lus-simpanan-sb');
Route::get('/laporan-pinjaman/unit-sp', [LaporanPinjamanController::class, 'index'])->name('lus-pinjaman');
Route::get('/jurnal/unit-sp', [JurnalController::class, 'index'])->name('lus-jurnal');
Route::get('/buku-besar/unit-sp', [BukuBesarController::class, 'index'])->name('lus-buku-besar');
Route::get('/laba-rugi/unit-sp', [LabaRugiController::class, 'index'])->name('lus-laba-rugi');
Route::get('/neraca-saldo/unit-sp', [NeracaSaldoController::class, 'index'])->name('lus-neraca');
