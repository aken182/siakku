<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\master_data\UnitController;
use App\Http\Controllers\master_data\BeritaController;
use App\Http\Controllers\master_data\SatuanController;
use App\Http\Controllers\master_data\AnggotaController;
use App\Http\Controllers\master_data\JabatanController;

Route::controller(AnggotaController::class)->group(function () {
      Route::get('/anggota', 'index')->name('mdu-anggota');
      Route::get('/anggota/create', 'create')->name('mdu-anggota.create');
      Route::post('/anggota/store', 'store')->name('mdu-anggota.store');
      Route::get('/anggota/edit/{id}', 'edit')->name('mdu-anggota.edit');
      Route::patch('/anggota/update/{id}', 'update')->name('mdu-anggota.update');
      Route::delete('/anggota/destroy/{id}', 'destroy')->name('mdu-anggota.destroy');
});

Route::controller(JabatanController::class)->group(function () {
      Route::get('/jabatan', 'index')->name('mdu-jabatan');
      Route::get('/jabatan/create', 'create')->name('mdu-jabatan.create');
      Route::post('/jabatan/store', 'store')->name('mdu-jabatan.store');
      Route::get('/jabatan/edit/{id}', 'edit')->name('mdu-jabatan.edit');
      Route::patch('/jabatan/update/{id}', 'update')->name('mdu-jabatan.update');
      Route::delete('/jabatan/destroy/{id}', 'destroy')->name('mdu-jabatan.destroy');
});

Route::controller(UnitController::class)->group(function () {
      Route::get('/unit', 'index')->name('mdu-unit');
      Route::get('/unit/create', 'create')->name('mdu-unit.create');
      Route::post('/unit/store', 'store')->name('mdu-unit.store');
      Route::get('/unit/edit/{id}', 'edit')->name('mdu-unit.edit');
      Route::patch('/unit/update/{id}', 'update')->name('mdu-unit.update');
      Route::delete('/unit/destroy/{id}', 'destroy')->name('mdu-unit.destroy');
});

Route::controller(SatuanController::class)->group(function () {
      Route::get('/satuan', 'index')->name('mdu-satuan');
      Route::get('/satuan/create', 'create')->name('mdu-satuan.create');
      Route::post('/satuan/store', 'store')->name('mdu-satuan.store');
      Route::get('/satuan/edit/{id}', 'edit')->name('mdu-satuan.edit');
      Route::patch('/satuan/update/{id}', 'update')->name('mdu-satuan.update');
      Route::delete('/satuan/destroy/{id}', 'destroy')->name('mdu-satuan.destroy');
});

Route::controller(BeritaController::class)->group(function () {
      Route::get('/berita', 'index')->name('mdu-berita');
      Route::get('/berita/create', 'create')->name('mdu-berita.create');
      Route::post('/berita/store', 'store')->name('mdu-berita.store');
      Route::get('/berita/edit/{id}', 'edit')->name('mdu-berita.edit');
      Route::patch('/berita/update/{id}', 'update')->name('mdu-berita.update');
      Route::delete('/berita/destroy/{id}', 'destroy')->name('mdu-berita.destroy');
});
