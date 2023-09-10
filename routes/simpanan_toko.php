<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\transaksi\PenarikanController;


Route::get('/simpanan/unit-pertokoan/setor-history', [SimpananController::class, 'index'])->name('stk-simpanan');
Route::get('/simpanan/unit-pertokoan/tarik-history', [PenarikanController::class, 'index'])->name('stk-penarikan');
