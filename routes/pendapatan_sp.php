<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PendapatanController;

Route::group(['middleware' => ['permission:pendapatan-unit-sp']], function () {
      Route::controller(PendapatanController::class)->group(function () {
            Route::get('/pendapatan/unit-sp', 'index')->name('pendapatan-unit-sp');
            Route::get('/pendapatan/unit-sp/list', 'dataTable')->name('pendapatan-unit-sp.list');
      });
});

Route::group(['middleware' => ['permission:pendapatan-unit-sp-transaction']], function () {
      Route::controller(PendapatanController::class)->group(function () {
            Route::get('/pendapatan/unit-sp/create', 'create')->name('pendapatan-unit-sp.create');
            Route::post('/pendapatan/unit-sp/store', 'store')->name('pendapatan-unit-sp.store');
            Route::get('/pendapatan/unit-sp/detail', 'detail')->name('pendapatan-unit-sp.detail');
      });
});
