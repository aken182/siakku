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
      //unit toko
      Route::get('/saldo-awal/coa/unit-pertokoan', 'index')->name('sltk-coa');
      Route::get('/saldo-awal/persediaan/unit-pertokoan', 'index')->name('sltk-persediaan');
      Route::get('/saldo-awal/inventaris/unit-pertokoan', 'index')->name('sltk-inventaris');
      //unit sp
      Route::get('/saldo-awal/coa/unit-sp', 'index')->name('slsp-coa');
      Route::get('/saldo-awal/persediaan/unit-sp', 'index')->name('slsp-persediaan');
      Route::get('/saldo-awal/inventaris/unit-sp', 'index')->name('slsp-inventaris');
});

Route::controller(TransferSaldoController::class)->group(function () {
      //unit toko
      Route::get('/transfer-saldo-kas-bank/unit-pertokoan', 'index')->name('transfer-toko');
      //unit sp
      Route::get('/transfer-saldo-kas-bank/unit-sp', 'index')->name('transfer-sp');
});
