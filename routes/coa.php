<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\CoaController;
use App\Http\Controllers\transaksi\SaldoAwalController;
use App\Http\Controllers\transaksi\TransferSaldoController;

// master data
Route::controller(CoaController::class)->group(function () {
      Route::get('/coa', 'index')->name('mdu-coa')->middleware('permission:master-coa-view');
      Route::get('/coa/create', 'create')->name('mdu-coa.create')->middleware('permission:master-coa-create');;
      Route::post('/coa/store', 'store')->name('mdu-coa.store')->middleware('permission:master-coa-store');;
      Route::get('/coa/edit/{id}', 'edit')->name('mdu-coa.edit')->middleware('permission:master-coa-edit');;
      Route::patch('/coa/update/{id}', 'update')->name('mdu-coa.update')->middleware('permission:master-coa-update');;
      Route::delete('/coa/destroy/{id}', 'destroy')->name('mdu-coa.destroy')->middleware('permission:master-coa-destroy');;
});

//transaksi
Route::group(['middleware' => ['permission:saldo-awal-coa-unit-pertokoan-view|saldo-awal-persediaan-unit-pertokoan-view|saldo-awal-inventaris-unit-pertokoan-view']], function () {
      //unit toko-index
      Route::controller(SaldoAwalController::class)->group(function () {
            Route::get('/saldo-awal/coa/unit-pertokoan', 'index')->name('sltk-coa');
            Route::get('/saldo-awal/persediaan/unit-pertokoan', 'index')->name('sltk-persediaan');
            Route::get('/saldo-awal/inventaris/unit-pertokoan', 'index')->name('sltk-inventaris');
      });
});

Route::group(['middleware' => ['permission:saldo-awal-coa-unit-pertokoan-transaction|saldo-awal-persediaan-unit-pertokoan-transaction|saldo-awal-inventaris-unit-pertokoan-transaction']], function () {
      Route::controller(SaldoAwalController::class)->group(function () {
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
      });
});

Route::group(['middleware' => ['permission:saldo-awal-coa-unit-sp-view|saldo-awal-inventaris-unit-sp-view']], function () {
      //unit sp
      Route::controller(SaldoAwalController::class)->group(function () {
            Route::get('/saldo-awal/coa/unit-sp', 'index')->name('slsp-coa');
            Route::get('/saldo-awal/inventaris/unit-sp', 'index')->name('slsp-inventaris');
      });
});

Route::group(['middleware' => ['permission:saldo-awal-coa-unit-sp-transaction|saldo-awal-inventaris-unit-sp-transaction']], function () {
      Route::controller(SaldoAwalController::class)->group(function () {
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
});

//unit toko
Route::group(['middleware' => ['permission:kas-bank-unit-pertokoan']], function () {
      Route::controller(TransferSaldoController::class)->group(function () {
            Route::get('/transfer-saldo-kas-bank/unit-pertokoan', 'index')->name('transfer-toko');
            Route::get('/transfer-saldo-kas-bank/unit-pertokoan/show/{id}', 'show')->name('transfer-toko.show');
            Route::get('/transfer-saldo-kas-bank/unit-pertokoan/list', 'dataTable')->name('transfer-toko.list');
      });
});

Route::group(['middleware' => ['permission:kas-bank-unit-pertokoan-transaction']], function () {
      Route::controller(TransferSaldoController::class)->group(function () {
            Route::get('/transfer-saldo-kas-bank/unit-pertokoan/create', 'create')->name('transfer-toko.create');
            Route::post('/transfer-saldo-kas-bank/unit-pertokoan/store', 'store')->name('transfer-toko.store');
            Route::get('/transfer-saldo-kas-bank/unit-pertokoan/detail', 'detail')->name('transfer-toko.detail');
      });
});

//unit sp
Route::group(['middleware' => ['permission:kas-bank-unit-sp']], function () {
      Route::controller(TransferSaldoController::class)->group(function () {
            Route::get('/transfer-saldo-kas-bank/unit-sp', 'index')->name('transfer-sp');
            Route::get('/transfer-saldo-kas-bank/unit-sp/list', 'dataTable')->name('transfer-sp.list');
            Route::get('/transfer-saldo-kas-bank/unit-sp/show/{id}', 'show')->name('transfer-sp.show');
      });
});

Route::group(['middleware' => ['permission:kas-bank-unit-sp-transaction']], function () {
      Route::controller(TransferSaldoController::class)->group(function () {
            Route::get('/transfer-saldo-kas-bank/unit-sp/create', 'create')->name('transfer-sp.create');
            Route::post('/transfer-saldo-kas-bank/unit-sp/store', 'store')->name('transfer-sp.store');
            Route::get('/transfer-saldo-kas-bank/unit-sp/detail', 'detail')->name('transfer-sp.detail');
      });
});
