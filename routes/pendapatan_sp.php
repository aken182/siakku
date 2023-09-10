<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PendapatanController;

Route::get('/pendapatan/unit-sp', [PendapatanController::class, 'index'])->name('pendapatan-unit-sp');
