<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\MasterShuController;
use App\Http\Controllers\transaksi\TransaksiShuController;

Route::group(['middleware' => ['permission:shu-unit-pertokoan']], function () {
      // 1.Master
      Route::controller(MasterShuController::class)->group(function () {
            Route::get('/shu/unit-pertokoan', 'index')->name('shu-unit-pertokoan');
      });
      //2. Transaksi
      Route::controller(TransaksiShuController::class)->group(function () {
            Route::get('/shu/unit-pertokoan/transaksi', 'index')->name('shu-unit-pertokoan.transaksi');
            Route::get('/shu/unit-pertokoan/transaksi/list', 'list')->name('shu-unit-pertokoan.transaksi-list');
      });
});

Route::group(['middleware' => ['permission:shu-unit-pertokoan-transaction']], function () {
      Route::controller(MasterShuController::class)->group(function () {
            Route::get('/shu/unit-pertokoan/create', 'create')->name('shu-unit-pertokoan.create');
            Route::post('/shu/unit-pertokoan/store', 'store')->name('shu-unit-pertokoan.store');
            Route::get('/shu/unit-pertokoan/edit/{id}', 'edit')->name('shu-unit-pertokoan.edit');
            Route::patch('/shu/unit-pertokoan/update/{id}', 'update')->name('shu-unit-pertokoan.update');
            Route::delete('/shu/unit-pertokoan/destroy/{id}', 'destroy')->name('shu-unit-pertokoan.destroy');
      });
      Route::controller(TransaksiShuController::class)->group(function () {
            Route::get('/shu/unit-pertokoan/transaksi/create', 'create')->name('shu-unit-pertokoan.transaksi-create');
            Route::get('/shu/unit-pertokoan/transaksi/chart', 'chart')->name('shu-unit-pertokoan.transaksi-chart');
            Route::get('/shu/unit-pertokoan/transaksi/jurnal', 'getJurnalTransaksi')->name('shu-unit-pertokoan.transaksi-jurnal');
            Route::post('/shu/unit-pertokoan/transaksi/store', 'store')->name('shu-unit-pertokoan.transaksi-store');
            Route::get('/shu/unit-pertokoan/transaksi/detail-penyesuaian', 'detail')->name('shu-unit-pertokoan.transaksi-detail');
      });
});

Route::group(['middleware' => ['permission:shu-unit-sp']], function () {
      Route::controller(MasterShuController::class)->group(function () {
            Route::get('/shu/unit-sp', 'index')->name('shu-unit-sp');
      });

      Route::controller(TransaksiShuController::class)->group(function () {
            Route::get('/shu/unit-sp/transaksi', 'index')->name('shu-unit-sp.transaksi');
            Route::get('/shu/unit-sp/transaksi/list', 'list')->name('shu-unit-sp.transaksi-list');
      });
});

Route::group(['middleware' => ['permission:shu-unit-sp-transaction']], function () {
      Route::controller(MasterShuController::class)->group(function () {
            Route::get('/shu/unit-sp/create', 'create')->name('shu-unit-sp.create');
            Route::post('/shu/unit-sp/store', 'store')->name('shu-unit-sp.store');
            Route::get('/shu/unit-sp/edit/{id}', 'edit')->name('shu-unit-sp.edit');
            Route::patch('/shu/unit-sp/update/{id}', 'update')->name('shu-unit-sp.update');
            Route::delete('/shu/unit-sp/destroy/{id}', 'destroy')->name('shu-unit-sp.destroy');
      });

      Route::controller(TransaksiShuController::class)->group(function () {
            Route::get('/shu/unit-sp/transaksi/create', 'create')->name('shu-unit-sp.transaksi-create');
            Route::get('/shu/unit-sp/transaksi/chart', 'chart')->name('shu-unit-sp.transaksi-chart');
            Route::get('/shu/unit-sp/transaksi/jurnal', 'getJurnalTransaksi')->name('shu-unit-sp.transaksi-jurnal');
            Route::post('/shu/unit-sp/transaksi/store', 'store')->name('shu-unit-sp.transaksi-store');
            Route::get('/shu/unit-sp/transaksi/detail-penyesuaian', 'detail')->name('shu-unit-sp.transaksi-detail');
      });
});
