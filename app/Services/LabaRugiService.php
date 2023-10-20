<?php

namespace App\Services;

use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;
use App\Services\AccountingService;

class LabaRugiService
{
      private $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }

      /**
       * undocumented function summary
       *
       **/
      public function getLaporan($unit, $bulan, $tahun)
      {
            if ($unit === 'Pertokoan') {
                  $laporan = self::getRekapPertokoan($bulan, $tahun, $unit);
            }
            if ($unit === 'Simpan Pinjam') {
                  $laporan = self::getRekapSimpanPinjam($unit, $bulan, $tahun);
            }
            return $laporan;
      }

      /**
       * undocumented function summary
       *
       **/
      public function getRekapPertokoan($bulan, $tahun, $unit)
      {
            $penjualanBarang = $this->accountingService->getPerulangan($bulan, $tahun, 8, $unit, true, 'subkategori', "%Penjualan Barang%");
            $persediaanAwal = $this->getSaldoPersediaan($bulan, $tahun, $unit, 'persediaan');
            $pengadaanTahunBerjalan = $this->getSaldoPersediaan($bulan, $tahun, $unit, 'pengadaan');
            $persediaanAkhir = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'subkategori', "%Persediaan%");
            $pendapatanLainBulanIni = $this->accountingService->getSaldo($bulan, $tahun, 8, $unit, false, 'subkategori', "%Pendapatan%");
            $pendapatanLainBulanSebelum = $this->getPendapatanBulanSebelum($bulan, $tahun, $unit, 'subkategori', "%Pendapatan%");
            $biaya = $this->accountingService->getPerulangan($bulan, $tahun, 4, $unit, true, 'subkategori', "%Biaya Langsung%");

            $totalPenjualan = 0;
            foreach ($penjualanBarang as $penjualanItem) {
                  $totalPenjualan += $penjualanItem->total_saldo;
            }

            $totalBiaya = 0;
            foreach ($biaya as $biayaItem) {
                  $totalBiaya += $biayaItem->total_saldo;
            }

            $persediaanSiapJual = $persediaanAwal + $pengadaanTahunBerjalan;
            $hpp = $persediaanSiapJual - $persediaanAkhir;
            $labaKotor = $totalPenjualan - $hpp;
            $totalPendapatan = $labaKotor + ($pendapatanLainBulanSebelum ?? 0) + $pendapatanLainBulanIni;
            $shu = $totalPendapatan - $totalBiaya;

            return [
                  'penjualanBarang' => $penjualanBarang,
                  'persediaanAwal' => $persediaanAwal,
                  'pengadaanTahunBerjalan' => $pengadaanTahunBerjalan,
                  'persediaanAkhir' => $persediaanAkhir,
                  'pendapatanLainBulanIni' => $pendapatanLainBulanIni,
                  'pendapatanLainBulanSebelum' => $pendapatanLainBulanSebelum,
                  'biaya' => $biaya,
                  'totalPenjualan' => $totalPenjualan,
                  'totalBiaya' => $totalBiaya,
                  'persediaanSiapJual' => $persediaanSiapJual,
                  'hpp' => $hpp,
                  'labaKotor' => $labaKotor,
                  'totalPendapatan' => $totalPendapatan,
                  'shu' => $shu,
            ];
      }

      /**
       * undocumented function summary
       *
       **/
      public function getRekapSimpanPinjam($unit, $bulan, $tahun)
      {
            $pendapatanBungaBulanIni = $this->accountingService->getSaldo($bulan, $tahun, 8, $unit, false, 'subkategori', "%Pendapatan Bunga%");
            $pendapatanBungaBulanSebelum = $this->getPendapatanBulanSebelum($bulan, $tahun, $unit, 'subkategori', "%Pendapatan Bunga%");
            $pendapatanLainnya = $this->accountingService->getSaldo($bulan, $tahun, 8, $unit, true, 'subkategori', "%Pendapatan Lainnya%");
            $biaya = $this->accountingService->getPerulangan($bulan, $tahun, 4, $unit, true, 'subkategori', "%Biaya Langsung%");

            $jumlahPendapatanBunga = $pendapatanBungaBulanIni + ($pendapatanBungaBulanSebelum ?? 0);
            $totalPendapatan = $jumlahPendapatanBunga + $pendapatanLainnya;

            $totalBiaya = 0;
            foreach ($biaya as $biayaItem) {
                  $totalBiaya += $biayaItem->total_saldo;
            }

            $shu = $totalPendapatan - $totalBiaya;

            return [
                  'pendapatanBungaBulanIni' => $pendapatanBungaBulanIni,
                  'pendapatanBungaBulanSebelum' => $pendapatanBungaBulanSebelum,
                  'pendapatanLainnya' => $pendapatanLainnya,
                  'biaya' => $biaya,
                  'jumlahPendapatanBunga' => $jumlahPendapatanBunga,
                  'totalPendapatan' => $totalPendapatan,
                  'totalBiaya' => $totalBiaya,
                  'shu' => $shu,
            ];
      }

      public function getPendapatanBulanSebelum($bulan, $tahun, $unit, $colum, $columValue)
      {
            if ($bulan > 1) {
                  $bulanSebelumnya = $bulan - 1;
                  return $this->accountingService->getSaldo($bulanSebelumnya, $tahun, 8, $unit, true, $colum, $columValue);
            } else {
                  return null;
            }
      }

      public function getSaldoPersediaan($bulan, $tahun, $unit, $type)
      {
            $nominal = DB::raw('(SUM(IF(posisi_dr_cr = "debet", nominal, 0)) - SUM(IF(posisi_dr_cr = "kredit", nominal, 0))) as total_saldo');
            $saldo = Jurnal::with(['coa', 'transaksi'])
                  ->select('coa.header', $nominal)
                  ->join('coa', 'jurnal.id_coa', '=', 'coa.id_coa')
                  ->whereHas('transaksi', function ($query) use ($bulan, $tahun, $unit, $type) {
                        $query->where('unit', $unit);
                        if ($type === 'persediaan') {
                              $query->whereYear('tgl_transaksi', '<', $tahun);
                        } else {
                              $query->where(function ($query) use ($tahun, $bulan) {
                                    $query->where('jenis_transaksi', 'Saldo Awal persediaan')
                                          ->whereYear('tgl_transaksi', $tahun)
                                          ->whereMonth('tgl_transaksi', '<=', $bulan);
                              })->orWhere(function ($query) use ($tahun, $bulan) {
                                    $query->where('jenis_transaksi', 'Pengadaan Barang')
                                          ->where('detail_tabel', 'detail_belanja_persediaan')
                                          ->whereYear('tgl_transaksi', $tahun)
                                          ->whereMonth('tgl_transaksi', '<=', $bulan);
                              });
                        }
                  })
                  ->whereHas('coa', function ($query) {
                        $query->where('header', 1)
                              ->where('subkategori', 'Persediaan');
                  })
                  ->groupBy('coa.header')
                  ->get();
            $saldoGet = $saldo->value('total_saldo');
            return $saldoGet;
      }
}
