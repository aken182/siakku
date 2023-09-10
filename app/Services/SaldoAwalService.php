<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Models\Detail_saldo_awal;
use App\Models\Saldo_awal_barang;

class SaldoAwalService
{
      private $detailSaldoAwal;
      private $detailSaldoAwalBarang;
      private $transaksi;
      private $jurnal;

      public function __construct()
      {
            $this->detailSaldoAwal = new Detail_saldo_awal;
            $this->detailSaldoAwalBarang = new Saldo_awal_barang;
            $this->transaksi = new Transaksi;
            $this->jurnal = new Jurnal;
      }

      public function getActive($route)
      {
            $modelCoa = $this->detailSaldoAwal;
            $modelBarang = $this->detailSaldoAwalBarang;
            $active = [
                  'sltk-coa' => self::cekSaldoAwal($modelCoa, 'Pertokoan', 'home'),
                  'sltk-persediaan' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'home', 'persediaan'),
                  'sltk-inventaris' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'home', 'inventaris'),
                  'slsp-coa' => self::cekSaldoAwal($modelCoa, 'Simpan Pinjam', 'home'),
                  'slsp-inventaris' => self::cekSaldoAwal($modelBarang, 'Simpan Pinjam', 'home', 'inventaris'),
                  'sltk-coa.store-tanggal' => self::cekSaldoAwal($modelCoa, 'Pertokoan', 'create'),
                  'sltk-persediaan.store-tanggal' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'create', 'persediaan'),
                  'sltk-inventaris.store-tanggal' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'create', 'inventaris'),
                  'slsp-coa.store-tanggal' => self::cekSaldoAwal($modelCoa, 'Simpan Pinjam', 'create'),
                  'slsp-inventaris.store-tanggal' => self::cekSaldoAwal($modelBarang, 'Simpan Pinjam', 'create', 'inventaris'),
                  'sltk-coa.create' => self::cekSaldoAwal($modelCoa, 'Pertokoan', 'create'),
                  'sltk-persediaan.create' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'create', 'persediaan'),
                  'sltk-inventaris.create' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'create', 'inventaris'),
                  'slsp-coa.create' => self::cekSaldoAwal($modelCoa, 'Simpan Pinjam', 'create'),
                  'slsp-inventaris.create' => self::cekSaldoAwal($modelBarang, 'Simpan Pinjam', 'create', 'inventaris'),
                  'sltk-coa.store' => self::cekSaldoAwal($modelCoa, 'Pertokoan', 'store'),
                  'sltk-persediaan.store' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'store', 'persediaan'),
                  'sltk-inventaris.store' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'store', 'inventaris'),
                  'slsp-coa.store' => self::cekSaldoAwal($modelCoa, 'Simpan Pinjam', 'store'),
                  'slsp-inventaris.store' => self::cekSaldoAwal($modelBarang, 'Simpan Pinjam', 'store', 'inventaris'),
                  'sltk-coa.edit' => self::cekSaldoAwal($modelCoa, 'Pertokoan', 'edit'),
                  'sltk-persediaan.edit' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'edit', 'persediaan'),
                  'sltk-inventaris.edit' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'edit', 'inventaris'),
                  'slsp-coa.edit' => self::cekSaldoAwal($modelCoa, 'Simpan Pinjam', 'edit'),
                  'slsp-inventaris.edit' => self::cekSaldoAwal($modelBarang, 'Simpan Pinjam', 'edit', 'inventaris'),
                  'sltk-coa.update' => self::cekSaldoAwal($modelCoa, 'Pertokoan', 'update'),
                  'sltk-persediaan.update' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'update', 'persediaan'),
                  'sltk-inventaris.update' => self::cekSaldoAwal($modelBarang, 'Pertokoan', 'update', 'inventaris'),
                  'slsp-coa.update' => self::cekSaldoAwal($modelCoa, 'Simpan Pinjam', 'update'),
                  'slsp-inventaris.update' => self::cekSaldoAwal($modelBarang, 'Simpan Pinjam', 'update', 'inventaris'),
                  'sltk-coa.form-import' => 'import',
                  'sltk-persediaan.form-import' => 'import',
                  'sltk-inventaris.form-import' => 'import',
                  'slsp-coa.form-import' => 'import',
                  'slsp-inventaris.form-import' => 'import',
            ];
            return $active[$route];
      }

      public function cekSaldoAwal($model, $unit, $page, $posisi = null)
      {
            if ($posisi != null) {
                  $latest = $model::with(['transaksi'])
                        ->where('posisi', $posisi)
                        ->whereHas('transaksi', function ($query) use ($unit) {
                              $query->where('unit', $unit);
                        })->latest()->first();
            } else {
                  $latest = $model::with(['transaksi'])
                        ->whereHas('transaksi', function ($query) use ($unit) {
                              $query->where('unit', $unit);
                        })->latest()->first();
            }

            if ($latest) {
                  switch ($page) {
                        case 'edit':
                              $active = 'edit';
                              break;
                        case 'update':
                              $active = 'update';
                              break;
                        default:
                              $active = 'home';
                              break;
                  }
            } else {
                  switch ($page) {
                        case 'create':
                              $active = 'create';
                              break;
                        case 'store':
                              $active = 'store';
                              break;
                        default:
                              $active = 'form-tanggal';
                              break;
                  }
            }
            return $active;
      }

      public function getUnit($route)
      {
            $unit = [
                  'sltk-coa' => 'Pertokoan',
                  'sltk-persediaan' => 'Pertokoan',
                  'sltk-inventaris' => 'Pertokoan',
                  'slsp-coa' => 'Simpan Pinjam',
                  'slsp-inventaris' => 'Simpan Pinjam',
                  'sltk-coa.store-tanggal' => 'Pertokoan',
                  'sltk-persediaan.store-tanggal' => 'Pertokoan',
                  'sltk-inventaris.store-tanggal' => 'Pertokoan',
                  'slsp-coa.store-tanggal' => 'Simpan Pinjam',
                  'slsp-inventaris.store-tanggal' => 'Simpan Pinjam',
                  'sltk-coa.store' => 'Pertokoan',
                  'sltk-persediaan.store' => 'Pertokoan',
                  'sltk-inventaris.store' => 'Pertokoan',
                  'slsp-coa.store' => 'Simpan Pinjam',
                  'slsp-inventaris.store' => 'Simpan Pinjam',
                  'sltk-coa.create' => 'Pertokoan',
                  'sltk-persediaan.create' => 'Pertokoan',
                  'sltk-inventaris.create' => 'Pertokoan',
                  'slsp-coa.create' => 'Simpan Pinjam',
                  'slsp-inventaris.create' => 'Simpan Pinjam',
                  'sltk-coa.edit' => 'Pertokoan',
                  'sltk-persediaan.edit' => 'Pertokoan',
                  'sltk-inventaris.edit' => 'Pertokoan',
                  'slsp-coa.edit' => 'Simpan Pinjam',
                  'slsp-inventaris.edit' => 'Simpan Pinjam',
                  'sltk-coa.update' => 'Pertokoan',
                  'sltk-persediaan.update' => 'Pertokoan',
                  'sltk-inventaris.update' => 'Pertokoan',
                  'slsp-coa.update' => 'Simpan Pinjam',
                  'slsp-inventaris.update' => 'Simpan Pinjam',
                  'sltk-coa.form-import' => 'Pertokoan',
                  'sltk-persediaan.form-import' => 'Pertokoan',
                  'sltk-inventaris.form-import' => 'Pertokoan',
                  'slsp-coa.form-import' => 'Simpan Pinjam',
                  'slsp-inventaris.form-import' => 'Simpan Pinjam',
            ];
            return $unit[$route];
      }

      public function  getJenis($route)
      {
            $jenis = [
                  'sltk-coa' => 'coa',
                  'sltk-persediaan' => 'persediaan',
                  'sltk-inventaris' => 'inventaris',
                  'slsp-coa' => 'coa',
                  'slsp-inventaris' => 'inventaris',
                  'sltk-coa.store-tanggal' => 'coa',
                  'sltk-persediaan.store-tanggal' => 'persediaan',
                  'sltk-inventaris.store-tanggal' => 'inventaris',
                  'slsp-coa.store-tanggal' => 'coa',
                  'slsp-inventaris.store-tanggal' => 'inventaris',
                  'sltk-coa.store' => 'coa',
                  'sltk-persediaan.store' => 'persediaan',
                  'sltk-inventaris.store' => 'inventaris',
                  'slsp-coa.store' => 'coa',
                  'slsp-inventaris.store' => 'inventaris',
                  'sltk-coa.create' => 'coa',
                  'sltk-persediaan.create' => 'persediaan',
                  'sltk-inventaris.create' => 'inventaris',
                  'slsp-coa.create' => 'coa',
                  'slsp-inventaris.create' => 'inventaris',
                  'sltk-coa.edit' => 'coa',
                  'sltk-persediaan.edit' => 'persediaan',
                  'sltk-inventaris.edit' => 'inventaris',
                  'slsp-coa.edit' => 'coa',
                  'slsp-inventaris.edit' => 'inventaris',
                  'sltk-coa.update' => 'coa',
                  'sltk-persediaan.update' => 'persediaan',
                  'sltk-inventaris.update' => 'inventaris',
                  'slsp-coa.update' => 'coa',
                  'slsp-inventaris.update' => 'inventaris',
                  'sltk-coa.form-import' => 'coa',
                  'sltk-persediaan.form-import' => 'persediaan',
                  'sltk-inventaris.form-import' => 'inventaris',
                  'slsp-coa.form-import' => 'coa',
                  'slsp-inventaris.form-import' => 'inventaris',
            ];
            return $jenis[$route];
      }

      public function getRouteMain($jenis, $unit)
      {
            $route = [
                  'coa-Pertokoan' => 'sltk-coa',
                  'persediaan-Pertokoan' => 'sltk-persediaan',
                  'inventaris-Pertokoan' => 'sltk-inventaris',
                  'coa-Simpan Pinjam' => 'slsp-coa',
                  'inventaris-Simpan Pinjam' => 'slsp-inventaris',
            ];
            return $route[$jenis . '-' . $unit];
      }

      public function getRouteImport($jenis, $unit)
      {
            $route = [
                  'coa-Pertokoan' => 'sltk-coa.form-import',
                  'persediaan-Pertokoan' => 'sltk-persediaan.form-import',
                  'inventaris-Pertokoan' => 'sltk-inventaris.form-import',
                  'coa-Simpan Pinjam' => 'slsp-coa.form-import',
                  'inventaris-Simpan Pinjam' => 'slsp-inventaris.form-import',
            ];
            return $route[$jenis . '-' . $unit];
      }

      public function getRouteStoreTanggal($route)
      {
            $store = [
                  'sltk-coa' => 'sltk-coa.store-tanggal',
                  'sltk-persediaan' => 'sltk-persediaan.store-tanggal',
                  'sltk-inventaris' => 'sltk-inventaris.store-tanggal',
                  'slsp-coa' => 'slsp-coa.store-tanggal',
                  'slsp-inventaris' => 'slsp-inventaris.store-tanggal',
            ];
            return $store[$route];
      }

      public function getRouteEdit($route)
      {
            $edit = [
                  'sltk-coa' => 'sltk-coa.edit',
                  'sltk-persediaan' => 'sltk-persediaan.edit',
                  'sltk-inventaris' => 'sltk-inventaris.edit',
                  'slsp-coa' => 'slsp-coa.edit',
                  'slsp-inventaris' => 'slsp-inventaris.edit',
            ];
            return $edit[$route];
      }

      public function getRouteStoreTransaksi($route)
      {
            $routeCreate = [
                  'sltk-coa.create' => 'sltk-coa.store',
                  'sltk-persediaan.create' => 'sltk-persediaan.store',
                  'sltk-inventaris.create' => 'sltk-inventaris.store',
                  'slsp-coa.create' => 'slsp-coa.store',
                  'slsp-inventaris.create' => 'slsp-inventaris.store',
            ];
            return $routeCreate[$route];
      }

      public function getRouteCreateTransaksi($route)
      {
            $routeCreate = [
                  'sltk-coa.store-tanggal' => 'sltk-coa.create',
                  'sltk-persediaan.store-tanggal' => 'sltk-persediaan.create',
                  'sltk-inventaris.store-tanggal' => 'sltk-inventaris.create',
                  'slsp-coa.store-tanggal' => 'slsp-coa.create',
                  'slsp-inventaris.store-tanggal' => 'slsp-inventaris.create',
            ];
            return $routeCreate[$route];
      }

      public function getRouteStoreImport($route)
      {
            $routeStore = [
                  'sltk-coa.form-import' => 'sltk-coa.import',
                  'sltk-persediaan.form-import' => 'sltk-persediaan.import',
                  'sltk-inventaris.form-import' => 'sltk-inventaris.import',
                  'slsp-coa.form-import' => 'slsp-coa.import',
                  'slsp-inventaris.form-import' => 'slsp-inventaris.import',
            ];
            return $routeStore[$route];
      }

      public function getRouteTemplateImport($route)
      {
            $routeTemplate = [
                  'sltk-coa.form-import' => 'sltk-coa.import-template',
                  'sltk-persediaan.form-import' => 'sltk-persediaan.import-template',
                  'sltk-inventaris.form-import' => 'sltk-inventaris.import-template',
                  'slsp-coa.form-import' => 'slsp-coa.import-template',
                  'slsp-inventaris.form-import' => 'slsp-inventaris.import-template',
            ];
            return $routeTemplate[$route];
      }

      public function getRouteUpdateTransaksi($route)
      {
            $routeCreate = [
                  'sltk-coa.edit' => 'sltk-coa.update',
                  'sltk-persediaan.edit' => 'sltk-persediaan.update',
                  'sltk-inventaris.edit' => 'sltk-inventaris.update',
                  'slsp-coa.edit' => 'slsp-coa.update',
                  'slsp-inventaris.edit' => 'slsp-inventaris.update',
            ];
            return $routeCreate[$route];
      }

      public function createTransaksiSaldoAwalCoa($total, $tanggal, $kode, $unit)
      {
            $this->transaksi::create([
                  'tgl_transaksi' => $tanggal,
                  'kode' => $kode,
                  'jenis_transaksi' => 'Saldo Awal COA',
                  'detail_tabel' => 'detail_saldo_awal',
                  'metode_transaksi' => 'Saldo Awal',
                  'unit' => $unit,
                  'keterangan' => 'Input Saldo Awal Unit ' . $unit,
                  'total' => $total,
            ]);
      }

      public function createSaldoAwalCoa($request, $id_transaksi, $coa)
      {
            foreach ($coa as $value) {

                  $request["saldo_debet$value->id_coa"] = convertToNumber($request->input("saldo_debet$value->id_coa"));
                  $request["saldo_kredit$value->id_coa"] = convertToNumber($request->input("saldo_kredit$value->id_coa"));

                  $saldoPosisi = self::getSaldoPosisiCoa($request, $value);
                  if ($saldoPosisi["saldo"] > 0) {
                        self::createDetailCoa($id_transaksi, $value->id_coa, $saldoPosisi);
                        self::createJurnalCoa($id_transaksi, $value->id_coa, $saldoPosisi);
                  }
            }
      }

      public function createDetailCoa($id_transaksi, $id_coa, $data)
      {
            $this->detailSaldoAwal::create([
                  'id_transaksi' => $id_transaksi,
                  'id_coa' => $id_coa,
                  'posisi_dr_cr' => $data["posisi"],
                  'saldo' => $data["saldo"]
            ]);
      }

      public function createJurnalCoa($id_transaksi, $id_coa, $data)
      {
            $this->jurnal::create([
                  'id_coa' => $id_coa,
                  'id_transaksi' => $id_transaksi,
                  'posisi_dr_cr' => $data["posisi"],
                  'nominal' => $data["saldo"]
            ]);
      }

      public function updateTransaksiSaldoAwalCoa($request, $id, $coa)
      {
            self::updateTransaksiCoa($id, $request->input('total_debet'), $request->input('total_kredit'));
            foreach ($coa as $value) {
                  $request["saldo_debet$value->id_coa"] = convertToNumber($request->input("saldo_debet$value->id_coa"));
                  $request["saldo_kredit$value->id_coa"] = convertToNumber($request->input("saldo_kredit$value->id_coa"));
                  $data = self::getSaldoPosisiCoa($request, $value);
                  self::updateDetailSaldoAwalCoa($data, $id, $value->id_coa);
            }
      }

      function updateTransaksiCoa($id = null, $debet, $kredit)
      {
            $total = $debet + $kredit;
            $update_transaksi = [
                  'total' => $total
            ];
            $this->transaksi::where('id_transaksi', $id)->update($update_transaksi);
      }

      function updateDetailCoa($id_detail, $data)
      {
            $update_detail = [
                  'posisi_dr_cr' => $data["posisi"],
                  'saldo' => $data["saldo"]
            ];
            $this->detailSaldoAwal::where('id_detail', $id_detail)->update($update_detail);
      }

      function updateJurnalCoa($id_jurnal, $data)
      {
            $update_jurnal = [
                  'posisi_dr_cr' => $data["posisi"],
                  'nominal' => $data["saldo"]
            ];
            $this->jurnal::where('id_jurnal', $id_jurnal)->update($update_jurnal);
      }

      public function updateDetailSaldoAwalCoa($data, $id, $id_coa)
      {
            $id_detail = self::getIdDetailCoa($id, $id_coa);
            if ($id_detail) {
                  self::updateDetailCoa($id_detail, $data);
            } else {
                  if ($data["saldo"] > 0) {
                        self::createDetailCoa($id, $id_coa, $data);
                  }
            }

            $id_jurnal = self::getIdJurnalCoa($id, $id_coa);
            if ($id_jurnal) {
                  self::updateJurnalCoa($id_jurnal, $data);
            } else {
                  if ($data["saldo"] > 0) {
                        self::createJurnalCoa($id, $id_coa, $data);
                  }
            }
      }

      public function getIdDetailCoa($id, $id_coa)
      {
            return $this->detailSaldoAwal::where('id_transaksi', $id)->where('id_coa', $id_coa)->value('id_detail');
      }

      public function getIdJurnalCoa($id, $id_coa)
      {
            return $this->jurnal::where('id_transaksi', $id)->where('id_coa', $id_coa)->value('id_jurnal');
      }

      public function getSaldoPosisiCoa($request, $value)
      {
            if ($request["saldo_debet$value->id_coa"] == 0 && $request["saldo_kredit$value->id_coa"] > 0) {
                  $request["saldo$value->id_coa"] = $request["saldo_kredit$value->id_coa"];
                  $request["posisi_dr_cr$value->id_coa"] = "kredit";
            } elseif ($request["saldo_debet$value->id_coa"] > 0 && $request["saldo_kredit$value->id_coa"] == 0) {
                  $request["saldo$value->id_coa"] = $request["saldo_debet$value->id_coa"];
                  $request["posisi_dr_cr$value->id_coa"] = "debet";
            } else {
                  if ($request->input("header$value->id_coa") == 1 || $request->input("header$value->id_coa") == 5) {
                        $request["saldo$value->id_coa"] = 0;
                        $request["posisi_dr_cr$value->id_coa"] = "debet";
                  } else {
                        $request["saldo$value->id_coa"] = 0;
                        $request["posisi_dr_cr$value->id_coa"] = "kredit";
                  }
            }

            return [
                  'saldo' => $request["saldo$value->id_coa"],
                  'posisi' => $request["posisi_dr_cr$value->id_coa"],
            ];
      }

      public function getCoa($unit, $coa, $id)
      {
            $data = [];
            foreach ($coa as $c) {
                  $saldo = self::getSaldoDebetKreditEditView($id, $c->id_coa, $unit);
                  array_push($data, [
                        'id_coa' => $c->id_coa,
                        'kode' => $c->kode,
                        'nama' => $c->nama,
                        'header' => $c->header,
                        'kategori' => $c->kategori,
                        'saldo_debet' => $saldo['debet'],
                        'saldo_kredit' => $saldo['kredit'],
                  ]);
            }
            return $data;
      }

      public function getSaldoDebetKreditEditView($id, $id_coa, $unit)
      {
            $saldo['debet'] = 0;
            $saldo['kredit'] = 0;

            $detail = self::getTransaksiSaldoAwalCoaFirst($id, $unit, $id_coa);
            if ($detail) {
                  if ($detail->posisi_dr_cr == "debet") {
                        $saldo['debet'] = $detail->saldo;
                        $saldo['kredit'] = 0;
                  } else {
                        $saldo['debet'] = 0;
                        $saldo['kredit'] = $detail->saldo;
                  }
            }

            return $saldo;
      }

      public function getTransaksiSaldoAwalCoaFirst($id, $unit, $id_coa)
      {
            return $this->detailSaldoAwal::with(['transaksi', 'coa'])
                  ->where('id_coa', $id_coa)
                  ->whereHas('transaksi', function ($query) use ($unit, $id) {
                        $query->where('id_transaksi', $id)
                              ->where('unit', $unit);
                  })->first();
      }
}
