<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\UnitController;
use App\Http\Controllers\master_data\BeritaController;
use App\Http\Controllers\master_data\SatuanController;
use App\Http\Controllers\master_data\AnggotaController;
use App\Http\Controllers\master_data\JabatanController;

Route::controller(AnggotaController::class)->group(function () {
      Route::get('/anggota', 'index')->name('mdu-anggota')->middleware('permission:master-anggota-view');
      Route::get('/anggota/create', 'create')->name('mdu-anggota.create')->middleware('permission:master-anggota-create');
      Route::post('/anggota/store', 'store')->name('mdu-anggota.store')->middleware('permission:master-anggota-store');
      Route::get('/anggota/edit/{id}', 'edit')->name('mdu-anggota.edit')->middleware('permission:master-anggota-edit');
      Route::patch('/anggota/update/{id}', 'update')->name('mdu-anggota.update')->middleware('permission:master-anggota-update');
      Route::delete('/anggota/destroy/{id}', 'destroy')->name('mdu-anggota.destroy')->middleware('permission:master-anggota-destroy');
});

Route::controller(JabatanController::class)->group(function () {
      Route::get('/jabatan', 'index')->name('mdu-jabatan')->middleware('permission:master-jabatan-view');
      Route::get('/jabatan/create', 'create')->name('mdu-jabatan.create')->middleware('permission:master-jabatan-create');
      Route::post('/jabatan/store', 'store')->name('mdu-jabatan.store')->middleware('permission:master-jabatan-store');
      Route::get('/jabatan/edit/{id}', 'edit')->name('mdu-jabatan.edit')->middleware('permission:master-jabatan-edit');
      Route::patch('/jabatan/update/{id}', 'update')->name('mdu-jabatan.update')->middleware('permission:master-jabatan-update');
      Route::delete('/jabatan/destroy/{id}', 'destroy')->name('mdu-jabatan.destroy')->middleware('permission:master-jabatan-destroy');
});

Route::controller(UnitController::class)->group(function () {
      Route::get('/unit', 'index')->name('mdu-unit')->middleware('permission:master-unit-view');
      Route::get('/unit/create', 'create')->name('mdu-unit.create')->middleware('permission:master-unit-create');
      Route::post('/unit/store', 'store')->name('mdu-unit.store')->middleware('permission:master-unit-store');
      Route::get('/unit/edit/{id}', 'edit')->name('mdu-unit.edit')->middleware('permission:master-unit-edit');
      Route::patch('/unit/update/{id}', 'update')->name('mdu-unit.update')->middleware('permission:master-unit-update');
      Route::delete('/unit/destroy/{id}', 'destroy')->name('mdu-unit.destroy')->middleware('permission:master-unit-destroy');
});

Route::controller(SatuanController::class)->group(function () {
      Route::get('/satuan', 'index')->name('mdu-satuan')->middleware('permission:master-satuan-view');
      Route::get('/satuan/create', 'create')->name('mdu-satuan.create')->middleware('permission:master-satuan-create');
      Route::post('/satuan/store', 'store')->name('mdu-satuan.store')->middleware('permission:master-satuan-store');
      Route::get('/satuan/edit/{id}', 'edit')->name('mdu-satuan.edit')->middleware('permission:master-satuan-edit');
      Route::patch('/satuan/update/{id}', 'update')->name('mdu-satuan.update')->middleware('permission:master-satuan-update');
      Route::delete('/satuan/destroy/{id}', 'destroy')->name('mdu-satuan.destroy')->middleware('permission:master-satuan-destroy');
});

Route::controller(BeritaController::class)->group(function () {
      Route::get('/berita', 'index')->name('mdu-berita')->middleware('permission:master-berita-view');
      Route::get('/berita/create', 'create')->name('mdu-berita.create')->middleware('permission:master-berita-create');
      Route::post('/berita/store', 'store')->name('mdu-berita.store')->middleware('permission:master-berita-store');
      Route::get('/berita/edit/{id}', 'edit')->name('mdu-berita.edit')->middleware('permission:master-berita-edit');
      Route::patch('/berita/update/{id}', 'update')->name('mdu-berita.update')->middleware('permission:master-berita-update');
      Route::delete('/berita/destroy/{id}', 'destroy')->name('mdu-berita.destroy')->middleware('permission:master-berita-destroy');
});
