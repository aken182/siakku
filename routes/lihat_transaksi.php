<?php

use App\Http\Controllers\transaksi\BelanjaBarangController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\PelunasanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\transaksi\PenarikanController;
use App\Http\Controllers\transaksi\PendapatanController;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\PenyusutanController;
use App\Http\Controllers\transaksi\PinjamanController;
use App\Http\Controllers\transaksi\TransaksiShuController;
use App\Http\Controllers\transaksi\TransferSaldoController;

Route::group(['middleware' => ['permission:show-transaction-unit-pertokoan']], function () {
      Route::get('/simpanan/unit-pertokoan/show/{id}', [SimpananController::class, 'show'])->name('stk-simpanan.show');
      Route::get('/simpanan/unit-pertokoan/show-tarik/{id}', [PenarikanController::class, 'show'])->name('stk-penarikan.show');
      Route::get('/shu/unit-pertokoan/transaksi/show/{id}', [TransaksiShuController::class, 'show'])->name('shu-unit-pertokoan.transaksi-show');
      Route::get('/penyusutan/unit-pertokoan/show/{id}', [PenyusutanController::class, 'show'])->name('penyusutan-toko.show');
      Route::get('/penjualan/unit-pertokoan/show/{id}', [PenjualanController::class, 'show'])->name('ptk-penjualan.show');
      Route::get('/penjualan/unit-pertokoan/pelunasan/show/{id}', [PelunasanController::class, 'show'])->name('ptk-penjualan.show-pelunasan');
      Route::get('/pendapatan/unit-pertokoan/show/{id}', [PendapatanController::class, 'show'])->name('ptk-pendapatan.show');
      Route::get('/transfer-saldo-kas-bank/unit-pertokoan/show/{id}', [TransferSaldoController::class, 'show'])->name('transfer-toko.show');
      Route::get('/belanja-barang/unit-pertokoan/show/{id}', [BelanjaBarangController::class, 'show'])->name('btk-belanja-barang.show');
      Route::get('/belanja-barang/unit-pertokoan/pelunasan/show/{id}', [PelunasanController::class, 'show'])->name('btk-belanja-barang.show-pelunasan');
      Route::get('/belanja-lain/unit-pertokoan/show/{id}', [BelanjaController::class, 'show'])->name('btk-belanja-lain.show');
      Route::get('/belanja-lain/unit-pertokoan/pelunasan/show/{id}', [PelunasanController::class, 'show'])->name('btk-belanja-lain.show-pelunasan');
});

Route::group(['middleware' => ['permission:show-transaction-unit-sp']], function () {
      Route::get('/simpanan/unit-sp/show/{id}', [SimpananController::class, 'show'])->name('sp-simpanan.show');
      Route::get('/simpanan/unit-sp/show-tarik/{id}', [PenarikanController::class, 'show'])->name('sp-penarikan.show');
      Route::get('/shu/unit-sp/transaksi/show/{id}', [TransaksiShuController::class, 'show'])->name('shu-unit-sp.transaksi-show');
      Route::get('/pinjaman/unit-sp/show/{id}', [PinjamanController::class, 'show'])->name('pp-pinjaman.show');
      Route::get('/pinjaman/unit-sp/show-angsuran/{id}', [PelunasanController::class, 'show'])->name('pp-angsuran.show-pelunasan');
      Route::get('/penyusutan/unit-sp/show/{id}', [PenyusutanController::class, 'show'])->name('penyusutan-sp.show');
      Route::get('/pendapatan/unit-sp/show /{id}', [PendapatanController::class, 'show'])->name('pendapatan-unit-sp.show');
      Route::get('/transfer-saldo-kas-bank/unit-sp/show/{id}', [TransferSaldoController::class, 'show'])->name('transfer-sp.show');
      Route::get('/belanja-barang/unit-sp/show/{id}', [BelanjaBarangController::class, 'show'])->name('bsp-belanja-barang.show');
      Route::get('/belanja-barang/unit-sp/pelunasan/show/{id}', [PelunasanController::class, 'show'])->name('bsp-belanja-barang.show-pelunasan');
      Route::get('/belanja-lain/unit-sp/show/{id}', [BelanjaController::class, 'show'])->name('bsp-belanja-lain.show');
      Route::get('/belanja-lain/unit-sp/pelunasan/show/{id}', [PelunasanController::class, 'show'])->name('bsp-belanja-lain.show-pelunasan');
});
