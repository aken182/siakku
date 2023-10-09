<?php

use App\Http\Controllers\detail\DetailTransaksiController;
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
// Route::get('/laporan-transaksi/unit-sp/list', [LaporanTransaksiController::class, 'list'])->name('lus-transaksi.list');
Route::get('/laporan-transaksi/unit-sp/detail/{id}/{detail}/{unit}', [DetailTransaksiController::class, 'index'])->name('lus-transaksi.detail');
Route::get('/laporan-simpanan/unit-sp', [LaporanSimpananController::class, 'index'])->name('lus-simpanan');
Route::get('/laporan-simpanan-sukarela-berbunga/unit-sp', [LaporanSimpananController::class, 'index'])->name('lus-simpanan-sb');
Route::get('/laporan-pinjaman/unit-sp', [LaporanPinjamanController::class, 'index'])->name('lus-pinjaman');
Route::get('/jurnal/unit-sp', [JurnalController::class, 'index'])->name('lus-jurnal');
Route::get('/jurnal/unit-sp/detail/{id}/{detail}/{unit}', [DetailTransaksiController::class, 'index'])->name('lus-jurnal.detail');
Route::get('/jurnal/unit-sp/pdf/{bulan}/{tahun}', [JurnalController::class, 'pdf'])->name('lus-jurnal.pdf');
Route::get('/buku-besar/unit-sp', [BukuBesarController::class, 'index'])->name('lus-buku-besar');
Route::get('/buku-besar/unit-sp/detail/{id}/{detail}/{unit}', [DetailTransaksiController::class, 'index'])->name('lus-buku-besar.detail');
Route::get('/buku-besar/unit-sp/pdf/{bulan}/{tahun}/{id_coa}', [BukuBesarController::class, 'pdf'])->name('lus-buku-besar.pdf');
Route::get('/laba-rugi/unit-sp', [LabaRugiController::class, 'index'])->name('lus-laba-rugi');
Route::get('/neraca-saldo/unit-sp', [NeracaSaldoController::class, 'index'])->name('lus-neraca');
