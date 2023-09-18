<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PelunasanController;
use App\Http\Controllers\transaksi\PendapatanController;

Route::controller(PendapatanController::class)->group(function () {
      Route::get('/pendapatan/unit-sp', 'index')->name('pendapatan-unit-sp');
      Route::get('/pendapatan/unit-sp/list', 'dataTable')->name('pendapatan-unit-sp.list');
      Route::get('/pendapatan/unit-sp/create', 'create')->name('pendapatan-unit-sp.create');
      Route::get('/pendapatan/unit-sp/show/{id}', 'show')->name('pendapatan-unit-sp.show');
      Route::post('/pendapatan/unit-sp/store', 'store')->name('pendapatan-unit-sp.store');
      Route::get('/pendapatan/unit-sp/detail', 'detail')->name('pendapatan-unit-sp.detail');
});
Route::controller(PelunasanController::class)->group(function () {
      //pelunasan-belanja-barang
      Route::get('/belanja-barang/unit-sp/pelunasan/create', 'create')->name('bsp-belanja-barang.create-pelunasan');
      Route::get('/belanja-barang/unit-sp/pelunasan/show/{id}', 'show')->name('bsp-belanja-barang.show-pelunasan');
      Route::post('/belanja-barang/unit-sp/pelunasan/store', 'store')->name('bsp-belanja-barang.store-pelunasan');
      Route::get('/belanja-barang/unit-sp/pelunasan/detail', 'detail')->name('bsp-belanja-barang.detail-pelunasan');
});
