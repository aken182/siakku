<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\transaksi\PenyusutanController;

Route::group(['middleware' => ['permission:penyusutan-unit-sp']], function () {
      Route::controller(PenyusutanController::class)->group(function () {
            Route::get('/penyusutan/unit-sp', 'index')->name('penyusutan-sp');
            Route::get('/penyusutan/unit-sp/list', 'list')->name('penyusutan-sp.list');
            Route::get('/penyusutan/unit-sp/show/{id}', 'show')->name('penyusutan-sp.show');
      });
});

Route::group(['middleware' => ['permission:penyusutan-unit-sp-transaction']], function () {
      Route::controller(PenyusutanController::class)->group(function () {
            Route::get('/penyusutan/unit-sp/step-satu', 'stepSatu')->name('penyusutan-sp.step-satu');
            Route::post('/penyusutan/unit-sp/store-satu', 'storeSatu')->name('penyusutan-sp.store-satu');
            Route::get('/penyusutan/unit-sp/step-dua', 'stepDua')->name('penyusutan-sp.step-dua');
            Route::post('/penyusutan/unit-sp/store-dua', 'storeDua')->name('penyusutan-sp.store-dua');
            Route::get('/penyusutan/unit-sp/step-tiga', 'stepTiga')->name('penyusutan-sp.step-tiga');
            Route::post('/penyusutan/unit-sp/store-tiga', 'storeTiga')->name('penyusutan-sp.store-tiga');
            Route::post('/penyusutan/unit-sp/store-empat', 'storeEmpat')->name('penyusutan-sp.store-empat');
            Route::get('/penyusutan/unit-sp/detail-penyesuaian', 'getDetailPenyesuaian')->name('penyusutan-sp.detail');
      });
});
