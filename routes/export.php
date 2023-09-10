<?php

use App\Http\Controllers\laporan\ExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laporan\ImportController;

Route::controller(ImportController::class)->group(function () {
      //template import
      //master umum
      Route::get('/anggota/import-template', 'template')->name('mdu-anggota.import-template');
      Route::get('/unit/import-template', 'template')->name('mdu-unit.import-template');
      Route::get('/satuan/import-template', 'template')->name('mdu-satuan.import-template');
      Route::get('/berita/import-template', 'template')->name('mdu-berita.import-template');
      Route::get('/coa/import-template', 'template')->name('mdu-coa.import-template');

      //master pertokoan
      Route::get('/persediaan/unit-pertokoan/import-template', 'template')->name('mdt-persediaan.import-template');
      Route::get('/inventaris/unit-pertokoan/import-template', 'template')->name('mdt-inventaris.import-template');
      Route::get('/vendor/unit-pertokoan/import-template', 'template')->name('mdt-vendor.import-template');
      //master sp
      Route::get('/inventaris/unit-sp/import-template', 'template')->name('mds-inventaris.import-template');
      Route::get('/vendor/unit-sp/import-template', 'template')->name('mds-vendor.import-template');
      Route::get('/master-simpanan/import-template', 'template')->name('mds-simpanan.import-template');
      Route::get('/pinjaman/unit-sp/pengajuan-import-template', 'template')->name('pp-pengajuan.import-template');
      //shu
      Route::get('/shu/unit-pertokoan/import-template', 'template')->name('shu-unit-pertokoan.import-template');
      Route::get('/shu/unit-sp/import-template', 'template')->name('shu-unit-sp.import-template');
      //saldo-awal
      Route::get('/saldo-awal/coa/unit-pertokoan/import-template', 'template')->name('sltk-coa.import-template');
      Route::get('/saldo-awal/persediaan/unit-pertokoan/import-template', 'template')->name('sltk-persediaan.import-template');
      Route::get('/saldo-awal/inventaris/unit-pertokoan/import-template', 'template')->name('sltk-inventaris.import-template');
      Route::get('/saldo-awal/coa/unit-sp/import-template', 'template')->name('slsp-coa.import-template');
      Route::get('/saldo-awal/inventaris/unit-sp/import-template', 'template')->name('slsp-inventaris.import-template');
});

Route::controller(ExportController::class)->group(function () {
      //excel
      //master umum
      Route::get('/anggota/export-excel', 'excel')->name('mdu-anggota.export-excel');
      Route::get('/jabatan/export-excel', 'excel')->name('mdu-jabatan.export-excel');
      Route::get('/unit/export-excel', 'excel')->name('mdu-unit.export-excel');
      Route::get('/satuan/export-excel', 'excel')->name('mdu-satuan.export-excel');
      Route::get('/berita/export-excel', 'excel')->name('mdu-berita.export-excel');
      Route::get('/coa/export-excel', 'excel')->name('mdu-coa.export-excel');
      //master pertokoan
      Route::get('/persediaan/unit-pertokoan/export-excel', 'excel')->name('mdt-persediaan.export-excel');
      Route::get('/inventaris/unit-pertokoan/export-excel', 'excel')->name('mdt-inventaris.export-excel');
      Route::get('/persediaan-eceran/unit-pertokoan/export-excel', 'excel')->name('mdt-persediaan-eceran.export-excel');
      Route::get('/inventaris-eceran/unit-pertokoan/export-excel', 'excel')->name('mdt-inventaris-eceran.export-excel');
      Route::get('/vendor/unit-pertokoan/export-excel', 'excel')->name('mdt-vendor.export-excel');
      //master sp
      Route::get('/inventaris/unit-sp/export-excel', 'excel')->name('mds-inventaris.export-excel');
      Route::get('/inventaris-eceran/unit-sp/export-excel', 'excel')->name('mds-inventaris-eceran.export-excel');
      Route::get('/vendor/unit-sp/export-excel', 'excel')->name('mds-vendor.export-excel');
      Route::get('/master-simpanan/export-excel', 'excel')->name('mds-simpanan.export-excel');
      Route::get('/pinjaman/unit-sp/pengajuan-export-excel', 'excel')->name('pp-pengajuan.export-excel');
      //shu
      Route::get('/shu/unit-pertokoan/export-excel', 'excel')->name('shu-unit-pertokoan.export-excel');
      Route::get('/shu/unit-sp/export-excel', 'excel')->name('shu-unit-sp.export-excel');

      //pdf
      //master umum
      Route::get('/anggota/export-pdf', 'pdf')->name('mdu-anggota.export-pdf');
      Route::get('/unit/export-pdf', 'pdf')->name('mdu-unit.export-pdf');
      Route::get('/jabatan/export-pdf', 'pdf')->name('mdu-jabatan.export-pdf');
      Route::get('/satuan/export-pdf', 'pdf')->name('mdu-satuan.export-pdf');
      Route::get('/berita/export-pdf', 'pdf')->name('mdu-berita.export-pdf');
      Route::get('/coa/export-pdf', 'pdf')->name('mdu-coa.export-pdf');
      //master pertokoan
      Route::get('/persediaan/unit-pertokoan/export-pdf', 'pdf')->name('mdt-persediaan.export-pdf');
      Route::get('/inventaris/unit-pertokoan/export-pdf', 'pdf')->name('mdt-inventaris.export-pdf');
      Route::get('/persediaan-eceran/unit-pertokoan/export-pdf', 'pdf')->name('mdt-persediaan-eceran.export-pdf');
      Route::get('/inventaris-eceran/unit-pertokoan/export-pdf', 'pdf')->name('mdt-inventaris-eceran.export-pdf');
      Route::get('/vendor/unit-pertokoan/export-pdf', 'pdf')->name('mdt-vendor.export-pdf');
      //master sp
      Route::get('/inventaris/unit-sp/export-pdf', 'pdf')->name('mds-inventaris.export-pdf');
      Route::get('/inventaris-eceran/unit-sp/export-pdf', 'pdf')->name('mds-inventaris-eceran.export-pdf');
      Route::get('/vendor/unit-sp/export-pdf', 'pdf')->name('mds-vendor.export-pdf');
      Route::get('/master-simpanan/export-pdf', 'pdf')->name('mds-simpanan.export-pdf');
      Route::get('/pinjaman/unit-sp/pengajuan-export-pdf', 'pdf')->name('pp-pengajuan.export-pdf');
      //shu
      Route::get('/shu/unit-pertokoan/export-pdf', 'pdf')->name('shu-unit-pertokoan.export-pdf');
      Route::get('/shu/unit-sp/export-pdf', 'pdf')->name('shu-unit-sp.export-pdf');
});
