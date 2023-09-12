<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\BarangController;
use App\Http\Controllers\master_data\PenyediaController;
use App\Http\Controllers\master_data\BarangEceranController;
use App\Http\Controllers\master_data\MasterSimpananController;
use App\Http\Controllers\master_data\PengajuanPinjamanController;

Route::controller(BarangController::class)->group(function () {
      Route::get('/inventaris/unit-sp', 'index')->name('mds-inventaris');
      Route::get('/inventaris/unit-sp/list', 'dataTableBarang')->name('mds-inventaris.list');
      Route::get('/inventaris/unit-sp/create', 'create')->name('mds-inventaris.create');
      Route::post('/inventaris/unit-sp/store', 'store')->name('mds-inventaris.store');
      Route::get('/inventaris/unit-sp/edit/{id}', 'edit')->name('mds-inventaris.edit');
      Route::patch('/inventaris/unit-sp/update/{id}', 'update')->name('mds-inventaris.update');
      Route::delete('/inventaris/unit-sp/destroy/{id}', 'destroy')->name('mds-inventaris.destroy');
});

Route::controller(BarangEceranController::class)->group(function () {
      Route::get('/inventaris-eceran/unit-sp', 'index')->name('mds-inventaris-eceran');
      Route::get('/inventaris-eceran/unit-sp/create', 'create')->name('mds-inventaris-eceran.create');
      Route::post('/inventaris-eceran/unit-sp/store', 'store')->name('mds-inventaris-eceran.store');
      Route::get('/inventaris-eceran/unit-sp/edit/{id}', 'edit')->name('mds-inventaris-eceran.edit');
      Route::patch('/inventaris-eceran/unit-sp/update/{id}', 'update')->name('mds-inventaris-eceran.update');
      Route::delete('/inventaris-eceran/unit-sp/destroy/{id}', 'destroy')->name('mds-inventaris-eceran.destroy');
});

Route::controller(PenyediaController::class)->group(function () {
      Route::get('/vendor/unit-sp', 'index')->name('mds-vendor');
      Route::get('/vendor/unit-sp/create', 'create')->name('mds-vendor.create');
      Route::post('/vendor/unit-sp/store', 'store')->name('mds-vendor.store');
      Route::get('/vendor/unit-sp/edit/{id}', 'edit')->name('mds-vendor.edit');
      Route::patch('/vendor/unit-sp/update/{id}', 'update')->name('mds-vendor.update');
      Route::delete('/vendor/unit-sp/destroy/{id}', 'destroy')->name('mds-vendor.destroy');
});

Route::controller(MasterSimpananController::class)->group(function () {
      Route::get('/master-simpanan', 'index')->name('mds-simpanan');
      Route::get('/master-simpanan/create', 'create')->name('mds-simpanan.create');
      Route::post('/master-simpanan/store', 'store')->name('mds-simpanan.store');
      Route::get('/master-simpanan/edit/{id}', 'edit')->name('mds-simpanan.edit');
      Route::patch('/master-simpanan/update/{id}', 'update')->name('mds-simpanan.update');
      Route::delete('/master-simpanan/destroy/{id}', 'destroy')->name('mds-simpanan.destroy');
});

Route::controller(PengajuanPinjamanController::class)->group(function () {
      Route::get('/pinjaman/unit-sp/pengajuan-history', 'index')->name('pp-pengajuan');
      Route::get('/pinjaman/unit-sp/pengajuan-create', 'create')->name('pp-pengajuan.create');
      Route::post('/pinjaman/unit-sp/pengajuan-store', 'store')->name('pp-pengajuan.store');
      Route::get('/pinjaman/unit-sp/pengajuan-edit/{id}', 'edit')->name('pp-pengajuan.edit');
      Route::get('/pinjaman/unit-sp/pengajuan-show/{id}', 'show')->name('pp-pengajuan.show');
      Route::patch('/pinjaman/unit-sp/pengajuan-konfirmasi/{id}', 'konfirmasi')->name('pp-pengajuan.konfirmasi');
      Route::patch('/pinjaman/unit-sp/pengajuan-update/{id}', 'update')->name('pp-pengajuan.update');
      Route::delete('/pinjaman/unit-sp/pengajuan-destroy/{id}', 'destroy')->name('pp-pengajuan.destroy');
});
