<?php

use App\Http\Controllers\transaksi\PelunasanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\PendapatanController;


Route::controller(PenjualanController::class)->group(function () {
      Route::get('/penjualan/unit-pertokoan', 'index')->name('ptk-penjualan');
      Route::get('/penjualan/unit-pertokoan/list', 'dataTablePenjualan')->name('ptk-penjualan.list');
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
      Route::get('/penjualan/unit-pertokoan/show/{id}', 'show')->name('ptk-penjualan.show');
});
Route::controller(PelunasanController::class)->group(function () {
      Route::get('/penjualan/unit-pertokoan/pelunasan/create', 'create')->name('ptk-penjualan.create-pelunasan');
      Route::get('/penjualan/unit-pertokoan/pelunasan/show/{id}', 'show')->name('ptk-penjualan.show-pelunasan');
      Route::post('/penjualan/unit-pertokoan/pelunasan/store', 'store')->name('ptk-penjualan.store-pelunasan');
      Route::get('/penjualan/unit-pertokoan/pelunasan/detail', 'detail')->name('ptk-penjualan.detail-pelunasan');
});
Route::get('/pendapatan/unit-pertokoan', [PendapatanController::class, 'index'])->name('ptk-pendapatan');
