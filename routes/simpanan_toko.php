<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\transaksi\PenarikanController;

Route::group(['middleware' => ['permission:simpanan-unit-pertokoan-view']], function () {
      Route::controller(SimpananController::class)->group(function () {
            Route::get('/simpanan/unit-pertokoan/setor-history', 'index')->name('stk-simpanan');
            Route::get('/simpanan/unit-pertokoan/list', 'dataTable')->name('stk-simpanan.list');
      });
});

Route::group(['middleware' => ['permission:simpanan-unit-pertokoan-transaction']], function () {
      Route::controller(SimpananController::class)->group(function () {
            Route::get('/simpanan/unit-pertokoan/create', 'create')->name('stk-simpanan.create');
            Route::post('/simpanan/unit-pertokoan/store', 'store')->name('stk-simpanan.store');
            Route::get('/simpanan/unit-pertokoan/detail', 'detail')->name('stk-simpanan.detail');
      });
});

Route::group(['middleware' => ['permission:simpanan-unit-pertokoan-penarikan-view']], function () {
      Route::controller(PenarikanController::class)->group(function () {
            Route::get('/simpanan/unit-pertokoan/tarik-history', 'index')->name('stk-penarikan');
            Route::get('/simpanan/unit-pertokoan/list-tarik', 'dataTable')->name('stk-penarikan.list');
      });
});

Route::group(['middleware' => ['permission:simpanan-unit-pertokoan-penarikan-transaction']], function () {
      Route::controller(PenarikanController::class)->group(function () {
            Route::get('/simpanan/unit-pertokoan/create-tarik', 'create')->name('stk-penarikan.create');
            Route::post('/simpanan/unit-pertokoan/store-tarik', 'store')->name('stk-penarikan.store');
            Route::get('/simpanan/unit-pertokoan/detail-tarik', 'detail')->name('stk-penarikan.detail');
            Route::get('/simpanan/unit-pertokoan/get-saldo', 'getSaldo')->name('stk-penarikan.saldo');
      });
});
