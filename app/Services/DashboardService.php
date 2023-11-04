<?php

namespace App\Services;

use App\Models\Anggota;
use App\Models\Transaksi;
use App\Services\LabaRugiService;
use Illuminate\Support\Facades\DB;

class DashboardService
{
      private $labaRugiService;
      private $accountingService;

      public function __construct()
      {
            $this->labaRugiService = new LabaRugiService;
            $this->accountingService = new AccountingService;
      }

      public function getShu($unit, $bulan, $tahun)
      {
            $getShu = $unit === 'Pertokoan'
                  ? $this->labaRugiService->getRekapPertokoan($bulan, $tahun, $unit)
                  : $this->labaRugiService->getRekapSimpanPinjam($unit, $bulan, $tahun);

            return $getShu['shu'];
      }

      public function getGrafikLabaRugi($unit, $bulan, $tahun)
      {
            $saldo = [];
            $bulanArray = [];

            $bln = 1;
            $awal = Transaksi::where('jenis_transaksi', 'Saldo Awal COA')
                  ->where('unit', $unit)
                  ->first();

            if ($awal) {
                  $bulanAwal = date('m', strtotime($awal->tgl_transaksi));
                  $tahunAwal = date('Y', strtotime($awal->tgl_transaksi));

                  if ($tahunAwal == $tahun) {
                        $bln = ($bulanAwal == 12) ? 1 : $bulanAwal + 1;
                  }
            }

            for ($i = $bln; $i <= $bulan; $i++) {
                  $saldo[] = $this->getShu($unit, $i, $tahun);
                  $bulanArray[] = singkatanBulan($i);
            }

            return [
                  'saldo' => $saldo,
                  'bulan' => $bulanArray,
            ];
      }

      public function countAnggotaByGender()
      {
            $counts = Anggota::select('jenis_kelamin', DB::raw('count(*) as total'))
                  ->where('status', 'Aktif')
                  ->groupBy('jenis_kelamin')
                  ->get();

            return $counts;
      }

      public function getAnggotaToDashboard()
      {
            $counts = $this->countAnggotaByGender();
            $lakiLaki = 0;
            $perempuan = 0;
            foreach ($counts as $count) {
                  if ($count->jenis_kelamin == 'Laki-laki') {
                        $lakiLaki += $count->total;
                  }
                  if ($count->jenis_kelamin == 'Perempuan') {
                        $perempuan += $count->total;
                  }
            }
            return [$lakiLaki, $perempuan];
      }

      public function grafikPersediaan($unit, $bulan, $tahun)
      {
            $konsumsi = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'nama', "%Persediaan Barang Konsumsi%") ?? 0;
            $sandang = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'nama', "%Persediaan Barang Sandang%") ?? 0;
            $kosmetik = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'nama', "%Persediaan Barang Kosmetik%") ?? 0;
            $atm = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'nama', "%Persediaan Barang ATM%") ?? 0;
            $elektronik = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'nama', "%Persediaan Barang Elektronik%") ?? 0;
            $bangunan = $this->accountingService->getSaldo($bulan, $tahun, 1, $unit, true, 'nama', "%Persediaan Barang Bangunan%") ?? 0;

            $saldo = [$konsumsi, $sandang, $kosmetik, $atm, $elektronik, $bangunan];
            $nama = ['konsumsi', 'sandang', 'kosmetik', 'atm', 'elektronik', 'bangunan'];

            return [
                  'saldo' => $saldo,
                  'nama' => $nama,
            ];
      }

      public function getSeparatedGrafikSimpananSp($bulan, $tahun)
      {
            $data = $this->accountingService->getPerulangan($bulan, $tahun, 2, 'Simpan Pinjam', true, 'subkategori', "%Simpanan%");
            $keys = [];
            $values = [];

            foreach ($data as $key) {
                  $keys[] = $key['nama'];
                  $values[] = $key['total_saldo'];
            }

            $result = [
                  'keys' => $keys,
                  'values' => $values,
            ];

            return $result;
      }
}
