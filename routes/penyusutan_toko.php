<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PenyusutanController;

Route::group(['middleware' => ['permission:penyusutan-unit-pertokoan']], function () {
      Route::controller(PenyusutanController::class)->group(function () {
            Route::get('/penyusutan/unit-pertokoan', 'index')->name('penyusutan-toko');
            Route::get('/penyusutan/unit-pertokoan/list', 'list')->name('penyusutan-toko.list');
            Route::get('/penyusutan/unit-pertokoan/show/{id}', 'show')->name('penyusutan-toko.show');
      });
});

Route::group(['middleware' => ['permission:penyusutan-unit-pertokoan-transaction']], function () {
      Route::controller(PenyusutanController::class)->group(function () {
            Route::get('/penyusutan/unit-pertokoan/step-satu', 'stepSatu')->name('penyusutan-toko.step-satu');
            Route::post('/penyusutan/unit-pertokoan/store-satu', 'storeSatu')->name('penyusutan-toko.store-satu');
            Route::get('/penyusutan/unit-pertokoan/step-dua', 'stepDua')->name('penyusutan-toko.step-dua');
            Route::post('/penyusutan/unit-pertokoan/store-dua', 'storeDua')->name('penyusutan-toko.store-dua');
            Route::get('/penyusutan/unit-pertokoan/step-tiga', 'stepTiga')->name('penyusutan-toko.step-tiga');
            Route::post('/penyusutan/unit-pertokoan/store-tiga', 'storeTiga')->name('penyusutan-toko.store-tiga');
            Route::post('/penyusutan/unit-pertokoan/store-empat', 'storeEmpat')->name('penyusutan-toko.store-empat');
            Route::get('/penyusutan/unit-pertokoan/detail-penyesuaian', 'getDetailPenyesuaian')->name('penyusutan-toko.detail');
      });
});
