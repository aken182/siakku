<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\transaksi\PenarikanController;

Route::get('/simpanan/unit-sp/setor-history', [SimpananController::class, 'index'])->name('sp-simpanan');
Route::get('/simpanan/unit-sp/tarik-history', [PenarikanController::class, 'index'])->name('sp-penarikan');
