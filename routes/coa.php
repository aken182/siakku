<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\CoaController;
use App\Http\Controllers\transaksi\SaldoAwalController;
use App\Http\Controllers\transaksi\TransferSaldoController;

Route::controller(CoaController::class)->group(function () {
      Route::get('/coa', 'index')->name('coa-master');
      Route::get('/coa/create', 'create')->name('coa-master.create');
      Route::post('/coa/store', 'store')->name('coa-master.store');
      Route::get('/coa/edit/{id}', 'edit')->name('coa-master.edit');
      Route::patch('/coa/update/{id}', 'update')->name('coa-master.update');
      Route::delete('/coa/destroy/{id}', 'destroy')->name('coa-master.destroy');
});
Route::get('/saldo-awal', [SaldoAwalController::class, 'index'])->name('coa-saldo-awal');
Route::get('/kas-bank', [TransferSaldoController::class, 'index'])->name('coa-kas-bank');
