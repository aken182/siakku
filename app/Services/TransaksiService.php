<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Detail_saldo_awal;
use App\Models\Saldo_awal_barang;

class TransaksiService
{
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
                  default:
                        $data = 'kosong';
                        break;
            }
            return $data;
      }

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
            return Saldo_awal_barang::with(['barang', 'transaksi', 'barang.satuan'])
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
                        ->where('unit', $unit)->latest()->first();
            } else {
                  return Transaksi::where('jenis_transaksi', 'Saldo Awal ' . $jenis)
                        ->where('unit', $unit)->latest()->first();
            }
      }
}
