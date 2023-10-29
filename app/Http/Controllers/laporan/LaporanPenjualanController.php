<?php

namespace App\Http\Controllers\laporan;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use App\Services\PenjualanService;
use App\Services\TransaksiService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LaporanPenjualanController extends Controller
{
      protected $penjualanService;
      protected $transaksiService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->penjualanService = new PenjualanService;
            $this->transaksiService = new TransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            // $penjualan = $this->getPenjualanPerBulan($other['bulan'], $other['tahun']);
            // dd($penjualan);
            $data = [
                  'unit' => $this->unit,
                  'title' => 'Laporan Penjualan Unit ' . $this->unit,
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Periode " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "bulan" => $other['bulan'],
                  "tahun" => $other['tahun'],
                  'penjualan' => $this->getPenjualanPerBulan($other['bulan'], $other['tahun']),
            ];

            return view('content.laporan.penjualan', $data);
      }

      private function getPenjualanPerBulan($bulan, $tahun)
      {
            $dataPenjualanLrtk = $this->getSaldoPenjualanPerTpk($bulan, $tahun, 'Larantuka', 'subkategori', 'Penjualan Barang', 8);
            $dataHppLrtk = $this->getSaldoPenjualanPerTpk($bulan, $tahun, 'Larantuka', 'subkategori', 'Persediaan', 1);
            $larantuka = $this->getDataPenjualanPerTpk($dataHppLrtk, $dataPenjualanLrtk);
            $dataPenjualanPsr = $this->getSaldoPenjualanPerTpk($bulan, $tahun, 'Pasar Baru', 'subkategori', 'Penjualan Barang', 8);
            $dataHppPsr = $this->getSaldoPenjualanPerTpk($bulan, $tahun, 'Pasar Baru', 'subkategori', 'Persediaan', 1);
            $pasarBaru = $this->getDataPenjualanPerTpk($dataHppPsr, $dataPenjualanPsr);
            $dataPenjualanWrg = $this->getSaldoPenjualanPerTpk($bulan, $tahun, 'Waiwerang', 'subkategori', 'Penjualan Barang', 8);
            $dataHppWrg = $this->getSaldoPenjualanPerTpk($bulan, $tahun, 'Waiwerang', 'subkategori', 'Persediaan', 1);
            $waiwerang = $this->getDataPenjualanPerTpk($dataHppWrg, $dataPenjualanWrg);
            $pnjLrtk = sumDataArray($larantuka, 'penjualan') ?? 0;
            $hppLrtk = sumDataArray($larantuka, 'hpp') ?? 0;
            $lrLrtk = sumDataArray($larantuka, 'laba_rugi') ?? 0;
            $pnjPsr = sumDataArray($pasarBaru, 'penjualan') ?? 0;
            $hppPsr = sumDataArray($pasarBaru, 'hpp') ?? 0;
            $lrPsr = sumDataArray($pasarBaru, 'laba_rugi') ?? 0;
            $pnjWrg = sumDataArray($waiwerang, 'penjualan') ?? 0;
            $hppWrg = sumDataArray($waiwerang, 'hpp') ?? 0;
            $lrWrg = sumDataArray($waiwerang, 'laba_rugi') ?? 0;
            $totalPenjualan = $pnjLrtk + $pnjPsr + $pnjWrg;
            $totalHpp = ($hppLrtk + $hppPsr + $hppWrg);
            $totalLabaRugi = $lrLrtk + $lrPsr + $lrWrg;

            return [
                  'larantuka' => $larantuka,
                  'pasarBaru' => $pasarBaru,
                  'waiwerang' => $waiwerang,
                  'pnjLrtk' => $pnjLrtk,
                  'pnjPsr' => $pnjPsr,
                  'pnjWrg' => $pnjWrg,
                  'hppLrtk' => $hppLrtk,
                  'hppPsr' => $hppPsr,
                  'hppWrg' => $hppWrg,
                  'lrLrtk' => $lrLrtk,
                  'lrPsr' => $lrPsr,
                  'lrWrg' => $lrWrg,
                  'totalPenjualan' => $totalPenjualan,
                  'totalHpp' => $totalHpp,
                  'totalLabaRugi' => $totalLabaRugi,
            ];
      }

      private function getDataPenjualanPerTpk($dataHpp, $dataPenjualan)
      {
            $data = [];
            $hpp = [];

            foreach ($dataHpp as $key) {
                  $hpp[] = [
                        'nama' => str_replace(['Persediaan Barang '], '', $key->nama),
                        'hpp' => $key->total_saldo
                  ];
            }

            foreach ($dataPenjualan as $key) {
                  $nama = str_replace(['Penjualan Barang '], '', $key->nama);
                  foreach ($hpp as $h) {
                        if ($h['nama'] === $nama) {
                              $data[] = [
                                    'nama' => $nama,
                                    'penjualan' => $key->total_saldo,
                                    'hpp' => $h['hpp'] * -1,
                                    'laba_rugi' => $h['hpp'] + $key->total_saldo
                              ];
                        }
                  }
            }
            return $data;
      }

      private function getSaldoPenjualanPerTpk($bulan, $tahun, $tpk, $kolom, $isiKolom, $header, $kolom2 = null, $isiKolom2 = null)
      {
            $hari = getHariNow($bulan, $tahun);
            $totalSaldoType = ($header != 1 && $header != 4) ? 'kredit' : 'debet';
            $getTotalFungsiRekap = $this->getWhereTransaksi($tahun, $bulan, $hari, $totalSaldoType, $tpk);
            $totalSaldo = $getTotalFungsiRekap['totalSaldo'];
            $fungsiA = $getTotalFungsiRekap['fungsiA'];
            $fungsi = getFungsiRekap($kolom, $isiKolom, $header, $kolom2, $isiKolom2);

            $perulangan = Jurnal::with(['coa', 'transaksi'])
                  ->select('coa.kode', 'coa.nama', 'jurnal.id_coa', $totalSaldo)
                  ->join('coa', 'jurnal.id_coa', '=', 'coa.id_coa')
                  ->whereHas('transaksi', $fungsiA)
                  ->whereHas('coa', $fungsi)
                  ->groupBy('jurnal.id_coa', 'coa.kode', 'coa.nama')
                  ->get();
            $collection = collect($perulangan);
            $unique = $collection->unique('id_coa');
            $perulangans = $unique->values()->all();
            return $perulangans;
      }

      private function getWhereTransaksi($tahun, $bulan, $hari, $totalSaldoType, $tpk)
      {
            $unit = $this->unit;
            $totalSaldo = ($totalSaldoType === "kredit")
                  ? DB::raw('(SUM(IF(posisi_dr_cr = "kredit", nominal, 0)) - SUM(IF(posisi_dr_cr = "debet", nominal, 0))) as total_saldo')
                  : DB::raw('(SUM(IF(posisi_dr_cr = "debet", nominal, 0)) - SUM(IF(posisi_dr_cr = "kredit", nominal, 0))) as total_saldo');

            $fungsiA = function ($query) use ($tahun, $bulan, $hari, $unit, $tpk) {
                  $query->where('jenis_transaksi', 'Penjualan Barang')
                        ->whereDate('tgl_transaksi', '>=', "$tahun-$bulan-01")
                        ->whereDate('tgl_transaksi', '<=', "$tahun-$bulan-$hari")
                        ->where('tpk', $tpk)
                        ->where('unit', $unit);
            };

            $data = [
                  'totalSaldo' => $totalSaldo,
                  'fungsiA' => $fungsiA,
            ];

            return $data;
      }
}
