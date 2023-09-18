<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Anggota;
use App\Models\Transaksi;
use App\Services\CoaService;
use App\Models\Detail_pendapatan;

class PendapatanService
{
      private $coaService;

      public function __construct()
      {
            $this->coaService = new CoaService;
      }

      /**
       * Mengambil unit berdasarkan 
       * nama route sekarang
       *
       * @param mixed $route
       * @return string
       **/
      public function getUnit($route)
      {
            $unit = [
                  'ptk-pendapatan' => 'Pertokoan',
                  'pendapatan-unit-sp' => 'Simpan Pinjam',
            ];

            // Menghapus bagian yang sama dalam kunci
            $route = str_replace(['.list', '.store', '.create', '.show', '.detail'], '', $route);

            return $unit[$route];
      }

      /**
       * Mengambil route utama dari transaksi 
       * pendapatan
       *
       * @param mixed $unit
       * @return string
       **/
      public function getMainRoute($unit)
      {
            $route = [
                  'Pertokoan' => 'ptk-pendapatan',
                  'Simpan Pinjam' => 'pendapatan-unit-sp'
            ];
            return $route[$unit];
      }

      /**
       * Mengambil route show untuk fungsi
       * untuk digunakan dalam list transaksi.
       *
       * @param mixed $route
       * @return string
       * 
       **/
      public function getRouteToTable($route)
      {
            $store = [
                  'ptk-pendapatan.list' => 'ptk-pendapatan.show',
                  'pendapatan-unit-sp.list' => 'pendapatan-unit-sp.show',
            ];
            return $store[$route];
      }

      public function getPenyesuaianPendapatan($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Pendapatan');
                  })->get();
            return $penyesuaian;
      }

      /**
       * Menginput transaksi ke dalam tabel
       * transaksi
       *
       **/
      public function createTransaksi($request, $invoicepny, $imageName, $detailTransaksi)
      {
            //--input ke tabel transaksi--//
            Transaksi::create([
                  'kode' => $request->input('nomor'),
                  'kode_pny' => $invoicepny,
                  'no_bukti' => $request->input('no_bukti'),
                  'tipe' => $request->input('cek_penjualan') ?? $request->input('cek_pendapatan'),
                  'tgl_transaksi' => $request->input('tgl_transaksi'),
                  'detail_tabel' => $detailTransaksi,
                  'jenis_transaksi' => $request->input('jenis_transaksi'),
                  'metode_transaksi' => $request->input('metode_transaksi'),
                  'nota_transaksi' => $imageName,
                  'tpk' => $request->input('tpk') ?? 'Larantuka',
                  'unit' => $request->input('unit'),
                  'total' => $request['total_transaksi'],
                  'keterangan' => self::getKeteranganTransaksi($request, $invoicepny)
            ]);
      }

      /**
       * Mengambil keterangan transaksi
       *
       **/
      public function getKeteranganTransaksi($request, $invoicepny)
      {
            if ($request->input('keterangan') == null) {
                  if ($request->input('pembeli') === 'pegawai') {
                        $pembeli = Anggota::where('id_anggota', $request->input('pegawai_id'))->value('nama');
                  } else {
                        $pembeli = $request->input('nama_bukan_pegawai');
                  }
                  if ($invoicepny == null) {
                        $keterangan = 'Penjualan Barang TPK ' . $request->input('tpk') . ' kepada ' . $pembeli;
                  } else {
                        $keterangan = 'Penyesuaian Penjualan ' . $invoicepny . ' - Penjualan Barang TPK ' . $request->input('tpk') . ' kepada ' . $pembeli;
                  }
                  return $keterangan;
            } else {
                  return $request->input('keterangan');
            }
      }

      /**
       * Menginput transaksi ke dalam tabel
       * detail_pendapatan
       *
       **/
      public function createDetailTransaksi($r, $id_transaksi)
      {
            $jenis_pendapatan = $this->coaService->getJenisPendapatan($r['id_kredit']);
            $data = $r['data'];
            foreach ($data as $datum) {
                  $harga = convertToNumber($datum['harga']);
                  $subtotal = convertToNumber($datum['total']);
                  Detail_pendapatan::create([
                        'id_transaksi' => $id_transaksi,
                        'id_satuan' => $datum['satuan'],
                        'jenis_pendapatan' => $jenis_pendapatan,
                        'nama_pendapatan' => $datum['nama'],
                        'qty' => $datum['kuantitas'],
                        'harga' => $harga,
                        'subtotal' => $subtotal
                  ]);
            }
      }

      /**
       * Deklarasi variabel input jurnal pendapatan
       * untuk menginput jurnal pembalik dan membuat jurnal baru
       *
       **/
      public function createJurnal($request, $id_transaksi, $idTransPeny)
      {
            $id_debet = $this->coaService->getIdDebet($request);
            $model = new Jurnal;
            /*jurnal pembalik*/
            $cekTransaksi = $request['cek_penjualan'] ?? $request['cek_pendapatan'];
            if ($cekTransaksi === 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $idTransPeny);
            }
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $request['id_kredit'], $id_transaksi, 'kredit', $request["total_transaksi"]);
      }
}
