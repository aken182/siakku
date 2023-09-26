<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Services\ImageService;
use App\Models\Detail_saldo_awal;
use App\Models\Main_belanja;
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
                  case 'ptk-pendapatan.list':
                  case 'pendapatan-unit-sp.list':
                        $data = self::getPendapatan($unit);
                        break;
                  case 'btk-belanja-barang.list':
                  case 'bsp-belanja-barang.list':
                        $data = self::getPengadaanBarang($unit);
                        break;
                  case 'btk-belanja-lain.list':
                  case 'bsp-belanja-lain.list':
                        $data = self::getBelanja($unit);
                        break;
                  case 'stk-simpanan.list':
                  case 'sp-simpanan.list':
                        $data = self::getSimpanan($unit);
                        break;
                  case 'stk-penarikan.list':
                  case 'sp-penarikan.list':
                        $data = self::getPenarikanSimpanan($unit);
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

      /**
       * Upload file nota transaksi dan ambil image
       *
       **/
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

      /**
       * Dokumentasi getPendapatan
       *
       * Mengambil data transaksi pendapatan
       * berdasarkan unit.
       *
       * @param mixed $unit
       * @return mixed
       **/
      public function getPendapatan($unit)
      {
            return Transaksi::where('detail_tabel', 'detail_pendapatan')
                  ->where('unit', $unit)->get();
      }

      /**
       * Dokumentasi getPengadaanBarang
       *
       * Mengambil data transaksi pengadaan
       * barang berdasarkan unit.
       *
       **/
      public function getPengadaanBarang($unit)
      {
            $pengadaan = Transaksi::where('jenis_transaksi', 'Pengadaan Barang')
                  ->where('unit', $unit)->get();
            $result = self::getDataBelanja($pengadaan);
            return $result;
      }

      /**
       * Mengambil data transaksi simpanan
       * berdasarkan unit.
       *
       **/
      public function getSimpanan($unit)
      {
            $simpanan = Transaksi::where('detail_tabel', 'detail_simpanan')
                  ->where('unit', $unit)->get();
            return $simpanan;
      }

      /**
       * Mengambil data transaksi penarikan
       * simpanan berdasarkan unit.
       *
       **/
      public function getPenarikanSimpanan($unit)
      {
            $penarikan = Transaksi::where('detail_tabel', 'detail_penarikan')
                  ->where('unit', $unit)->get();
            return $penarikan;
      }

      /**
       * Mengambil data transaksi belanja
       * berdasarkan unit.
       *
       **/
      public function getBelanja($unit)
      {
            $belanja = Transaksi::where('jenis_transaksi', 'Belanja')
                  ->where('unit', $unit)->get();
            $result = self::getDataBelanja($belanja);
            return $result;
      }

      /**
       * Mengambil data transaksi pengadaan
       * barang atau belanja dalam bentuk array.
       *
       **/
      public function getDataBelanja($belanja)
      {
            $result = [];
            if ($belanja) {
                  foreach ($belanja as $p) {
                        $status = Main_belanja::where('id_transaksi', $p->id_transaksi)->value('status_belanja');
                        $result[] = [
                              'id_transaksi' => $p->id_transaksi,
                              'detail_tabel' => $p->detail_tabel,
                              'jenis_transaksi' => $p->jenis_transaksi,
                              'kode' => $p->kode,
                              'tipe' => $p->tipe,
                              'tgl_transaksi' => $p->tgl_transaksi,
                              'keterangan' => $p->keterangan,
                              'total' => $p->total,
                              'status' => $status
                        ];
                  }
            }
            return $result;
      }
      /**
       * Mengambil kode penyesuaian 
       * berdasarkan data request.
       *
       **/
      public function getKodePenyesuaian($tipe, $id_penyesuaian)
      {
            $invoicePny = null;
            if ($tipe === 'penyesuaian') {
                  $transaksiPenyesuaian = Transaksi::where('id_transaksi', $id_penyesuaian)->first();
                  $invoicePny = $transaksiPenyesuaian->kode;
            }
            return $invoicePny;
      }
}
