<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\PelunasanController;
use App\Http\Controllers\transaksi\BelanjaBarangController;

Route::group(['middleware' => ['permission:belanja-barang-unit-sp-view']], function () {
      Route::controller(BelanjaBarangController::class)->group(function () {
            Route::get('/belanja-barang/unit-sp', 'index')->name('bsp-belanja-barang');
            Route::get('/belanja-barang/unit-sp/list', 'dataTable')->name('bsp-belanja-barang.list');
      });
});

Route::group(['middleware' => ['permission:belanja-barang-unit-sp-transaction']], function () {
      Route::controller(BelanjaBarangController::class)->group(function () {
            Route::get('/belanja-barang/unit-sp/create-larantuka', 'create')->name('bsp-belanja-barang.create-lrtk');
            Route::get('/belanja-barang/unit-sp/create-waiwerang', 'create')->name('bsp-belanja-barang.create-wrg');
            Route::get('/belanja-barang/unit-sp/create-pasar-baru', 'create')->name('bsp-belanja-barang.create-psr');
            Route::post('/belanja-barang/unit-sp/store', 'store')->name('bsp-belanja-barang.store');
            Route::get('/belanja-barang/unit-sp/detail', 'detail')->name('bsp-belanja-barang.detail');
      });
      Route::controller(PelunasanController::class)->group(function () {
            //pelunasan-belanja-barang
            Route::get('/belanja-barang/unit-sp/pelunasan/create', 'create')->name('bsp-belanja-barang.create-pelunasan');
            Route::post('/belanja-barang/unit-sp/pelunasan/store', 'store')->name('bsp-belanja-barang.store-pelunasan');
            Route::get('/belanja-barang/unit-sp/pelunasan/detail', 'detail')->name('bsp-belanja-barang.detail-pelunasan');
      });
});

Route::group(['middleware' => ['permission:belanja-lain-unit-sp-view']], function () {
      Route::controller(BelanjaController::class)->group(function () {
            Route::get('/belanja-lain/unit-sp', 'index')->name('bsp-belanja-lain');
            Route::get('/belanja-lain/unit-sp/list', 'dataTable')->name('bsp-belanja-lain.list');
      });
});

Route::group(['middleware' => ['permission:belanja-lain-unit-sp-transaction']], function () {
      Route::controller(BelanjaController::class)->group(function () {
            Route::get('/belanja-lain/unit-sp/create', 'create')->name('bsp-belanja-lain.create');
            Route::post('/belanja-lain/unit-sp/store', 'store')->name('bsp-belanja-lain.store');
            Route::get('/belanja-lain/unit-sp/detail', 'detail')->name('bsp-belanja-lain.detail');
      });
      Route::controller(PelunasanController::class)->group(function () {
            //pelunasan-belanja-lainnya
            Route::get('/belanja-lain/unit-sp/pelunasan/create', 'create')->name('bsp-belanja-lain.create-pelunasan');
            Route::post('/belanja-lain/unit-sp/pelunasan/store', 'store')->name('bsp-belanja-lain.store-pelunasan');
            Route::get('/belanja-lain/unit-sp/pelunasan/detail', 'detail')->name('bsp-belanja-lain.detail-pelunasan');
      });
});
