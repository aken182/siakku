<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\HutangController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\BelanjaBarangController;

Route::controller(BelanjaBarangController::class)->group(function () {
      Route::get('/belanja-barang/unit-sp', 'index')->name('bsp-belanja-barang');
      Route::get('/belanja-barang/unit-sp/list', 'dataTable')->name('bsp-belanja-barang.list');
      Route::get('/belanja-barang/unit-sp/create-larantuka', 'create')->name('bsp-belanja-barang.create-lrtk');
      Route::get('/belanja-barang/unit-sp/create-waiwerang', 'create')->name('bsp-belanja-barang.create-wrg');
      Route::get('/belanja-barang/unit-sp/create-pasar-baru', 'create')->name('bsp-belanja-barang.create-psr');
      Route::get('/belanja-barang/unit-sp/show/{id}', 'show')->name('bsp-belanja-barang.show');
      Route::post('/belanja-barang/unit-sp/store', 'store')->name('bsp-belanja-barang.store');
      Route::get('/belanja-barang/unit-sp/detail', 'detail')->name('bsp-belanja-barang.detail');
});
Route::get('/belanja-lain/unit-sp', [BelanjaController::class, 'index'])->name('bsp-belanja-lain');
Route::get('/hutang/unit-sp', [HutangController::class, 'index'])->name('bsp-hutang');
