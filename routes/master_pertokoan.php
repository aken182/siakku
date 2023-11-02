<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\BarangController;
use App\Http\Controllers\master_data\PenyediaController;
use App\Http\Controllers\master_data\BarangEceranController;

Route::group(['middleware' => ['permission:master-persediaan-toko']], function () {
      Route::controller(BarangController::class)->group(function () {
            Route::get('/persediaan/unit-pertokoan', 'index')->name('mdt-persediaan');
            Route::get('/persediaan/unit-pertokoan/list', 'dataTableBarang')->name('mdt-persediaan.list');
            Route::get('/persediaan/unit-pertokoan/create', 'create')->name('mdt-persediaan.create');
            Route::post('/persediaan/unit-pertokoan/store', 'store')->name('mdt-persediaan.store');
            Route::get('/persediaan/unit-pertokoan/edit/{id}', 'edit')->name('mdt-persediaan.edit');
            Route::patch('/persediaan/unit-pertokoan/update/{id}', 'update')->name('mdt-persediaan.update');
            Route::delete('/persediaan/unit-pertokoan/destroy/{id}', 'destroy')->name('mdt-persediaan.destroy');
      });
});

Route::group(['middleware' => ['permission:master-inventaris-toko']], function () {
      Route::controller(BarangController::class)->group(function () {
            Route::get('/inventaris/unit-pertokoan', 'index')->name('mdt-inventaris');
            Route::get('/inventaris/unit-pertokoan/list', 'dataTableBarang')->name('mdt-inventaris.list');
            Route::get('/inventaris/unit-pertokoan/create', 'create')->name('mdt-inventaris.create');
            Route::post('/inventaris/unit-pertokoan/store', 'store')->name('mdt-inventaris.store');
            Route::get('/inventaris/unit-pertokoan/edit/{id}', 'edit')->name('mdt-inventaris.edit');
            Route::patch('/inventaris/unit-pertokoan/update/{id}', 'update')->name('mdt-inventaris.update');
            Route::delete('/inventaris/unit-pertokoan/destroy/{id}', 'destroy')->name('mdt-inventaris.destroy');
      });
});

Route::group(['middleware' => ['permission:master-persediaan-eceran-toko']], function () {
      Route::controller(BarangEceranController::class)->group(function () {
            Route::get('/persediaan-eceran/unit-pertokoan', 'index')->name('mdt-persediaan-eceran');
            Route::get('/persediaan-eceran/unit-pertokoan/create', 'create')->name('mdt-persediaan-eceran.create');
            Route::post('/persediaan-eceran/unit-pertokoan/store', 'store')->name('mdt-persediaan-eceran.store');
            Route::get('/persediaan-eceran/unit-pertokoan/edit/{id}', 'edit')->name('mdt-persediaan-eceran.edit');
            Route::patch('/persediaan-eceran/unit-pertokoan/update/{id}', 'update')->name('mdt-persediaan-eceran.update');
            Route::delete('/persediaan-eceran/unit-pertokoan/destroy/{id}', 'destroy')->name('mdt-persediaan-eceran.destroy');
      });
});

Route::group(['middleware' => ['permission:master-inventaris-eceran-toko']], function () {
      Route::controller(BarangEceranController::class)->group(function () {
            Route::get('/inventaris-eceran/unit-pertokoan', 'index')->name('mdt-inventaris-eceran');
            Route::get('/inventaris-eceran/unit-pertokoan/create', 'create')->name('mdt-inventaris-eceran.create');
            Route::post('/inventaris-eceran/unit-pertokoan/store', 'store')->name('mdt-inventaris-eceran.store');
            Route::get('/inventaris-eceran/unit-pertokoan/edit/{id}', 'edit')->name('mdt-inventaris-eceran.edit');
            Route::patch('/inventaris-eceran/unit-pertokoan/update/{id}', 'update')->name('mdt-inventaris-eceran.update');
            Route::delete('/inventaris-eceran/unit-pertokoan/destroy/{id}', 'destroy')->name('mdt-inventaris-eceran.destroy');
      });
});

Route::group(['middleware' => ['permission:master-vendor-toko']], function () {
      Route::controller(PenyediaController::class)->group(function () {
            Route::get('/vendor/unit-pertokoan', 'index')->name('mdt-vendor');
            Route::get('/vendor/unit-pertokoan/create', 'create')->name('mdt-vendor.create');
            Route::post('/vendor/unit-pertokoan/store', 'store')->name('mdt-vendor.store');
            Route::get('/vendor/unit-pertokoan/edit/{id}', 'edit')->name('mdt-vendor.edit');
            Route::patch('/vendor/unit-pertokoan/update/{id}', 'update')->name('mdt-vendor.update');
            Route::delete('/vendor/unit-pertokoan/destroy/{id}', 'destroy')->name('mdt-vendor.destroy');
      });
});
