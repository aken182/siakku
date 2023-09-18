<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\HutangController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\BelanjaBarangController;

Route::controller(BelanjaBarangController::class)->group(function () {
      Route::get('/belanja-barang/unit-pertokoan', 'index')->name('btk-belanja-barang');
      Route::get('/belanja-barang/unit-pertokoan/list', 'dataTable')->name('btk-belanja-barang.list');
      Route::get('/belanja-barang/unit-pertokoan/create-larantuka', 'create')->name('btk-belanja-barang.create-lrtk');
      Route::get('/belanja-barang/unit-pertokoan/create-waiwerang', 'create')->name('btk-belanja-barang.create-wrg');
      Route::get('/belanja-barang/unit-pertokoan/create-pasar-baru', 'create')->name('btk-belanja-barang.create-psr');
      Route::get('/belanja-barang/unit-pertokoan/show/{id}', 'show')->name('btk-belanja-barang.show');
      Route::post('/belanja-barang/unit-pertokoan/store', 'store')->name('btk-belanja-barang.store');
      Route::get('/belanja-barang/unit-pertokoan/detail', 'detail')->name('btk-belanja-barang.detail');
});

Route::get('/belanja-lain/unit-pertokoan', [BelanjaController::class, 'index'])->name('btk-belanja-lain');
Route::get('/hutang/unit-pertokoan', [HutangController::class, 'index'])->name('btk-hutang');
