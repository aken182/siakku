<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\CoaController;
use App\Http\Controllers\transaksi\SaldoAwalController;
use App\Http\Controllers\transaksi\TransferSaldoController;

Route::get('/coa', [CoaController::class, 'index'])->name('coa-master');
Route::get('/saldo-awal', [SaldoAwalController::class, 'index'])->name('coa-saldo-awal');
Route::get('/kas-bank', [TransferSaldoController::class, 'index'])->name('coa-kas-bank');
