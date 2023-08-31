<?php

namespace App\Services;

use App\Models\Unit;
use App\Models\Barang;
use App\Models\Barang_eceran;
use Illuminate\Support\Facades\Route;

class BarangService
{
      public function getDataIndex()
      {
            $cek_route = Route::currentRouteName();

            switch ($cek_route) {
                  case 'mdt-persediaan':
                        $title = 'Persediaan Unit Pertokoan';
                        $posisi = 'persediaan';
                        $routeCreate = route('mdt-persediaan.create');
                        $routeEdit = 'mdt-persediaan.edit';
                        $routeDelete = 'mdt-persediaan.destroy';
                        $routeImport = route('mdt-persediaan.form-import');
                        $routeExportExcel = route('mdt-persediaan.export-excel');
                        $routeExportPdf = route('mdt-persediaan.export-pdf');
                        $barang = self::getDataBarang('Pertokoan', $posisi);
                        break;
                  case 'mdt-inventaris':
                        $title = 'Inventaris Unit Pertokoan';
                        $posisi = 'inventaris';
                        $routeCreate = route('mdt-inventaris.create');
                        $routeEdit = 'mdt-inventaris.edit';
                        $routeDelete = 'mdt-inventaris.destroy';
                        $routeImport = route('mdt-inventaris.form-import');
                        $routeExportExcel = route('mdt-inventaris.export-excel');
                        $routeExportPdf = route('mdt-inventaris.export-pdf');
                        $barang = self::getDataBarang('Pertokoan', $posisi);
                        break;
                  case 'mds-inventaris':
                        $title = 'Inventaris Unit Simpan Pinjam';
                        $posisi = 'inventaris';
                        $routeCreate = route('mds-inventaris.create');
                        $routeEdit = 'mds-inventaris.edit';
                        $routeDelete = 'mds-inventaris.destroy';
                        $routeImport = route('mds-inventaris.form-import');
                        $routeExportExcel = route('mds-inventaris.export-excel');
                        $routeExportPdf = route('mds-inventaris.export-pdf');
                        $barang = self::getDataBarang('Simpan Pinjam', $posisi);
                        break;
            }
            return [
                  'title' => $title,
                  'posisi' => $posisi,
                  'routeCreate' => $routeCreate,
                  'routeEdit' => $routeEdit,
                  'routeDelete' => $routeDelete,
                  'routeImport' => $routeImport,
                  'routeExportExcel' => $routeExportExcel,
                  'routeExportPdf' => $routeExportPdf,
                  'barang' => $barang
            ];
      }

      public function getDataIndexEceran()
      {
            $cek_route = Route::currentRouteName();

            switch ($cek_route) {
                  case 'mdt-persediaan-eceran':
                        $title = 'Persediaan Eceran Unit Pertokoan';
                        $posisi = 'persediaan';
                        $routeCreate = route('mdt-persediaan-eceran.create');
                        $routeEdit = 'mdt-persediaan-eceran.edit';
                        $routeDelete = 'mdt-persediaan-eceran.destroy';
                        $routeExportExcel = route('mdt-persediaan-eceran.export-excel');
                        $routeExportPdf = route('mdt-persediaan-eceran.export-pdf');
                        $barang = self::getDataBarangEceran('Pertokoan', $posisi);
                        break;
                  case 'mdt-inventaris-eceran':
                        $title = 'Inventaris Eceran Unit Pertokoan';
                        $posisi = 'inventaris';
                        $routeCreate = route('mdt-inventaris-eceran.create');
                        $routeEdit = 'mdt-inventaris-eceran.edit';
                        $routeDelete = 'mdt-inventaris-eceran.destroy';
                        $routeExportExcel = route('mdt-inventaris-eceran.export-excel');
                        $routeExportPdf = route('mdt-inventaris-eceran.export-pdf');
                        $barang = self::getDataBarangEceran('Pertokoan', $posisi);
                        break;
                  case 'mds-inventaris-eceran':
                        $title = 'Inventaris Eceran Unit Simpan Pinjam';
                        $posisi = 'inventaris';
                        $routeCreate = route('mds-inventaris-eceran.create');
                        $routeEdit = 'mds-inventaris-eceran.edit';
                        $routeDelete = 'mds-inventaris-eceran.destroy';
                        $routeExportExcel = route('mds-inventaris-eceran.export-excel');
                        $routeExportPdf = route('mds-inventaris-eceran.export-pdf');
                        $barang = self::getDataBarangEceran('Simpan Pinjam', $posisi);
                        break;
            }
            return [
                  'title' => $title,
                  'posisi' => $posisi,
                  'routeCreate' => $routeCreate,
                  'routeEdit' => $routeEdit,
                  'routeDelete' => $routeDelete,
                  'routeExportExcel' => $routeExportExcel,
                  'routeExportPdf' => $routeExportPdf,
                  'barang' => $barang
            ];
      }

      public function getDataCreate()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan.create':
                        $title = 'Form Tambah Persediaan';
                        $posisi = 'persediaan';
                        $routeStore = 'mdt-persediaan.store';
                        $routeMain = 'mdt-persediaan';
                        $unit = self::getDataUnit('Pertokoan');
                        break;
                  case 'mdt-inventaris.create':
                        $title = 'Form Tambah Inventaris';
                        $posisi = 'inventaris';
                        $routeStore = 'mdt-inventaris.store';
                        $routeMain = 'mdt-inventaris';
                        $unit = self::getDataUnit('Pertokoan');
                        break;
                  case 'mds-inventaris.create':
                        $title = 'Form Tambah Inventaris';
                        $posisi = 'inventaris';
                        $routeStore = 'mds-inventaris.store';
                        $routeMain = 'mds-inventaris';
                        $unit = self::getDataUnit('Simpan Pinjam');
                        break;
            }
            return [
                  'title' => $title,
                  'posisi' => $posisi,
                  'routeStore' => $routeStore,
                  'routeMain' => $routeMain,
                  'unit' => $unit
            ];
      }

      public function getDataCreateEceran()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan-eceran.create':
                        $title = 'Form Tambah Persediaan Eceran';
                        $posisi = 'persediaan';
                        $routeStore = 'mdt-persediaan-eceran.store';
                        $routeMain = 'mdt-persediaan-eceran';
                        $unit = self::getDataUnit('Pertokoan');
                        break;
                  case 'mdt-inventaris-eceran.create':
                        $title = 'Form Tambah Inventaris Eceran';
                        $posisi = 'inventaris';
                        $routeStore = 'mdt-inventaris-eceran.store';
                        $routeMain = 'mdt-inventaris-eceran';
                        $unit = self::getDataUnit('Pertokoan');
                        break;
                  case 'mds-inventaris-eceran.create':
                        $title = 'Form Tambah Inventaris Eceran';
                        $posisi = 'inventaris';
                        $routeStore = 'mds-inventaris-eceran.store';
                        $routeMain = 'mds-inventaris-eceran';
                        $unit = self::getDataUnit('Simpan Pinjam');
                        break;
            }
            return [
                  'title' => $title,
                  'posisi' => $posisi,
                  'routeStore' => $routeStore,
                  'routeMain' => $routeMain,
                  'unit' => $unit
            ];
      }

      public function getDataBarangToConvert($posisi)
      {
            return Barang::with(['satuan', 'unit'])
                  ->where('status_konversi', 'Y')
                  ->where('posisi_pi', $posisi)
                  ->get();
      }

      public function getDataStore()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan.store':
                        $routeMain = 'mdt-persediaan';
                        break;
                  case 'mdt-inventaris.store':
                        $routeMain = 'mdt-inventaris';
                        break;
                  case 'mds-inventaris.store':
                        $routeMain = 'mds-inventaris';
                        break;
            }
            return $routeMain;
      }

      public function getDataStoreEceran()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan-eceran.store':
                        $routeMain = 'mdt-persediaan-eceran';
                        $posisi = 'persediaan eceran';
                        break;
                  case 'mdt-inventaris-eceran.store':
                        $routeMain = 'mdt-inventaris-eceran';
                        $posisi = 'inventaris eceran';
                        break;
                  case 'mds-inventaris-eceran.store':
                        $routeMain = 'mds-inventaris-eceran';
                        $posisi = 'inventaris eceran';
                        break;
            }
            return [
                  'route' => $routeMain,
                  'posisi' => $posisi,
            ];
      }

      public function getDataUpdate()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan.update':
                        $routeMain = 'mdt-persediaan';
                        break;
                  case 'mdt-inventaris.update':
                        $routeMain = 'mdt-inventaris';
                        break;
                  case 'mds-inventaris.update':
                        $routeMain = 'mds-inventaris';
                        break;
            }
            return $routeMain;
      }

      public function getDataUpdateEceran()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan-eceran.update':
                        $routeMain = 'mdt-persediaan-eceran';
                        $posisi = 'persediaan eceran';
                        break;
                  case 'mdt-inventaris-eceran.update':
                        $routeMain = 'mdt-inventaris-eceran';
                        $posisi = 'inventaris eceran';
                        break;
                  case 'mds-inventaris-eceran.update':
                        $routeMain = 'mds-inventaris-eceran';
                        $posisi = 'inventaris eceran';
                        break;
            }
            return [
                  'route' => $routeMain,
                  'posisi' => $posisi,
            ];
      }

      public function getDataDelete()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan.destroy':
                        $posisi = 'persediaan';
                        break;
                  case 'mdt-inventaris.destroy':
                        $posisi = 'inventaris';
                        break;
                  case 'mds-inventaris.destroy':
                        $posisi = 'inventaris';
                        break;
            }
            return $posisi;
      }

      public function getDataDeleteEceran()
      {
            $cek_route = Route::currentRouteName();
            switch ($cek_route) {
                  case 'mdt-persediaan-eceran.destroy':
                        $posisi = 'persediaan eceran';
                        break;
                  case 'mdt-inventaris-eceran.destroy':
                        $posisi = 'inventaris eceran';
                        break;
                  case 'mds-inventaris-eceran.destroy':
                        $posisi = 'inventaris eceran';
                        break;
            }
            return $posisi;
      }

      public function getDataBarang($unit, $posisi)
      {
            return Barang::with(['satuan', 'unit'])
                  ->where('posisi_pi', $posisi)
                  ->whereHas('unit', function ($query) use ($unit) {
                        $query->where('unit', $unit);
                  })->get();
      }

      public function getDataBarangEceran($unit, $posisi)
      {
            return Barang_eceran::with(['satuan', 'barang.unit', 'barang.satuan', 'barang'])
                  ->whereHas('barang', function ($query) use ($unit, $posisi) {
                        $query->where('posisi_pi', $posisi)
                              ->whereHas('unit', function ($query) use ($unit) {
                                    $query->where('unit', $unit);
                              });
                  })->get();
      }

      public function getDataUnit($unit)
      {
            return Unit::where('unit', $unit)->get();
      }

      public function getBarang($id)
      {
            return Barang::with(['satuan', 'unit'])->where('id_barang', $id)->first();
      }

      public function getBarangEceran($id)
      {
            return Barang_eceran::with(['satuan', 'barang.unit', 'barang', 'barang.satuan'])->where('id_eceran', $id)->first();
      }

      public function getKodeBarangUpdate($id)
      {
            $barang = self::getBarang($id);
            return $barang->kode_barang;
      }

      public function getEditData($id)
      {
            $barang = self::getBarang($id);
            $unit = $barang->unit->unit;
            if ($barang->posisi_pi === 'inventaris') {
                  $title = 'Form Edit Inventaris';
            } else {
                  $title = 'Form Edit Persediaan';
            }
            $route = self::getRouteMainEdit();
            return [
                  'title' => $title,
                  'routeMain' => $route['routeMain'],
                  'routeUpdate' => $route['routeUpdate'],
                  'unit' => self::getDataUnit($unit)
            ];
      }

      public function getEditDataEceran($id)
      {
            $barang = self::getBarangEceran($id);
            if ($barang->barang->posisi_pi === 'inventaris') {
                  $title = 'Form Edit Inventaris Eceran';
            } else {
                  $title = 'Form Edit Persediaan Eceran';
            }
            $route = self::getRouteMainEditEceran();
            return [
                  'title' => $title,
                  'routeMain' => $route['routeMain'],
                  'routeUpdate' => $route['routeUpdate'],
            ];
      }

      public function getRouteMainEdit()
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-persediaan.edit':
                        $routeMain = 'mdt-persediaan';
                        $routeUpdate = 'mdt-persediaan.update';
                        break;
                  case 'mdt-inventaris.edit':
                        $routeMain = 'mdt-inventaris';
                        $routeUpdate = 'mdt-inventaris.update';
                        break;
                  case 'mds-inventaris.edit':
                        $routeMain = 'mds-inventaris';
                        $routeUpdate = 'mds-inventaris.update';
                        break;
            }
            return [
                  'routeMain' => $routeMain,
                  'routeUpdate' => $routeUpdate,
            ];
      }

      public function getRouteMainEditEceran()
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-persediaan-eceran.edit':
                        $routeMain = 'mdt-persediaan-eceran';
                        $routeUpdate = 'mdt-persediaan-eceran.update';
                        break;
                  case 'mdt-inventaris-eceran.edit':
                        $routeMain = 'mdt-inventaris-eceran';
                        $routeUpdate = 'mdt-inventaris-eceran.update';
                        break;
                  case 'mds-inventaris-eceran.edit':
                        $routeMain = 'mds-inventaris-eceran';
                        $routeUpdate = 'mds-inventaris-eceran.update';
                        break;
            }
            return [
                  'routeMain' => $routeMain,
                  'routeUpdate' => $routeUpdate,
            ];
      }

      public function getKodeBarang($id_unit)
      {
            $unit = Unit::where('id_unit', $id_unit)->first();
            $kode_unit = $unit->kode_unit;
            $prefix = $kode_unit;
            $kode = kode(new Barang, $prefix, 'kode_barang');
            return $kode;
      }

      public function updateBarang($id_barang, $sisa_stok)
      {
            $data = [
                  'stok' => convertToNumber($sisa_stok),
                  'status_konversi' => 'S'
            ];
            Barang::where('id_barang', $id_barang)->update($data);
      }

      public function updateBarangEceran($request, $id)
      {
            $id_barang = $request->input('id_barang');
            $barangEceran = self::getBarangEceran($id);
            $jumlah_stok = $barangEceran->jumlah_konversi;
            $sisa_stok = convertToNumber($request->input("sisa_stok"));
            $tambah_stok = convertToNumber($request->input("tambah_stok"));
            $stok_konversi = convertToNumber($request->input("sisa_stokkon"));

            $jumlah_konversi = $jumlah_stok + $tambah_stok;

            $data = [
                  'stok' => $sisa_stok
            ];

            $data2 = [
                  'jumlah_konversi' => $jumlah_konversi,
                  'stok' => $stok_konversi
            ];
            Barang::where('id_barang', $id_barang)->update($data);
            Barang_eceran::where('id_eceran', $id)->update($data2);
      }



      public function storeEceran($request)
      {
            Barang_eceran::create([
                  'id_barang' => $request->input('id_barang'),
                  'id_satuan' => $request->input('id_satuan'),
                  'standar_nilai' => convertToNumber($request->input('standar_nilai')),
                  'jumlah_konversi' => convertToNumber($request->input('jumlah_konversi')),
                  'stok' => convertToNumber($request->input('stok_konversi')),
                  'harga_barang' => convertToNumber($request->input('harga_barang_konversi')),
                  'nilai_saat_ini' => convertToNumber($request->input('harga_barang_konversi')),
                  'harga_jual' => convertToNumber($request->input('harga_jual_konversi'))
            ]);
      }

      public function deleteEceran($id)
      {
            $eceran = self::getBarangEceran($id);
            $id_barang = $eceran->id_barang;
            $jumlah_stok = $eceran->jumlah_konversi;
            $stok = $eceran->barang->stok;

            $stok_sekarang = $stok + $jumlah_stok;
            $data = [
                  'stok' => $stok_sekarang,
                  'status_konversi' => 'T'
            ];

            Barang::where('id_barang', $id_barang)->update($data);
            Barang_eceran::where('id_eceran', $id)->delete();
      }

      public function createToImport($id_satuan, $id_unit, $kode, $posisi, $row)
      {
            $umurEkonomis = self::getUmurEkonomis($posisi, $row);
            Barang::create([
                  'id_satuan' => $id_satuan,
                  'id_unit' => $id_unit,
                  'kode_barang' => $kode,
                  'nama_barang' => $row['nama_barang'],
                  'jenis_barang' => $row['jenis_barang'],
                  'posisi_pi' => $posisi,
                  'umur_ekonomis' => $umurEkonomis,
            ]);
      }

      public function getUmurEkonomis($posisi, $row)
      {
            $u = null;
            if ($posisi === 'inventaris') {
                  $u = $row['umur_ekonomis'];
            }
            return $u;
      }
}
