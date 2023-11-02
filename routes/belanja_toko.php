<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\PelunasanController;
use App\Http\Controllers\transaksi\BelanjaBarangController;

Route::group(['middleware' => ['permission:belanja-barang-unit-pertokoan-view']], function () {
      Route::controller(BelanjaBarangController::class)->group(function () {
            Route::get('/belanja-barang/unit-pertokoan', 'index')->name('btk-belanja-barang');
            Route::get('/belanja-barang/unit-pertokoan/list', 'dataTable')->name('btk-belanja-barang.list');
            Route::get('/belanja-barang/unit-pertokoan/show/{id}', 'show')->name('btk-belanja-barang.show');
      });
      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/belanja-barang/unit-pertokoan/pelunasan/show/{id}', 'show')->name('btk-belanja-barang.show-pelunasan');
      });
});

Route::group(['middleware' => ['permission:belanja-barang-unit-pertokoan-transaction']], function () {
      Route::controller(BelanjaBarangController::class)->group(function () {
            Route::get('/belanja-barang/unit-pertokoan/create-larantuka', 'create')->name('btk-belanja-barang.create-lrtk');
            Route::get('/belanja-barang/unit-pertokoan/create-waiwerang', 'create')->name('btk-belanja-barang.create-wrg');
            Route::get('/belanja-barang/unit-pertokoan/create-pasar-baru', 'create')->name('btk-belanja-barang.create-psr');
            Route::post('/belanja-barang/unit-pertokoan/store', 'store')->name('btk-belanja-barang.store');
            Route::get('/belanja-barang/unit-pertokoan/detail', 'detail')->name('btk-belanja-barang.detail');
      });

      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/belanja-barang/unit-pertokoan/pelunasan/create', 'create')->name('btk-belanja-barang.create-pelunasan');
            Route::post('/belanja-barang/unit-pertokoan/pelunasan/store', 'store')->name('btk-belanja-barang.store-pelunasan');
            Route::get('/belanja-barang/unit-pertokoan/pelunasan/detail', 'detail')->name('btk-belanja-barang.detail-pelunasan');
      });
});

Route::group(['middleware' => ['permission:belanja-lain-unit-pertokoan-view']], function () {
      Route::controller(BelanjaController::class)->group(function () {
            Route::get('/belanja-lain/unit-pertokoan', 'index')->name('btk-belanja-lain');
            Route::get('/belanja-lain/unit-pertokoan/list', 'dataTable')->name('btk-belanja-lain.list');
            Route::get('/belanja-lain/unit-pertokoan/show/{id}', 'show')->name('btk-belanja-lain.show');
      });
      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/belanja-lain/unit-pertokoan/pelunasan/show/{id}', 'show')->name('btk-belanja-lain.show-pelunasan');
      });
});

Route::group(['middleware' => ['permission:belanja-lain-unit-pertokoan-transaction']], function () {
      Route::controller(BelanjaController::class)->group(function () {
            Route::get('/belanja-lain/unit-pertokoan/create', 'create')->name('btk-belanja-lain.create');
            Route::post('/belanja-lain/unit-pertokoan/store', 'store')->name('btk-belanja-lain.store');
            Route::get('/belanja-lain/unit-pertokoan/detail', 'detail')->name('btk-belanja-lain.detail');
      });

      Route::controller(PelunasanController::class)->group(function () {
            Route::get('/belanja-lain/unit-pertokoan/pelunasan/create', 'create')->name('btk-belanja-lain.create-pelunasan');
            Route::post('/belanja-lain/unit-pertokoan/pelunasan/store', 'store')->name('btk-belanja-lain.store-pelunasan');
            Route::get('/belanja-lain/unit-pertokoan/pelunasan/detail', 'detail')->name('btk-belanja-lain.detail-pelunasan');
      });
});
