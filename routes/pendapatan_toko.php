<?php

use App\Http\Controllers\transaksi\PelunasanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\PendapatanController;

Route::group(['middleware' => ['permission:penjualan-unit-pertokoan-view']], function () {
      Route::controller(PenjualanController::class)->group(function () {
            Route::get('/penjualan/unit-pertokoan', 'index')->name('ptk-penjualan');
            Route::get('/penjualan/unit-pertokoan/list', 'dataTablePenjualan')->name('ptk-penjualan.list');
            Route::get('/penjualan/unit-pertokoan/show/{id}', 'show')->name('ptk-penjualan.show');
      });

      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/penjualan/unit-pertokoan/pelunasan/show/{id}', 'show')->name('ptk-penjualan.show-pelunasan');
      });
});

Route::group(['middleware' => ['permission:penjualan-unit-pertokoan-transaction']], function () {
      Route::controller(PenjualanController::class)->group(function () {
            Route::get('/penjualan/unit-pertokoan/create-barang/larantuka', 'createBarang')->name('ptk-penjualan.create-barang-lrtk');
            Route::get('/penjualan/unit-pertokoan/create-barang/waiwerang', 'createBarang')->name('ptk-penjualan.create-barang-wrg');
            Route::get('/penjualan/unit-pertokoan/create-barang/pasar-baru', 'createBarang')->name('ptk-penjualan.create-barang-psr');
            Route::get('/penjualan/unit-pertokoan/create-lainnya/larantuka', 'createLainnya')->name('ptk-penjualan.create-lainnya-lrtk');
            Route::get('/penjualan/unit-pertokoan/create-lainnya/waiwerang', 'createLainnya')->name('ptk-penjualan.create-lainnya-wrg');
            Route::get('/penjualan/unit-pertokoan/create-lainnya/pasar-baru', 'createLainnya')->name('ptk-penjualan.create-lainnya-psr');
            Route::get('/penjualan/unit-pertokoan/create-barang/detail', 'detail')->name('ptk-penjualan.detail');
            Route::get('/penjualan/unit-pertokoan/create-lainnya/detail', 'detail')->name('ptk-penjualan.detail');
            Route::post('/penjualan/unit-pertokoan/store-barang', 'store')->name('ptk-penjualan.store-barang');
            Route::post('/penjualan/unit-pertokoan/store-lainnya', 'storeLainnya')->name('ptk-penjualan.store-lainnya');
      });

      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/penjualan/unit-pertokoan/pelunasan/create', 'create')->name('ptk-penjualan.create-pelunasan');
            Route::post('/penjualan/unit-pertokoan/pelunasan/store', 'store')->name('ptk-penjualan.store-pelunasan');
            Route::get('/penjualan/unit-pertokoan/pelunasan/detail', 'detail')->name('ptk-penjualan.detail-pelunasan');
      });
});



Route::group(['middleware' => ['permission:pendapatan-unit-pertokoan-view']], function () {
      Route::controller(PendapatanController::class)->group(function () {
            Route::get('/pendapatan/unit-pertokoan', 'index')->name('ptk-pendapatan');
            Route::get('/pendapatan/unit-pertokoan/list', 'dataTable')->name('ptk-pendapatan.list');
            Route::get('/pendapatan/unit-pertokoan/show/{id}', 'show')->name('ptk-pendapatan.show');
      });
});

Route::group(['middleware' => ['permission:pendapatan-unit-pertokoan-transaction']], function () {
      Route::controller(PendapatanController::class)->group(function () {
            Route::get('/pendapatan/unit-pertokoan/create', 'create')->name('ptk-pendapatan.create');
            Route::post('/pendapatan/unit-pertokoan/store', 'store')->name('ptk-pendapatan.store');
            Route::get('/pendapatan/unit-pertokoan/detail', 'detail')->name('ptk-pendapatan.detail');
      });
});
