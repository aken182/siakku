<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\MasterShuController;
use App\Http\Controllers\transaksi\TransaksiShuController;

// 1.Master
Route::controller(MasterShuController::class)->group(function () {
      Route::get('/shu/unit-pertokoan', 'index')->name('shu-unit-pertokoan');
      Route::get('/shu/unit-pertokoan/create', 'create')->name('shu-unit-pertokoan.create');
      Route::post('/shu/unit-pertokoan/store', 'store')->name('shu-unit-pertokoan.store');
      Route::get('/shu/unit-pertokoan/edit/{id}', 'edit')->name('shu-unit-pertokoan.edit');
      Route::patch('/shu/unit-pertokoan/update/{id}', 'update')->name('shu-unit-pertokoan.update');
      Route::delete('/shu/unit-pertokoan/destroy/{id}', 'destroy')->name('shu-unit-pertokoan.destroy');

      Route::get('/shu/unit-sp', 'index')->name('shu-unit-sp');
      Route::get('/shu/unit-sp/create', 'create')->name('shu-unit-sp.create');
      Route::post('/shu/unit-sp/store', 'store')->name('shu-unit-sp.store');
      Route::get('/shu/unit-sp/edit/{id}', 'edit')->name('shu-unit-sp.edit');
      Route::patch('/shu/unit-sp/update/{id}', 'update')->name('shu-unit-sp.update');
      Route::delete('/shu/unit-sp/destroy/{id}', 'destroy')->name('shu-unit-sp.destroy');
});

//2. Transaksi
Route::controller(TransaksiShuController::class)->group(function () {
      Route::get('/shu/unit-pertokoan/transaksi', 'index')->name('shu-unit-pertokoan.transaksi');
      Route::get('/shu/unit-pertokoan/transaksi/create', 'create')->name('shu-unit-pertokoan.transaksi-create');
      Route::post('/shu/unit-pertokoan/transaksi/store', 'store')->name('shu-unit-pertokoan.transaksi-store');
      Route::get('/shu/unit-pertokoan/transaksi/show/{id}', 'show')->name('shu-unit-pertokoan.transaksi-show');

      Route::get('/shu/unit-sp/transaksi', 'index')->name('shu-unit-sp.transaksi');
      Route::get('/shu/unit-sp/transaksi/create', 'create')->name('shu-unit-sp.transaksi-create');
      Route::post('/shu/unit-sp/transaksi/store', 'store')->name('shu-unit-sp.transaksi-store');
      Route::get('/shu/unit-sp/transaksi/show/{id}', 'show')->name('shu-unit-sp.transaksi-show');
});