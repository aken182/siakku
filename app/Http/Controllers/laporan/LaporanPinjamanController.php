<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\PinjamanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasan_pinjaman;
use App\Models\Main_pinjaman;
use Illuminate\Support\Facades\Route;

class LaporanPinjamanController extends Controller
{
      protected $pinjamanService;
      protected $transaksiService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->pinjamanService = new PinjamanService;
            $this->transaksiService = new TransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $bulanLalu = ($other['bulan'] > 1) ? $other['bulan'] - 1 : null;
            $id_pinjaman = $request->input('id_pinjaman') ?? '';
            $data = [
                  'unit' => $this->unit,
                  'title' => 'Laporan Pinjaman',
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  'pinjaman' => $this->pinjamanService->getDataPinjamanAnggota(),
                  'dataAnggota' => $this->getDataAnggota($id_pinjaman),
                  "hari" => $other['hari'],
                  "bulan" => $other['bulan'],
                  "tahunLalu" => $other['tahun'] - 1,
                  "tahun" => $other['tahun'],
                  "namaBulanIni" => $other['nama_bulan'],
                  "namaBulanLalu" => bulan_indonesia($bulanLalu),
                  'lp' => $this->getDataMainPinjaman($id_pinjaman, $other['tahun'])
            ];

            return view('content.laporan.pinjaman', $data);
      }

      private function getParentPinjaman($id_pinjaman, $jenis, $tahun = null)
      {
            $transaksi = $this->getWhereTransaksi($jenis, $tahun);
            return  Main_pinjaman::with(['anggota', 'transaksi'])
                  ->where('id_pinjaman', $id_pinjaman)
                  ->whereHas('transaksi', $transaksi)
                  ->first();
      }

      private function getChildPinjaman($id_pinjaman, $jenis_angsuran, $jenis, $tahun = null, $saldoAwal = true)
      {
            $transaksi = $this->getWhereTransaksi($jenis, $tahun);
            $jenisData = $saldoAwal === true ? 'saldo awal' : 'data angsuran';
            $transaksi2 = $this->getWhereTransaksi($jenisData, $tahun);
            return Detail_pelunasan_pinjaman::with(['transaksi', 'main_pinjaman', 'main_pinjaman.transaksi', 'main_pinjaman.anggota'])
                  ->where('id_pinjaman', $id_pinjaman)
                  ->where('jenis_angsuran', $jenis_angsuran)
                  ->whereHas('main_pinjaman', function ($query) use ($transaksi2) {
                        $query->whereHas('transaksi', $transaksi2);
                  })
                  ->whereHas('transaksi', $transaksi)->get();
      }

      private function getWhereTransaksi($jenis, $tahun)
      {
            $transaksi = function ($query) {
                  $query->where('unit', 'Simpan Pinjam')
                        ->whereNot('tipe', 'kadaluwarsa');
            };

            if ($jenis === 'saldo awal') {
                  $transaksi = function ($query) use ($tahun) {
                        $query->where('unit', 'Simpan Pinjam')
                              ->whereNot('tipe', 'kadaluwarsa')
                              ->whereDate('tgl_transaksi', '<', "$tahun-01-01");
                  };
            }

            if ($jenis === 'tahun ini') {
                  $transaksi = function ($query) use ($tahun) {
                        $query->where('unit', 'Simpan Pinjam')
                              ->whereNot('tipe', 'kadaluwarsa')
                              ->whereYear('tgl_transaksi', $tahun);
                  };
            }

            return $transaksi;
      }

      private function getDataAnggota($id_pinjaman)
      {
            $pinjaman = $this->getParentPinjaman($id_pinjaman, 'data anggota');
            if ($pinjaman) {
                  return [
                        'nama' => $pinjaman->anggota->nama,
                        'kode' => $pinjaman->anggota->kode,
                        'alamat' => $pinjaman->anggota->tempat_tugas,
                        'tgl_pinjam' => $pinjaman->transaksi->tgl_transaksi,
                        'total_pinjaman' => $pinjaman->total_pinjaman,
                  ];
            }
            return null;
      }

      private function getDataMainPinjaman($id_pinjaman, $tahun)
      {
            $saldoAwal = $this->getSaldoAwal($id_pinjaman, $tahun);
            $data = $this->getDataPinjaman($id_pinjaman, $tahun, $saldoAwal);
            return [
                  'saldoAwalPokok' => $saldoAwal['pokok'],
                  'saldoAwalBunga' => $saldoAwal['bunga'],
                  'utama' => $data['utama'],
                  'saldoAkhirPokok' => $data['saldoAkhirPokok'],
                  'saldoAkhirBunga' => $data['saldoAkhirBunga'],
            ];
      }

      private function getSaldoAwal($id_pinjaman, $tahun)
      {
            $dataPinjaman = $this->getParentPinjaman($id_pinjaman, 'saldo awal', $tahun);
            $angsuran = $this->getChildPinjaman($id_pinjaman, 'biasa', 'saldo awal', $tahun);
            $angsuranBunga = $this->getChildPinjaman($id_pinjaman, 'biasa', 'angsuran bunga', $tahun);
            $pinjamTindis = $this->getChildPinjaman($id_pinjaman, 'pinjam tindis', 'saldo awal', $tahun);

            $totalPinjaman = $dataPinjaman->total_pinjaman ?? 0;
            $saldoBunga = $dataPinjaman->saldo_bunga ?? 0;
            $pokok = $angsuran->sum('angsuran_pokok');
            $tindis = $pinjamTindis->sum('besar_pinjaman');
            $bunga = $angsuran->sum('angsuran_bunga');
            $bungaSemua = $angsuranBunga->sum('angsuran_bunga');

            $pokokFix = ($totalPinjaman + $tindis) - $pokok;
            $bungaFix = ($saldoBunga + $bungaSemua) - $bunga;
            return [
                  'pokok' => $pokokFix,
                  'bunga' => $bungaFix,
            ];
      }

      private function getDataPinjaman($id_pinjaman, $tahun, $saldoAwal)
      {
            $dataPinjaman = [];
            $dataAngsuran = [];
            $pinjaman = $this->getParentPinjaman($id_pinjaman, 'tahun ini', $tahun);
            if ($pinjaman) {
                  $angsuranBunga = $this->getChildPinjaman($id_pinjaman, 'biasa', 'angsuran bunga', $tahun, false);
                  $bunga = $angsuranBunga->sum('angsuran_bunga');
                  $dataPinjaman[] = [
                        'tgl_transaksi' => $pinjaman->transaksi->tgl_transaksi,
                        'no_bukti' => $pinjaman->transaksi->no_bukti,
                        'jenis' => 'main',
                        'besar_pinjaman' => $pinjaman->total_pinjaman,
                        'angsuran_pokok' => 0,
                        'angsuran_bunga' => 0,
                  ];
            }
            $angsuran = $this->getChildPinjaman($id_pinjaman, 'biasa', 'tahun ini', $tahun, false);
            foreach ($angsuran as $a) {
                  $dataAngsuran[] = [
                        'tgl_transaksi' => $a->transaksi->tgl_transaksi,
                        'no_bukti' => $a->transaksi->no_bukti,
                        'jenis' => 'angsuran',
                        'besar_pinjaman' => 0,
                        'angsuran_pokok' => $a->angsuran_pokok,
                        'angsuran_bunga' => $a->angsuran_bunga,
                  ];
            }
            $tindis = $this->getChildPinjaman($id_pinjaman, 'pinjam tindis', 'tahun ini', $tahun, false);
            foreach ($tindis as $t) {
                  $dataAngsuran[] = [
                        'tgl_transaksi' => $t->transaksi->tgl_transaksi,
                        'no_bukti' => $t->transaksi->no_bukti,
                        'jenis' => 'pinjam tindis',
                        'besar_pinjaman' => $t->besar_pinjaman,
                        'angsuran_pokok' => 0,
                        'angsuran_bunga' => 0,
                  ];
            }
            usort($dataAngsuran, function ($a, $b) {
                  return $a['tgl_transaksi'] <=> $b['tgl_transaksi'];
            });

            $saldo_pokok = 0;
            $saldo_bunga = 0;
            if ($pinjaman) {
                  $saldo_pokok += $pinjaman->total_pinjaman;
                  $saldo_bunga += $pinjaman->saldo_bunga + $bunga;
                  $dataUtama = array_merge($dataPinjaman, $dataAngsuran);
            } else {
                  $saldo_pokok += $saldoAwal['pokok'];
                  $saldo_bunga += $saldoAwal['bunga'];
                  $dataUtama = $dataAngsuran;
            }

            foreach ($dataUtama as &$key) { //menggunakan &$key untuk mengakses array asli
                  if ($key['jenis'] === 'angsuran') {
                        $saldo_pokok -= $key['angsuran_pokok'];
                        $saldo_bunga -= $key['angsuran_bunga'];
                  }
                  if ($key['jenis'] === 'pinjam tindis') {
                        $saldo_pokok += $key['besar_pinjaman'];
                  }
                  $key['saldo_pokok'] = $saldo_pokok;
                  $key['saldo_bunga'] = $saldo_bunga;
            }

            return [
                  'saldoAkhirPokok' => $saldo_pokok,
                  'saldoAkhirBunga' => $saldo_bunga,
                  'utama' => $dataUtama
            ];
      }
}
