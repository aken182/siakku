<?php

use App\Http\Controllers\laporan\ImportController;
use Illuminate\Support\Facades\Route;

Route::controller(ImportController::class)->group(function () {
      //form
      //master umum
      Route::get('/anggota/import', 'index')->name('mdu-anggota.form-import');
      Route::get('/unit/import', 'index')->name('mdu-unit.form-import');
      Route::get('/satuan/import', 'index')->name('mdu-satuan.form-import');
      Route::get('/berita/import', 'index')->name('mdu-berita.form-import');
      Route::get('/coa/import', 'index')->name('mdu-coa.form-import');

      //master pertokoan
      Route::get('/persediaan/unit-pertokoan/import', 'index')->name('mdt-persediaan.form-import');
      Route::get('/inventaris/unit-pertokoan/import', 'index')->name('mdt-inventaris.form-import');
      Route::get('/vendor/unit-pertokoan/import', 'index')->name('mdt-vendor.form-import');
      //master sp
      Route::get('/inventaris/unit-sp/import', 'index')->name('mds-inventaris.form-import');
      Route::get('/vendor/unit-sp/import', 'index')->name('mds-vendor.form-import');
      Route::get('/master-simpanan/import', 'index')->name('mds-simpanan.form-import');
      Route::get('/pinjaman/unit-sp/pengajuan-import', 'index')->name('pp-pengajuan.form-import');
      //shu
      Route::get('/shu/unit-pertokoan/import', 'index')->name('shu-unit-pertokoan.form-import');
      Route::get('/shu/unit-sp/import', 'index')->name('shu-unit-sp.form-import');

      //store
      //master umum
      Route::post('/anggota/import-store', 'import')->name('mdu-anggota.import');
      Route::post('/unit/import-store', 'import')->name('mdu-unit.import');
      Route::post('/satuan/import-store', 'import')->name('mdu-satuan.import');
      Route::post('/berita/import-store', 'import')->name('mdu-berita.import');
      Route::post('/coa/import-store', 'import')->name('mdu-coa.import');

      //master pertokoan
      Route::post('/persediaan/unit-pertokoan/import-store', 'import')->name('mdt-persediaan.import');
      Route::post('/inventaris/unit-pertokoan/import-store', 'import')->name('mdt-inventaris.import');
      Route::post('/vendor/unit-pertokoan/import-store', 'import')->name('mdt-vendor.import');
      //master sp
      Route::post('/inventaris/unit-sp/import-store', 'import')->name('mds-inventaris.import');
      Route::post('/vendor/unit-sp/import-store', 'import')->name('mds-vendor.import');
      Route::post('/master-simpanan/import-store', 'import')->name('mds-simpanan.import');
      Route::post('/pinjaman/unit-sp/pengajuan-import-store', 'import')->name('pp-pengajuan.import');
      //shu
      Route::post('/shu/unit-pertokoan/import-store', 'import')->name('shu-unit-pertokoan.import');
      Route::post('/shu/unit-sp/import-store', 'import')->name('shu-unit-sp.import');
});
