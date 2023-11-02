<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PinjamanController;
use App\Http\Controllers\transaksi\PelunasanController;

Route::group(['middleware' => ['permission:pinjaman-unit-sp-view']], function () {
      Route::controller(PinjamanController::class)->group(function () {
            Route::get('/pinjaman/unit-sp/pinjaman-history', 'index')->name('pp-pinjaman');
            Route::get('/pinjaman/unit-sp/list', 'dataTable')->name('pp-pinjaman.list');
            Route::get('/pinjaman/unit-sp/show/{id}', 'show')->name('pp-pinjaman.show');
      });
});

Route::group(['middleware' => ['permission:pinjaman-unit-sp-transaction']], function () {
      Route::controller(PinjamanController::class)->group(function () {
            Route::get('/pinjaman/unit-sp/create-baru', 'create')->name('pp-pinjaman.create-baru');
            Route::get('/pinjaman/unit-sp/create-masa-lalu', 'create')->name('pp-pinjaman.create-masa-lalu');
            Route::get('/pinjaman/unit-sp/create-pinjam-tindis', 'create')->name('pp-pinjaman.create-pinjam-tindis');
            Route::get('/pinjaman/unit-sp/detail-pengajuan', 'getDataPengajuanAnggota')->name('pp-pinjaman.detail-pengajuan');
            Route::get('/pinjaman/unit-sp/detail-pinjaman', 'getDataPinjamanAnggota')->name('pp-pinjaman.detail-pinjaman');
            Route::post('/pinjaman/unit-sp/store-baru', 'store')->name('pp-pinjaman.store-baru');
            Route::post('/pinjaman/unit-sp/store-masa-lalu', 'store')->name('pp-pinjaman.store-masa-lalu');
            Route::post('/pinjaman/unit-sp/store-pinjam-tindis', 'store')->name('pp-pinjaman.store-pinjam-tindis');
            Route::get('/pinjaman/unit-sp/detail', 'detail')->name('pp-pinjaman.detail');
      });
});

Route::group(['middleware' => ['permission:pinjaman-unit-sp-angsuran-view']], function () {
      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/pinjaman/unit-sp/angsuran-history', 'index')->name('pp-angsuran');
            Route::get('/pinjaman/unit-sp/list-angsuran', 'dataTable')->name('pp-angsuran.list');
            Route::get('/pinjaman/unit-sp/show-angsuran/{id}', 'show')->name('pp-angsuran.show-pelunasan');
      });
});

Route::group(['middleware' => ['permission:pinjaman-unit-sp-angsuran-transaction']], function () {
      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/pinjaman/unit-sp/create-angsuran', 'create')->name('pp-angsuran.create');
            Route::post('/pinjaman/unit-sp/store-angsuran', 'store')->name('pp-angsuran.store');
            Route::get('/pinjaman/unit-sp/detail-angsuran', 'detail')->name('pp-angsuran.detail-pelunasan');
            Route::get('/pinjaman/unit-sp/get-pinjaman', 'pinjaman')->name('pp-angsuran.pinjaman');
      });
});
