<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\CoaController;
use App\Http\Controllers\transaksi\SaldoAwalController;
use App\Http\Controllers\transaksi\TransferSaldoController;

// master data
Route::controller(CoaController::class)->group(function () {
      Route::get('/coa', 'index')->name('mdu-coa');
      Route::get('/coa/create', 'create')->name('mdu-coa.create');
      Route::post('/coa/store', 'store')->name('mdu-coa.store');
      Route::get('/coa/edit/{id}', 'edit')->name('mdu-coa.edit');
      Route::patch('/coa/update/{id}', 'update')->name('mdu-coa.update');
      Route::delete('/coa/destroy/{id}', 'destroy')->name('mdu-coa.destroy');
});

//transaksi
Route::controller(SaldoAwalController::class)->group(function () {
      //unit toko-index
      Route::get('/saldo-awal/coa/unit-pertokoan', 'index')->name('sltk-coa');
      Route::get('/saldo-awal/persediaan/unit-pertokoan', 'index')->name('sltk-persediaan');
      Route::get('/saldo-awal/inventaris/unit-pertokoan', 'index')->name('sltk-inventaris');
      //unit toko-store-tanggal
      Route::post('/saldo-awal/coa/unit-pertokoan/store-tanggal', 'storeTanggal')->name('sltk-coa.store-tanggal');
      Route::post('/saldo-awal/persediaan/unit-pertokoan/store-tanggal', 'storeTanggal')->name('sltk-persediaan.store-tanggal');
      Route::post('/saldo-awal/inventaris/unit-pertokoan/store-tanggal', 'storeTanggal')->name('sltk-inventaris.store-tanggal');
      //unit toko-create
      Route::get('/saldo-awal/coa/unit-pertokoan/create', 'createSaldoAwal')->name('sltk-coa.create');
      Route::get('/saldo-awal/persediaan/unit-pertokoan/create', 'createSaldoAwal')->name('sltk-persediaan.create');
      Route::get('/saldo-awal/inventaris/unit-pertokoan/create', 'createSaldoAwal')->name('sltk-inventaris.create');
      Route::post('/saldo-awal/coa/unit-pertokoan/store', 'storeCoa')->name('sltk-coa.store');
      Route::post('/saldo-awal/persediaan/unit-pertokoan/store', 'storeBarang')->name('sltk-persediaan.store');
      Route::post('/saldo-awal/inventaris/unit-pertokoan/store', 'storeBarang')->name('sltk-inventaris.store');
      //unit toko-edit
      Route::get('/saldo-awal/coa/unit-pertokoan/edit', 'editCoa')->name('sltk-coa.edit');
      Route::get('/saldo-awal/persediaan/unit-pertokoan/edit', 'editBarang')->name('sltk-persediaan.edit');
      Route::get('/saldo-awal/inventaris/unit-pertokoan/edit', 'editBarang')->name('sltk-inventaris.edit');
      Route::patch('/saldo-awal/coa/unit-pertokoan/update/{id}', 'updateCoa')->name('sltk-coa.update');
      Route::patch('/saldo-awal/persediaan/unit-pertokoan/update/{id}', 'updateBarang')->name('sltk-persediaan.update');
      Route::patch('/saldo-awal/inventaris/unit-pertokoan/update/{id}', 'updateBarang')->name('sltk-inventaris.update');

      //unit sp
      Route::get('/saldo-awal/coa/unit-sp', 'index')->name('slsp-coa');
      Route::get('/saldo-awal/inventaris/unit-sp', 'index')->name('slsp-inventaris');
      //unit sp-store-tanggal
      Route::post('/saldo-awal/coa/unit-sp/store-tanggal', 'storeTanggal')->name('slsp-coa.store-tanggal');
      Route::post('/saldo-awal/inventaris/unit-sp/store-tanggal', 'storeTanggal')->name('slsp-inventaris.store-tanggal');
      //unit sp-create
      Route::get('/saldo-awal/coa/unit-sp/create', 'createSaldoAwal')->name('slsp-coa.create');
      Route::get('/saldo-awal/inventaris/unit-sp/create', 'createSaldoAwal')->name('slsp-inventaris.create');
      Route::post('/saldo-awal/coa/unit-sp/store', 'storeCoa')->name('slsp-coa.store');
      Route::post('/saldo-awal/inventaris/unit-sp/store', 'storeBarang')->name('slsp-inventaris.store');
      //unit sp-edit
      Route::get('/saldo-awal/coa/unit-sp/edit', 'editCoa')->name('slsp-coa.edit');
      Route::get('/saldo-awal/inventaris/unit-sp/edit', 'editBarang')->name('slsp-inventaris.edit');
      Route::patch('/saldo-awal/coa/unit-sp/update/{id}', 'updateCoa')->name('slsp-coa.update');
      Route::patch('/saldo-awal/inventaris/unit-sp/update/{id}', 'updateBarang')->name('slsp-inventaris.update');
});

Route::controller(TransferSaldoController::class)->group(function () {
      //unit toko
      Route::get('/transfer-saldo-kas-bank/unit-pertokoan', 'index')->name('transfer-toko');
      //unit sp
      Route::get('/transfer-saldo-kas-bank/unit-sp', 'index')->name('transfer-sp');
});
