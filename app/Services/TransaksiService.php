<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Services\ImageService;
use App\Models\Detail_saldo_awal;
use App\Models\Saldo_awal_barang;

class TransaksiService
{
      private $imageService;
      public function __construct()
      {
            $this->imageService = new ImageService;
      }

      public function getHistoryTransaction($route = null, $unit = null)
      {
            switch ($route) {
                  case 'sltk-coa':
                  case 'slsp-coa':
                        $data = self::saldoAwal($unit);
                        break;
                  case 'sltk-persediaan':
                        $data = self::saldoAwalBarang($unit, 'persediaan');
                        break;
                  case 'sltk-inventaris':
                  case 'slsp-inventaris':
                        $data = self::saldoAwalBarang($unit, 'inventaris');
                        break;
                  case 'transfer-toko.list':
                  case 'transfer-sp.list':
                        $data = self::transferSaldoKasBank($unit);
                        break;
                  case 'ptk-penjualan.list':
                        $penjualan = new PenjualanService;
                        $data = $penjualan->getDataPenjualan($unit, $route);
                        break;
                  default:
                        $data = 'kosong';
                        break;
            }
            return $data;
      }

      /**
       * Dokumentasi saldoAwal
       *
       * Mengambil data transaksi saldo awal COA berdasarkan
       * unit.
       *
       * @param mixed $unit
       * 
       * @return \Illuminate\Database\Eloquent\Collection<array-key, 
       * \Illuminate\Database\Eloquent\Builder>
       **/
      public function saldoAwal($unit)
      {
            return Detail_saldo_awal::with(['coa', 'transaksi'])
                  ->join('coa', 'coa.id_coa', '=', 'detail_saldo_awal.id_coa')
                  ->orderBy('coa.kode', 'asc')
                  ->WhereHas('transaksi', function ($query) use ($unit) {
                        $query->where('unit', $unit);
                  })->get();
      }

      /**
       * Dokumentasi saldoAwalBarang
       *
       * Mengambil data transaksi saldo awal barang berdasarkan
       * unit dan posisi persediaan atau inventaris.
       *
       * @param mixed $unit
       * @param mixed $posisi
       * @return \Illuminate\Database\Eloquent\Collection<array-key, 
       * \Illuminate\Database\Eloquent\Builder>
       **/
      public function saldoAwalBarang($unit, $posisi)
      {
            return Saldo_awal_barang::with(['barang', 'transaksi', 'barang.satuan', 'barang.unit'])
                  ->where('posisi', $posisi)
                  ->WhereHas('transaksi', function ($query) use ($unit) {
                        $query->where('unit', $unit);
                  })->get();
      }

      /**
       * Dokumentasi getIdTransaksiCreate
       *
       * Mengambil id_transaksi baru berdasarkan
       * kode pada tabel transaksi yang baru diinput
       *
       * @param mixed $kode
       **/
      public function getIdTransaksiCreate($kode)
      {
            $transaksi = Transaksi::where('kode', $kode)->first();
            return $transaksi->id_transaksi;
      }

      /**
       * Dokumentasi getNomorTransaksi
       *
       * Mengambil nomor transaksi baru berdasarkan
       * prefix dari jenis transaksi pada tabel transaksi 
       *
       * @param mixed $prefix
       * @return string
       **/
      public function getNomorTransaksi($prefix)
      {
            $kode = kode(new Transaksi, $prefix, 'kode');
            return $kode;
      }

      public function addNotaTransaksi($file, $kode, $folder)
      {
            if ($file != null) {
                  $imageName = $this->imageService->getImageName('Nota', $kode, $file);
                  $this->imageService->uploadImage($file, $imageName, $folder);
                  return $imageName;
            }
      }

      /**
       * Dokumentasi getTransaksiSaldoAwalCoa
       *
       * Mencari dan mengambil data satu transaksi saldo awal 
       * yang pertama ditemukan pada model transaksi berdasarkan 
       * parameter unit dan jenis 
       *
       * @param mixed $unit
       * @param mixed $jenis
       * @return \Illuminate\Database\Eloquent\Collection<array-key, 
       * \Illuminate\Database\Eloquent\Builder>
       **/
      public function getTransaksiSaldoAwal($unit, $jenis = null)
      {
            if ($jenis == null) {
                  return Transaksi::where('jenis_transaksi', 'Saldo Awal COA')
                        ->where('unit', $unit)->first();
            } else {
                  return Transaksi::where('jenis_transaksi', 'Saldo Awal ' . $jenis)
                        ->where('unit', $unit)->first();
            }
      }


      /**
       * Dokumentasi transferSaldoKasBank
       *
       * Mengambil data transaksi transfer saldo kas
       * dan bank berdasarkan unit.
       *
       * @param mixed $unit
       * 
       * @return mixed
       **/
      public function transferSaldoKasBank($unit)
      {
            return Transaksi::where('detail_tabel', 'detail_transfer_saldo')
                  ->where('unit', $unit)->get();
      }
}
