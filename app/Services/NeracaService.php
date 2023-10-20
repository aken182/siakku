<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Services\LabaRugiService;
use Illuminate\Support\Facades\DB;
use App\Services\AccountingService;

class NeracaService
{
      private $accountingService;
      private $labaRugiService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
            $this->labaRugiService = new LabaRugiService;
      }

      /**
       * undocumented function summary
       *
       **/
      public function getRekap($unit, $bulan, $tahun)
      {
            $aktivaLancar = $this->accountingService->getPerulangan($bulan, $tahun, 1, $unit, true, 'kategori', "%Aktiva Lancar%");
            $aktivaTetap = $this->accountingService->getPerulangan($bulan, $tahun, 1, $unit, true, 'kategori', "%Aktiva Tetap%");
            $penyusutan = $this->accountingService->getPerulangan($bulan, $tahun, 1, $unit, true, 'kategori', "%Depresiasi dan Amortisasi%");
            $penyertaan = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'kategori', "%Penyertaan%");
            $passivaLancar = $this->accountingService->getPerulangan($bulan, $tahun, 2, $unit, true, 'kategori', "%Passiva Lancar%");
            $modal = $this->getModalSendiri($unit, $bulan, $tahun);
            $totalAktivaLancar = $this->getTotalPerulangan($aktivaLancar);
            $totalAktivaTetap = $this->getTotalPerulangan($aktivaTetap);
            $totalPenyusutan = $this->getTotalPerulangan($penyusutan);
            $totalPassivaLancar = $this->getTotalPerulangan($passivaLancar);
            $totalAktiva = $totalAktivaLancar + $totalAktivaTetap + $totalPenyusutan + $penyertaan;
            $totalPassiva = $totalPassivaLancar + $modal['totalModalSendiri'];

            return [
                  'aktivaLancar' => $aktivaLancar,
                  'aktivaTetap' => $aktivaTetap,
                  'penyusutan' => $penyusutan,
                  'penyertaan' => $penyertaan,
                  'passivaLancar' => $passivaLancar,
                  'modalSendiri' => $modal['modalSendiri'],
                  'totalAktivaLancar' => $totalAktivaLancar,
                  'totalAktivaTetap' => $totalAktivaTetap,
                  'totalPenyusutan' => $totalPenyusutan,
                  'totalPassivaLancar' => $totalPassivaLancar,
                  'totalModalSendiri' => $modal['totalModalSendiri'],
                  'totalAktiva' => $totalAktiva,
                  'totalPassiva' => $totalPassiva
            ];
      }

      /**
       * undocumented function summary
       *
       **/
      public function getModalSendiri($unit, $bulan, $tahun)
      {
            $modal = $this->getModalData($unit, $bulan, $tahun);

            $modalSendiri = $this->processModalData($unit, $bulan, $tahun, $modal);

            return [
                  'modalSendiri' => $modalSendiri,
                  'totalModalSendiri' => array_sum(array_column($modalSendiri, 'total_saldo')),
            ];
      }

      private function getModalData($unit, $bulan, $tahun)
      {
            $modal = $this->accountingService->getPerulangan($bulan, $tahun, 2, $unit, true, 'kategori', "%Modal Sendiri");
            $asuransi = $this->accountingService->getSaldoKodeNama($bulan, $tahun, 4, $unit, true, 'nama', "%Asuransi%", 'subkategori', "%Biaya Tidak Langsung");

            if ($unit === 'Pertokoan') {
                  $getShu = $this->labaRugiService->getRekapPertokoan($bulan, $tahun, $unit);
            } else {
                  $getShu = $this->labaRugiService->getRekapSimpanPinjam($unit, $bulan, $tahun);
            }

            $shu = $getShu['shu'];
            $namaBulan = bulan_indonesia($bulan);

            $modalData = [
                  'modal' => $modal,
                  'asuransi' => $asuransi,
                  'shu' => $shu,
                  'namaBulan' => $namaBulan,
            ];

            return $modalData;
      }

      private function processModalData($unit, $bulan, $tahun, $modalData)
      {
            $modalSendiri = [];

            foreach ($modalData['modal'] as $item) {
                  if ($item->kode === '204') {
                        continue;
                  }

                  $modalSendiri[] = [
                        'kode' => $item->kode,
                        'nama' => $item->nama,
                        'total_saldo' => $item->total_saldo,
                  ];
            }

            $transaksiShu = $this->getTransaksiShu($unit, $bulan, $tahun);
            $saldoShu = $this->getSaldoShu($unit, $tahun, $bulan);

            if ($transaksiShu === false || $saldoShu == 0) {
                  $modalSendiri[] = [
                        'kode' => '204',
                        'nama' => "SHU Per " . $modalData['namaBulan'] . " " . $tahun,
                        'total_saldo' => $modalData['shu'],
                  ];
            }

            $modalSendiri[] = [
                  'kode' => $modalData['asuransi']->value('kode'),
                  'nama' => $modalData['asuransi']->value('nama'),
                  'total_saldo' => -1 * $modalData['asuransi']->value('total_saldo'),
            ];

            usort($modalSendiri, function ($a, $b) {
                  return strnatcmp($a['kode'], $b['kode']);
            });
            return $modalSendiri;
      }

      public function getTransaksiShu($unit, $bulan, $tahun)
      {
            $hari = getHariNow($bulan, $tahun);

            $transaksi = Transaksi::where('jenis_transaksi', 'Pembagian SHU')
                  ->where(function ($query) use ($tahun, $bulan, $hari) {
                        $query->whereDate('tgl_transaksi', '>=', "$tahun-01-01")
                              ->whereDate('tgl_transaksi', '<=', "$tahun-$bulan-$hari");
                        // ->where('tahun_buku', $tahun);
                  })
                  ->where('unit', $unit)
                  ->get();
            return !$transaksi->isEmpty();
      }

      public function getTotalPerulangan($data)
      {
            $total = 0;
            foreach ($data as $item) {
                  $total += $item->total_saldo;
            }
            return $total;
      }

      public function getSaldoShu($unit, $tahun, $bulan)
      {
            $hari = getHariNow($bulan, $tahun);
            $saldo = Jurnal::with(['coa', 'transaksi'])
                  ->select('coa.nama', DB::raw('(SUM(IF(posisi_dr_cr = "kredit", nominal, 0)) - SUM(IF(posisi_dr_cr = "debet", nominal, 0))) as total_saldo'))
                  ->join('coa', 'jurnal.id_coa', '=', 'coa.id_coa')
                  ->whereHas('transaksi', function ($query) use ($unit, $tahun, $bulan, $hari) {
                        $query->where('unit', $unit)
                              ->whereDate('tgl_transaksi', '>=', "$tahun-01-01")
                              ->whereDate('tgl_transaksi', '<=', "$tahun-$bulan-$hari");
                  })
                  ->whereHas('coa', function ($query) {
                        $query->where('header', 2)
                              ->where('nama', 'SHU')
                              ->where('subkategori', 'Dana SHU');
                  })
                  ->groupBy('coa.nama')
                  ->first();
            $saldoGet = $saldo->total_saldo ?? 0;
            // dd($saldoGet);
            return $saldoGet;
      }
}
