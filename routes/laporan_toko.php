<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laporan\JurnalController;
use App\Http\Controllers\laporan\LabaRugiController;
use App\Http\Controllers\laporan\BukuBesarController;
use App\Http\Controllers\laporan\NeracaSaldoController;
use App\Http\Controllers\laporan\LaporanGudangController;
use App\Http\Controllers\detail\DetailTransaksiController;
use App\Http\Controllers\laporan\LaporanSimpananController;
use App\Http\Controllers\laporan\LaporanPenjualanController;
use App\Http\Controllers\laporan\LaporanTransaksiController;
use App\Http\Controllers\laporan\LaporanAktivaTetapController;

Route::get('/laporan-gudang/unit-pertokoan', [LaporanGudangController::class, 'index'])->name('lut-gudang');
Route::get('/laporan-gudang/unit-pertokoan/list', [LaporanGudangController::class, 'list'])->name('lut-gudang.list');
Route::get('/laporan-penjualan/unit-pertokoan', [LaporanPenjualanController::class, 'index'])->name('lut-penjualan');
Route::get('/laporan-transaksi/unit-pertokoan', [LaporanTransaksiController::class, 'index'])->name('lut-transaksi');
Route::get('/laporan-transaksi/unit-pertokoan/detail/{id}/{detail}/{unit}', [DetailTransaksiController::class, 'index'])->name('lut-transaksi.detail');
Route::get('/laporan-aktiva-tetap/unit-pertokoan', [LaporanAktivaTetapController::class, 'index'])->name('lut-aktivatetap');
Route::get('/laporan-aktiva-tetap/unit-pertokoan/list', [LaporanAktivaTetapController::class, 'list'])->name('lut-aktivatetap.list');
Route::get('/kartu-toko', [LaporanSimpananController::class, 'index'])->name('lut-kartu-toko');
Route::get('/jurnal/unit-pertokoan', [JurnalController::class, 'index'])->name('lut-jurnal');
Route::get('/jurnal/unit-pertokoan/detail/{id}/{detail}/{unit}', [DetailTransaksiController::class, 'index'])->name('lut-jurnal.detail');
Route::get('/jurnal/unit-pertokoan/pdf/{bulan}/{tahun}', [JurnalController::class, 'pdf'])->name('lut-jurnal.pdf');
Route::get('/buku-besar/unit-pertokoan', [BukuBesarController::class, 'index'])->name('lut-buku-besar');
Route::get('/buku-besar/unit-pertokoan/detail/{id}/{detail}/{unit}', [DetailTransaksiController::class, 'index'])->name('lut-buku-besar.detail');
Route::get('/buku-besar/unit-pertokoan/pdf/{bulan}/{tahun}/{id_coa}', [BukuBesarController::class, 'pdf'])->name('lut-buku-besar.pdf');
Route::get('/laba-rugi/unit-pertokoan', [LabaRugiController::class, 'index'])->name('lut-laba-rugi');
Route::get('/neraca/unit-pertokoan', [NeracaSaldoController::class, 'index'])->name('lut-neraca');
Route::get('/neraca-saldo/unit-pertokoan', [NeracaSaldoController::class, 'neracaSaldo'])->name('lut-neraca-saldo');
