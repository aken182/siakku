<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\transaksi\PenarikanController;

Route::group(['middleware' => ['permission:simpanan-unit-sp-view']], function () {
      Route::controller(SimpananController::class)->group(function () {
            Route::get('/simpanan/unit-sp/setor-history', 'index')->name('sp-simpanan');
            Route::get('/simpanan/unit-sp/list', 'dataTable')->name('sp-simpanan.list');
            Route::get('/simpanan/unit-sp/show/{id}', 'show')->name('sp-simpanan.show');
      });
});

Route::group(['middleware' => ['permission:simpanan-unit-sp-transaction']], function () {
      Route::controller(SimpananController::class)->group(function () {
            Route::get('/simpanan/unit-sp/create', 'create')->name('sp-simpanan.create');
            Route::post('/simpanan/unit-sp/store', 'store')->name('sp-simpanan.store');
            Route::get('/simpanan/unit-sp/detail', 'detail')->name('sp-simpanan.detail');
            Route::get('/simpanan/unit-sp/create-srb', 'create')->name('sp-simpanan.create-srb');
            Route::get('/simpanan/unit-sp/get-srb', 'getDataSrb')->name('sp-simpanan.get-srb');
      });
});

Route::group(['middleware' => ['permission:simpanan-unit-sp-penarikan-view']], function () {
      Route::controller(PenarikanController::class)->group(function () {
            Route::get('/simpanan/unit-sp/tarik-history', 'index')->name('sp-penarikan');
            Route::get('/simpanan/unit-sp/list-tarik', 'dataTable')->name('sp-penarikan.list');
            Route::get('/simpanan/unit-sp/show-tarik/{id}', 'show')->name('sp-penarikan.show');
      });
});

Route::group(['middleware' => ['permission:simpanan-unit-sp-penarikan-transaction']], function () {
      Route::controller(PenarikanController::class)->group(function () {
            Route::get('/simpanan/unit-sp/create-tarik', 'create')->name('sp-penarikan.create');
            Route::get('/simpanan/unit-sp/create-tarik-srb', 'create')->name('sp-penarikan.create-srb');
            Route::post('/simpanan/unit-sp/store-tarik', 'store')->name('sp-penarikan.store');
            Route::get('/simpanan/unit-sp/detail-tarik', 'detail')->name('sp-penarikan.detail');
            Route::get('/simpanan/unit-sp/get-saldo', 'getSaldo')->name('sp-penarikan.saldo');
            Route::get('/simpanan/unit-sp/get-saldo-sukarela-berbunga', 'getSaldoSrb')->name('sp-penarikan.saldo-srb');
      });
});
