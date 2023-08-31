<?php

namespace App\Services;

use App\Models\Coa;
use App\Models\Shu;
use App\Models\Unit;
use App\Models\Berita;
use App\Models\Satuan;
use App\Models\Anggota;
use App\Models\Penyedia;
use App\Models\Simpanan;
use App\Imports\CoaImport;
use App\Imports\ShuImport;
use App\Imports\UnitImport;
use App\Imports\BeritaImport;
use App\Imports\SatuanImport;
use App\Imports\VendorImport;
use App\Imports\AnggotaImport;
use App\Services\BarangService;
use App\Imports\PengajuanImport;
use App\Imports\InventarisImport;
use App\Imports\PersediaanImport;
use App\Models\Pengajuan_pinjaman;
use App\Imports\MasterSimpananImport;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class ImportExportService
{
      private $barangService;
      private $route;

      public function __construct()
      {
            $this->barangService = new BarangService;
            $this->route = Route::currentRouteName();
      }

      public function getDataIndex()
      {

            switch ($this->route) {
                  case 'mdu-anggota.form-import':
                  case 'mdu-anggota.import':
                        $title = 'Form Import Anggota';
                        $routeStore = 'mdu-anggota.import';
                        $routeTemplate = 'mdu-anggota.import-template';
                        $routeMain = 'mdu-anggota';
                        break;
                  case 'mdu-unit.form-import':
                  case 'mdu-unit.import':
                        $title = 'Form Import Unit';
                        $routeStore = 'mdu-unit.import';
                        $routeTemplate = 'mdu-unit.import-template';
                        $routeMain = 'mdu-unit';
                        break;
                  case 'mdu-satuan.form-import':
                  case 'mdu-satuan.import':
                        $title = 'Form Import Satuan';
                        $routeStore = 'mdu-satuan.import';
                        $routeTemplate = 'mdu-satuan.import-template';
                        $routeMain = 'mdu-satuan';
                        break;
                  case 'mdu-berita.form-import':
                  case 'mdu-berita.import':
                        $title = 'Form Import Berita';
                        $routeStore = 'mdu-berita.import';
                        $routeTemplate = 'mdu-berita.import-template';
                        $routeMain = 'mdu-berita';
                        break;
                  case 'mdt-persediaan.form-import':
                  case 'mdt-persediaan.import':
                        $title = 'Form Import Persediaan Pertokoan';
                        $routeStore = 'mdt-persediaan.import';
                        $routeTemplate = 'mdt-persediaan.import-template';
                        $routeMain = 'mdt-persediaan';
                        break;
                  case 'mdt-inventaris.form-import':
                  case 'mdt-inventaris.import':
                        $title = 'Form Import Inventaris Pertokoan';
                        $routeStore = 'mdt-inventaris.import';
                        $routeTemplate = 'mdt-inventaris.import-template';
                        $routeMain = 'mdt-inventaris';
                        break;
                  case 'mdt-vendor.form-import':
                  case 'mdt-vendor.import':
                        $title = 'Form Import Vendor Pertokoan';
                        $routeStore = 'mdt-vendor.import';
                        $routeTemplate = 'mdt-vendor.import-template';
                        $routeMain = 'mdt-vendor';
                        break;
                  case 'mds-inventaris.form-import':
                  case 'mds-inventaris.import':
                        $title = 'Form Import Inventaris Unit SP';
                        $routeStore = 'mds-inventaris.import';
                        $routeTemplate = 'mds-inventaris.import-template';
                        $routeMain = 'mds-inventaris';
                        break;
                  case 'mds-vendor.form-import':
                  case 'mds-vendor.import':
                        $title = 'Form Import Vendor Unit SP';
                        $routeStore = 'mds-vendor.import';
                        $routeTemplate = 'mds-vendor.import-template';
                        $routeMain = 'mds-vendor';
                        break;
                  case 'mds-simpanan.form-import':
                  case 'mds-simpanan.import':
                        $title = 'Form Import Simpanan Unit SP';
                        $routeStore = 'mds-simpanan.import';
                        $routeTemplate = 'mds-simpanan.import-template';
                        $routeMain = 'mds-simpanan';
                        break;
                  case 'pp-pengajuan.form-import':
                  case 'pp-pengajuan.import':
                        $title = 'Form Import Pengajuan Pinjaman';
                        $routeStore = 'pp-pengajuan.import';
                        $routeTemplate = 'pp-pengajuan.import-template';
                        $routeMain = 'pp-pengajuan';
                        break;
                  case 'mdu-coa.form-import':
                  case 'mdu-coa.import':
                        $title = 'Form Import Chart Of Account';
                        $routeStore = 'mdu-coa.import';
                        $routeTemplate = 'mdu-coa.import-template';
                        $routeMain = 'mdu-coa';
                        break;
                  case 'shu-unit-pertokoan.form-import':
                  case 'shu-unit-pertokoan.import':
                        $title = 'Form Import Master SHU Pertokoan';
                        $routeStore = 'shu-unit-pertokoan.import';
                        $routeTemplate = 'shu-unit-pertokoan.import-template';
                        $routeMain = 'shu-unit-pertokoan';
                        break;
                  case 'shu-unit-sp.form-import':
                  case 'shu-unit-sp.import':
                        $title = 'Form Import Master SHU Unit SP';
                        $routeStore = 'shu-unit-sp.import';
                        $routeTemplate = 'shu-unit-sp.import-template';
                        $routeMain = 'shu-unit-sp';
                        break;
            }
            return [
                  'title' => $title,
                  'routeStore' => $routeStore,
                  'routeMain' => $routeMain,
                  'routeTemplate' => $routeTemplate,
                  'routeNow' => $this->route
            ];
      }

      public function getDataExport($route)
      {
            switch ($route) {
                  case 'mdu-anggota.export-excel':
                  case 'mdu-anggota.export-pdf':
                  case 'mdu-anggota.import-template':
                        $dataTabel = Anggota::all();
                        $jenisTabel = 'anggota';
                        break;
                  case 'mdu-jabatan.export-pdf':
                  case 'mdu-jabatan.export-excel':
                  case 'mdu-jabatan.import-template':
                        $dataTabel = Jabatan::all();
                        $jenisTabel = 'jabatan';
                        break;
                  case 'mdu-unit.export-pdf':
                  case 'mdu-unit.export-excel':
                  case 'mdu-unit.import-template':
                        $dataTabel = Unit::all();
                        $jenisTabel = 'unit';
                        break;
                  case 'mdu-satuan.export-excel':
                  case 'mdu-satuan.export-pdf':
                  case 'mdu-satuan.import-template':
                        $dataTabel = Satuan::all();
                        $jenisTabel = 'satuan';
                        break;
                  case 'mdu-berita.export-excel':
                  case 'mdu-berita.export-pdf':
                  case 'mdu-berita.import-template':
                        $dataTabel = Berita::all();
                        $jenisTabel = 'berita';
                        break;
                  case 'mdt-persediaan.export-excel':
                  case 'mdt-persediaan.export-pdf':
                  case 'mdt-persediaan.import-template':
                        $dataTabel = $this->barangService->getDataBarang('Pertokoan', 'persediaan');
                        $jenisTabel = 'persediaan';
                        break;
                  case 'mdt-inventaris.export-excel':
                  case 'mdt-inventaris.export-pdf':
                  case 'mdt-inventaris.import-template':
                        $dataTabel = $this->barangService->getDataBarang('Pertokoan', 'inventaris');
                        $jenisTabel = 'inventaris';
                        break;
                  case 'mdt-persediaan-eceran.export-excel':
                  case 'mdt-persediaan-eceran.export-pdf':
                        $dataTabel = $this->barangService->getDataBarangEceran('Pertokoan', 'persediaan');
                        $jenisTabel = 'persediaan eceran';
                        break;
                  case 'mdt-inventaris-eceran.export-excel':
                  case 'mdt-inventaris-eceran.export-pdf':
                        $dataTabel = $this->barangService->getDataBarangEceran('Pertokoan', 'inventaris');
                        $jenisTabel = 'inventaris eceran';
                        break;
                  case 'mdt-vendor.export-excel':
                  case 'mdt-vendor.export-pdf':
                  case 'mds-vendor.export-excel':
                  case 'mds-vendor.export-pdf':
                  case 'mdt-vendor.import-template':
                  case 'mds-vendor.import-template':
                        $dataTabel = Penyedia::all();
                        $jenisTabel = 'vendor';
                        break;
                  case 'mds-inventaris.export-excel':
                  case 'mds-inventaris.export-pdf':
                  case 'mds-inventaris.import-template':
                        $dataTabel = $this->barangService->getDataBarang('Simpan Pinjam', 'inventaris');
                        $jenisTabel = 'inventaris';
                        break;
                  case 'mds-inventaris-eceran.export-excel':
                  case 'mds-inventaris-eceran.export-pdf':
                        $dataTabel = $this->barangService->getDataBarangEceran('Simpan Pinjam', 'inventaris');
                        $jenisTabel = 'inventaris eceran';
                        break;
                  case 'mds-simpanan.export-excel':
                  case 'mds-simpanan.export-pdf':
                  case 'mds-simpanan.import-template':
                        $dataTabel = Simpanan::all();
                        $jenisTabel = 'simpanan';
                        break;
                  case 'pp-pengajuan.export-excel':
                  case 'pp-pengajuan.export-pdf':
                  case 'pp-pengajuan.import-template':
                        $dataTabel = Pengajuan_pinjaman::all();
                        $jenisTabel = 'pengajuan';
                        break;
                  case 'mdu-coa.export-excel':
                  case 'mdu-coa.export-pdf':
                  case 'mdu-coa.import-template':
                        $dataTabel = Coa::all();
                        $jenisTabel = 'coa';
                        break;
                  case 'shu-unit-pertokoan.export-excel':
                  case 'shu-unit-pertokoan.export-pdf':
                  case 'shu-unit-pertokoan.import-template':
                        $dataTabel = Shu::where('unit', 'Pertokoan')->get();
                        $jenisTabel = 'shu';
                        break;
                  case 'shu-unit-sp.export-excel':
                  case 'shu-unit-sp.export-pdf':
                  case 'shu-unit-sp.import-template':
                        $dataTabel = Shu::where('unit', 'Simpan Pinjam')->get();
                        $jenisTabel = 'shu';
                        break;
            }

            return [
                  'dataTabel' => $dataTabel,
                  'jenisTabel' => $jenisTabel,
            ];
      }

      public function importData()
      {
            $import = [
                  'mdu-anggota.import' => new AnggotaImport,
                  'mdu-unit.import' => new UnitImport,
                  'mdu-satuan.import' => new SatuanImport,
                  'mdu-berita.import' => new BeritaImport,
                  'mdt-persediaan.import' => new PersediaanImport,
                  'mdt-vendor.import' => new VendorImport,
                  'mds-vendor.import' => new VendorImport,
                  'mdt-inventaris.import' => new InventarisImport,
                  'mds-inventaris.import' => new InventarisImport,
                  'mds-simpanan.import' => new MasterSimpananImport,
                  'pp-pengajuan.import' => new PengajuanImport,
                  'mdu-coa.import' => new CoaImport,
                  'shu-unit-pertokoan.import' => new ShuImport,
                  'shu-unit-sp.import' => new ShuImport,
            ];
            return $import;
      }

      public function getTanggalImport($tglImport)
      {
            $tglJadi = null;
            if (isset($tglImport)) {
                  $tglImport = (int)$tglImport;
                  $tglConvert = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglImport);
                  $tglJadi = Carbon::createFromFormat('Y-m-d', $tglConvert->format('Y-m-d'));
            }
            return $tglJadi;
      }

      public function getDataUnique($data, $name)
      {
            $collection = collect($data);
            $unique = $collection->unique($name);
            $data = $unique->values()->all();
            return $data;
      }
}
