<?php

namespace App\Services;

use App\Models\Unit;
use App\Models\Barang;
use App\Models\Saldo_awal_barang;
use App\Models\Transaksi;
use App\Services\TransaksiService;


class SaldoAwalBarangService
{
      private $transaksiService;
      private $accountingService;
      private $barangService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->accountingService = new AccountingService;
            $this->barangService = new BarangService;
      }

      /**
       * Dokumentasi getKode Transaksi Saldo Awal Barang
       *
       * Mengambil kode transaksi dengan mencari kode 
       * yang belum digunakan untuk dijadikan 
       * parameter dalam membuat transaksi saldo awal barang
       *
       * @param mixed $model
       * @param mixed $jenis
       * @return $kode
       **/
      public function getKode($model, $jenis)
      {
            $prefix = $jenis === 'inventaris' ? 'SLDOI-' : 'SLDOP-';
            $kode = kode($model, $prefix, 'kode');
            return $kode;
      }

      /**
       * Dokumentasi create transaksi saldo awal barang
       *
       * Merangkum fungsi-fungsi untuk menyimpan 
       * transaksi saldo awal barang
       *
       * @param Request $request
       * @param mixed $kode
       * @param mixed $unit
       * @param mixed $jenis
       * @return void
       **/
      public function create($request, $kode, $unit, $jenis)
      {
            $data = json_decode($request->input('data_barang'), true);
            $tanggal = $request->input('tgl_transaksi');
            $total = convertToNumber($request->input('total_transaksi'));
            self::createTransaksi($tanggal, $kode, $unit, $jenis, $total);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($kode);
            foreach ($data as $d) {
                  self::createDetail($d, $id_transaksi, $jenis);
            }
            $this->accountingService->jurnalSaldoAwalBarang($data, $id_transaksi, $jenis);
      }

      /**
       * Input transaksi saldo awal barang
       *
       * Menyimpan data transaksi kedalam
       * tabel transaksi
       *
       * @param Request $request
       * @param mixed $tanggal
       * @param mixed $kode
       * @param mixed $unit
       * @param mixed $jenis
       * @param mixed $total
       * @return void
       **/
      public function createTransaksi($tanggal, $kode, $unit, $jenis, $total)
      {
            Transaksi::create([
                  'tgl_transaksi' => $tanggal,
                  'kode' => $kode,
                  'jenis_transaksi' => 'Saldo Awal ' . $jenis,
                  'detail_tabel' => 'saldo_awal_barang',
                  'metode_transaksi' => 'Saldo Awal',
                  'unit' => $unit,
                  'keterangan' => 'Input Saldo Awal ' . $jenis . ' Unit ' . $unit,
                  'total' => $total,
            ]);
      }

      /**
       *Input detail transaksi saldo awal barang
       *
       * Menyimpan data detail ke dalam 
       * tabel saldo_awal_barang & kedalam tabel barang
       *
       * @param mixed $data
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @return void
       **/
      public function createDetail($data, $id_transaksi, $jenis)
      {
            $model = new Barang;
            if ($data['jenis'] === "barang baru") {
                  $prefix = Unit::where('id_unit', $data['id_unit'])->value('kode_unit');
                  $kode = kode($model, $prefix, 'kode_barang');
                  $this->barangService->createPengadaanBarang($model, $data, $kode, $jenis);
                  $id_barang = $model::where('kode_barang', $kode)->value('id_barang');
            } else {
                  $this->barangService->updatePengadaanBarang($model, $data);
                  $id_barang = $data['id_barang'];
            }
            $nilaiBuku = $jenis === "inventaris" ? $data['nilai_buku'] : null;
            self::createSaldoAwalBarang($id_transaksi, $jenis, $id_barang, $nilaiBuku, $data);
      }

      /**
       * Input detail saldo awal barang
       *
       * Menyimpan detail saldo awal barang ke dalam
       * tabel saldo_awal_barang
       *
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @param mixed $id_barang
       * @param mixed $nilaiBuku
       * @param Array $data
       * @return void
       **/
      public function createSaldoAwalBarang($id_transaksi, $jenis, $id_barang, $nilaiBuku, $data)
      {
            Saldo_awal_barang::create([
                  'id_transaksi' => $id_transaksi,
                  'posisi' => $jenis,
                  'id_barang' => $id_barang,
                  'qty' => $data['qty'],
                  'harga' => $data['harga'],
                  'nilai_buku' => $nilaiBuku,
                  'subtotal' => $data['subtotal'],
            ]);
      }

      /**
       * Input detail saldo awal barang
       *
       * Mengubah detail saldo awal barang berdasarkan id_transaksi
       * pada tabel saldo_awal_barang
       *
       * @param mixed $id_saldo
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @param Array $data
       * @return void
       **/
      public function updateSaldoAwalBarang($id_saldo, $id_transaksi, $jenis, $data)
      {
            Saldo_awal_barang::where('id_saldo', $id_saldo)
                  ->update([
                        'id_transaksi' => $id_transaksi,
                        'posisi' => $jenis,
                        'id_barang' => $data['id_barang'],
                        'qty' => $data['qty'],
                        'harga' => $data['harga'],
                        'nilai_buku' => $data['nilai_buku'] ?? null,
                        'subtotal' => $data['subtotal']
                  ]);
      }

      /**
       * Dokumentasi update transaksi saldo awal barang
       *
       * Merangkum fungsi-fungsi untuk mengupdate
       * transaksi saldo awal barang
       *
       * @param mixed $request
       * @param int $id
       * @param mixed $jenis
       * @param mixed $unit
       * @return void
       **/
      public function update($request, $id, $jenis, $unit)
      {
            $data = json_decode($request->input('data_barang'), true);
            self::updateTransaksi($id, $request->input('total_transaksi'));
            self::updateDetail($data, $id, $jenis, $unit);
            $this->accountingService->updateJurnalSaldoAwalBarang($data, $id, $jenis);
      }

      /**
       * Dokumentasi updateTransaksi
       *
       * Mengupdate total transaksi saldo awal barang
       * dan waktu updatenya berdasarkan id transaksi 
       * kedalam tabel transaksi 
       *
       * @param int $id
       * @param mixed $total
       * @return void
       **/
      function updateTransaksi($id, $total)
      {
            $update_transaksi = [
                  'total' => convertToNumber($total),
                  'updated_at' => now()
            ];
            Transaksi::where('id_transaksi', $id)->update($update_transaksi);
      }

      /**
       *Update detail transaksi saldo awal barang
       *
       * Mengupdate data detail ke dalam 
       * tabel saldo_awal_barang & kedalam tabel barang
       *
       * @param mixed $data
       * @param int $id
       * @param mixed $jenis
       * @param mixed $unit
       * @return void
       **/
      public function updateDetail($data, $id, $jenis, $unit)
      {
            $model = new Barang;
            $modelSaldo = new Saldo_awal_barang;
            $transaksi = $this->transaksiService->saldoAwalBarang($unit, $jenis);
            foreach ($transaksi as $t) {
                  self::updateStokBarangSementara($model, $modelSaldo, $t->id_saldo, $t->id_barang);
            }
            foreach ($data as $d) {
                  $id_saldo = self::getIdSaldo($id, $d['id_barang']);
                  if ($id_saldo) {
                        $this->barangService->updatePengadaanBarang($model, $d);
                        $this->updateSaldoAwalBarang($id_saldo, $id, $jenis, $d);
                  } else {
                        self::createDetail($d, $id, $jenis);
                  }
            }
      }

      /**
       * Update stok barang sementara berdasarkan 
       * data saldo awal barang
       *
       * @param mixed $model
       * @param mixed $modelSaldo
       * @param mixed $id_saldo
       * @param mixed $id_barang
       * @return void
       **/
      public function updateStokBarangSementara($model, $modelSaldo, $id_saldo, $id_barang)
      {
            $stokSaldo = $modelSaldo::where('id_saldo', $id_saldo)->value('qty');
            $stokBarang = $model::where('id_barang', $id_barang)->value('stok');
            $stok = $stokBarang - $stokSaldo;
            $model::where('id_barang', $id_barang)->update([
                  'stok' => $stok,
                  'harga_barang' => 0,
                  'nilai_saat_ini' => 0,
            ]);
            $modelSaldo::where('id_saldo', $id_saldo)->update([
                  'qty' => 0,
                  'harga' => 0,
                  'nilai_buku' => 0,
                  'subtotal' => 0,
            ]);
      }

      /**
       *Dokumentasi getIdSaldo
       *
       * Mengambil id_saldo dari tabel saldo_awal_barang 
       * yang dijadikan parameter untuk mengupdate 
       * saldo awal barang
       *
       * @param mixed $id
       * @param mixed $id_barang
       * @return mixed
       **/
      public function getIdSaldo($id, $id_barang)
      {
            return Saldo_awal_barang::where('id_transaksi', $id)->where('id_barang', $id_barang)->value('id_saldo');
      }
}
