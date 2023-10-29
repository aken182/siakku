<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\SimpananService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Services\AnggotaService;
use App\Services\ImageService;
use App\Services\PenarikanService;
use App\Services\PenjualanService;
use Illuminate\Support\Facades\Route;

class LaporanSimpananController extends Controller
{
      protected $simpananService;
      protected $penarikanService;
      protected $anggotaService;
      protected $transaksiService;
      protected $penjualanService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->simpananService = new SimpananService;
            $this->penarikanService = new PenarikanService;
            $this->anggotaService = new AnggotaService(new ImageService);
            $this->transaksiService = new TransaksiService;
            $this->penjualanService = new PenjualanService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $judul = $this->unit === 'Pertokoan' ? 'Kartu Toko' : 'Laporan Simpanan';
            if ($this->route === 'lus-simpanan-sb') {
                  $judul = 'Laporan Simpanan Sukarela Berbunga';
            }
            $id_anggota = $request->input('id_anggota') ?? '';
            $data = [
                  'unit' => $this->unit,
                  'title' => $judul,
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "id_anggota" => $id_anggota,
                  'dataAnggota' => $this->anggotaService->getDataAnggota($id_anggota),
                  "tahun" => $other['tahun'],
                  "tahunLalu" => $other['tahun'] - 1,
                  'hari' => $other['hari'],
                  'bulan' => $other['bulan'],
                  'anggota' => $this->anggotaService->getDataAnggotaToForm(),
                  'lp' => $this->getLaporanSimpanan($id_anggota, $other['tahun'], $judul)
            ];
            return view('content.laporan.simpanan', $data);
      }

      private function getLaporanSimpanan($id_anggota, $tahun, $jenis)
      {
            $simpanan = $this->unit === 'Pertokoan'
                  ? $this->getDataPertokoan($id_anggota, $tahun)
                  : ($jenis === 'Laporan Simpanan'
                        ? $this->getDataSimpanPinjam($id_anggota, $tahun)
                        : $this->getDataSukarelaBerbunga($id_anggota, $tahun));
            return $simpanan;
      }

      private function getDataPertokoan($id_anggota, $tahun)
      {
            $saldoAwalSimpanan = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Khusus Pertokoan', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikan = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Khusus Pertokoan", $this->unit, null, $tahun, 'saldo awal');
            $saldoAwalHutang = $this->penjualanService->getSaldoPiutangPenjualan($this->unit, $tahun, $id_anggota);
            $piutang = $this->penjualanService->getPiutangPenjualan($this->unit, $tahun, $id_anggota);
            $pembayaran = $this->getDataPembayaranPiutangToko($id_anggota, $tahun);
            $simpanan = $this->getDataSimpananToko($id_anggota, $tahun);
            $kartuToko = $this->getKartuToko($simpanan, $pembayaran, $piutang);
            $saldoPenyimpanan = sumDataArray($kartuToko, 'jumlah_simpanan') ?? 0;
            $saldoPenarikan = sumDataArray($kartuToko, 'jumlah_penarikan') ?? 0;
            $saldoPenambahanLrtk = sumDataArray($kartuToko, 'penambahan_lrtk') ?? 0;
            $saldoPenambahanPsr = sumDataArray($kartuToko, 'penambahan_psr') ?? 0;
            $saldoPenambahanWrg = sumDataArray($kartuToko, 'penambahan_wrg') ?? 0;
            $saldoTunaiLrtk = sumDataArray($kartuToko, 'tunai_lrtk') ?? 0;
            $saldoTunaiPsr = sumDataArray($kartuToko, 'tunai_psr') ?? 0;
            $saldoTunaiWrg = sumDataArray($kartuToko, 'tunai_wrg') ?? 0;
            $saldoPotongan = sumDataArray($kartuToko, 'pot_bendahara') ?? 0;
            // dd($kartuToko);
            $saldoAwalSimpanan -= $saldoAwalPenarikan;
            $saldoPenambahan = $saldoPenambahanLrtk + $saldoPenambahanPsr + $saldoPenambahanWrg;
            $saldoTunai = $saldoTunaiLrtk + $saldoTunaiPsr + $saldoTunaiWrg;
            $saldoAkhirSimpanan = $saldoAwalSimpanan + $saldoPenyimpanan - $saldoPenarikan;
            $saldoAkhirHutang = $saldoAwalHutang + $saldoPenambahan - ($saldoTunai + $saldoPotongan);

            return [
                  'saldoAwalSimpanan' => $saldoAwalSimpanan,
                  'saldoAwalHutang' => $saldoAwalHutang,
                  'kartuToko' => $kartuToko,
                  'saldoPenyimpanan' => $saldoPenyimpanan,
                  'saldoPenarikan' => $saldoPenarikan,
                  'saldoPenambahanLrtk' => $saldoPenambahanLrtk,
                  'saldoPenambahanPsr' => $saldoPenambahanPsr,
                  'saldoPenambahanWrg' => $saldoPenambahanWrg,
                  'saldoTunaiLrtk' => $saldoTunaiLrtk,
                  'saldoTunaiPsr' => $saldoTunaiPsr,
                  'saldoTunaiWrg' => $saldoTunaiWrg,
                  'saldoPenambahan' => $saldoPenambahan,
                  'saldoTunai' => $saldoTunai,
                  'saldoPotongan' => $saldoPotongan,
                  'saldoAkhirSimpanan' => $saldoAkhirSimpanan,
                  'saldoAkhirHutang' => $saldoAkhirHutang
            ];
      }

      private function getDataSimpanPinjam($id_anggota, $tahun)
      {
            $saldoAwalPokok = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Pokok', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikanPokok = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Pokok", $this->unit, null, $tahun, 'saldo awal');
            $saldoAwalWajib = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Wajib', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikanWajib = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Wajib", $this->unit, null, $tahun, 'saldo awal');
            $saldoAwalPthk = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan PTHK', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikanPthk = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan PTHK", $this->unit, null, $tahun, 'saldo awal');
            $saldoAwalKhusus = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Khusus', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikanKhusus = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Khusus", $this->unit, null, $tahun, 'saldo awal');
            $saldoAwalKapitalisasi = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Kapitalisasi', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikanKapitalisasi = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Kapitalisasi", $this->unit, null, $tahun, 'saldo awal');
            $saldoAwalSukarela = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Sukarela', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikanSukarela = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Sukarela", $this->unit, null, $tahun, 'saldo awal');
            $pokok = $this->getDataSimpananSp($id_anggota, $tahun, 'Simpanan Pokok');
            $wajib = $this->getDataSimpananSp($id_anggota, $tahun, 'Simpanan Wajib');
            $pthk = $this->getDataSimpananSp($id_anggota, $tahun, 'Simpanan PTHK');
            $khusus = $this->getDataSimpananSp($id_anggota, $tahun, 'Simpanan Khusus');
            $kapitalisasi = $this->getDataSimpananSp($id_anggota, $tahun, 'Simpanan Kapitalisasi');
            $sukarela = $this->getDataSimpananSp($id_anggota, $tahun, 'Simpanan Sukarela');
            $laporan = $this->getKartuSp($pokok, $wajib, $pthk, $khusus, $kapitalisasi, $sukarela);

            $saldoAwalPokok -= $saldoAwalPenarikanPokok;
            $saldoAwalWajib -= $saldoAwalPenarikanWajib;
            $saldoAwalPthk -= $saldoAwalPenarikanPthk;
            $saldoAwalKhusus -= $saldoAwalPenarikanKhusus;
            $saldoAwalKapitalisasi -= $saldoAwalPenarikanKapitalisasi;
            $saldoAwalSukarela -= $saldoAwalPenarikanSukarela;
            $saldoAwal = $saldoAwalPokok + $saldoAwalWajib + $saldoAwalPthk + $saldoAwalKhusus + $saldoAwalKapitalisasi + $saldoAwalSukarela;
            // dd($saldoAwalWajib);
            return [
                  'saldoAwalPokok' => $saldoAwalPokok,
                  'saldoAwalWajib' => $saldoAwalWajib,
                  'saldoAwalPthk' => $saldoAwalPthk,
                  'saldoAwalKhusus' => $saldoAwalKhusus,
                  'saldoAwalKapitalisasi' => $saldoAwalKapitalisasi,
                  'saldoAwalSukarela' => $saldoAwalSukarela,
                  'saldoAwal' => $saldoAwal,
                  "laporan" => $laporan
            ];
      }

      private function getDataSimpananToko($id_anggota, $tahun)
      {
            $data = [];
            $simpanan = $this->simpananService->getSimpananPertokoanAnggota($id_anggota, $this->unit, $tahun, 'simpanan tahun ini');
            $penarikan = $this->penarikanService->getPenarikanAnggota($id_anggota, 'Simpanan Khusus Pertokoan', $this->unit, $tahun, 'penarikan tahun ini');
            foreach ($simpanan as $s) {
                  $data[] = [
                        'tgl_transaksi' => $s->main_simpanan->transaksi->tgl_transaksi,
                        'no_bukti' => $s->main_simpanan->transaksi->no_bukti,
                        'jumlah_simpanan' => $s->jumlah,
                        'jumlah_penarikan' => 0,
                  ];
            }
            foreach ($penarikan as $p) {
                  $data[] = [
                        'tgl_transaksi' => $p->transaksi->tgl_transaksi,
                        'no_bukti' => $p->transaksi->no_bukti,
                        'jumlah_simpanan' => 0,
                        'jumlah_penarikan' => $p->jumlah_penarikan,
                  ];
            }
            // dd($data);
            return $data;
      }

      private function getDataSimpananSp($id_anggota, $tahun, $jenis)
      {
            $data = [];
            $nama = strtolower(str_replace('Simpanan ', '', $jenis));
            if ($jenis === 'Simpanan Kapitalisasi') {
                  $kapitalisasi = $this->simpananService->getKapitalisasiFromPinjaman($id_anggota, $this->unit, $tahun, 'simpanan tahun ini');
                  foreach ($kapitalisasi as $k) {
                        $data[] = [
                              'id_transaksi' => $k->id_transaksi,
                              'tgl_transaksi' => $k->transaksi->tgl_transaksi,
                              'no_bukti' => $k->transaksi->no_bukti,
                              "jumlah_$nama" => $k->kapitalisasi
                        ];
                  }
            }
            $idSimpanan = $this->simpananService->getIdSimpananSimpanPinjam($jenis);
            $simpanan = $this->simpananService->getSimpananSimpanPinjamAnggota($idSimpanan, $id_anggota, $this->unit, $tahun, 'simpanan tahun ini');
            $penarikan = $this->penarikanService->getPenarikanAnggota($id_anggota, $jenis, $this->unit, $tahun, 'penarikan tahun ini');

            foreach ($simpanan as $s) {
                  $data[] = [
                        'id_transaksi' => $s->main_simpanan->id_transaksi,
                        'tgl_transaksi' => $s->main_simpanan->transaksi->tgl_transaksi,
                        'no_bukti' => $s->main_simpanan->transaksi->no_bukti,
                        "jumlah_$nama" => $s->jumlah,
                  ];
            }
            foreach ($penarikan as $p) {
                  $data[] = [
                        'id_transaksi' => $p->transaksi->id_transaksi,
                        'tgl_transaksi' => $p->transaksi->tgl_transaksi,
                        'no_bukti' => $p->transaksi->no_bukti,
                        "jumlah_$nama" => $p->jumlah_penarikan * -1,
                  ];
            }
            return $data;
      }

      private function getDataPembayaranPiutangToko($id_anggota, $tahun)
      {
            $data = [];
            $pembayaran = $this->penjualanService->getPembayaranPiutangPenjualan($this->unit, $tahun, $id_anggota);
            foreach ($pembayaran as $s) {
                  $tunaiLrtk = null;
                  $tunaiPsr = null;
                  $tunaiWrg = null;
                  if ($s->transaksi->tpk === 'Larantuka') {
                        $tunaiLrtk = $s->jumlah_pelunasan;
                  }
                  if ($s->transaksi->tpk === 'Pasar Baru') {
                        $tunaiPsr = $s->jumlah_pelunasan;
                  }
                  if ($s->transaksi->tpk === 'Waiwerang') {
                        $tunaiWrg = $s->jumlah_pelunasan;
                  }
                  $data[] = [
                        'tgl_transaksi' => $s->transaksi->tgl_transaksi,
                        'no_bukti' => $s->transaksi->no_bukti,
                        'tunai_lrtk' => $tunaiLrtk,
                        'tunai_psr' => $tunaiPsr,
                        'tunai_wrg' => $tunaiWrg,
                        'pot_bendahara' => $s->pot_bendahara,
                  ];
            }
            return $data;
      }

      private function getKartuToko($simpanan, $pembayaran, $piutang)
      {
            $mergedData = array_merge($simpanan, $pembayaran, $piutang);
            $dataUtama = [];

            foreach ($mergedData as $item) {
                  $no_bukti = $item['no_bukti'];
                  $tgl_transaksi = $item['tgl_transaksi'];

                  $jumlah = $item['jumlah_simpanan'] ?? 0;
                  $jumlah_penarikan = $item['jumlah_penarikan'] ?? 0;
                  $hutanglrtk = $item['penambahan_lrtk'] ?? 0;
                  $hutangpsr = $item['penambahan_psr'] ?? 0;
                  $hutangwrg = $item['penambahan_wrg'] ?? 0;
                  $jumlah_tunailrtk = $item['tunai_lrtk'] ?? 0;
                  $jumlah_tunaipsr = $item['tunai_psr'] ?? 0;
                  $jumlah_tunaiwrg = $item['tunai_wrg'] ?? 0;
                  $pot_bendahara = $item['pot_bendahara'] ?? 0;

                  foreach ($mergedData as $otherItem) {
                        if ($item === $otherItem || ($item['no_bukti'] !== $otherItem['no_bukti'])) {
                              continue;
                        }

                        if (strpos($otherItem['no_bukti'], "KM") !== false) {
                              $jumlah += $otherItem['jumlah_simpanan'] ?? 0;
                              $hutanglrtk += $otherItem['penambahan_lrtk'] ?? 0;
                              $hutangpsr += $otherItem['penambahan_psr'] ?? 0;
                              $hutangwrg += $otherItem['penambahan_wrg'] ?? 0;
                              $jumlah_tunailrtk += $otherItem['tunai_lrtk'] ?? 0;
                              $jumlah_tunaipsr += $otherItem['tunai_psr'] ?? 0;
                              $jumlah_tunaiwrg += $otherItem['tunai_wrg'] ?? 0;
                              $pot_bendahara += $otherItem['pot_bendahara'] ?? 0;
                        }

                        if (strpos($otherItem['no_bukti'], "KK") !== false) {
                              $jumlah_penarikan += $otherItem['jumlah_penarikan'] ?? 0;
                        }
                  }

                  $dataUtama[] = [
                        'tgl_transaksi' => $tgl_transaksi,
                        'no_bukti' => $no_bukti,
                        'jumlah_simpanan' => $jumlah,
                        'jumlah_penarikan' => $jumlah_penarikan,
                        'penambahan_lrtk' => $hutanglrtk,
                        'penambahan_psr' => $hutangpsr,
                        'penambahan_wrg' => $hutangwrg,
                        'tunai_lrtk' => $jumlah_tunailrtk,
                        'tunai_psr' => $jumlah_tunaipsr,
                        'tunai_wrg' => $jumlah_tunaiwrg,
                        'pot_bendahara' => $pot_bendahara
                  ];
            }

            $uniqueDataUtama = unique_multi_array($dataUtama, 'no_bukti');
            usort($uniqueDataUtama, function ($a, $b) {
                  return $a['tgl_transaksi'] <=> $b['tgl_transaksi'];
            });

            return $uniqueDataUtama;
      }

      private function getKartuSp($pokok, $wajib, $pthk, $khusus, $kapitalisasi, $sukarela)
      {
            $mergedData = array_merge($pokok, $wajib, $pthk, $khusus, $kapitalisasi, $sukarela);
            $dataUtama = [];
            foreach ($mergedData as $m) {
                  $jumlah_pokok = $m['jumlah_pokok'] ?? 0;
                  $jumlah_wajib = $m['jumlah_wajib'] ?? 0;
                  $jumlah_pthk = $m['jumlah_pthk'] ?? 0;
                  $jumlah_khusus = $m['jumlah_khusus'] ?? 0;
                  $jumlah_kapitalisasi = $m['jumlah_kapitalisasi'] ?? 0;
                  $jumlah_sukarela = $m['jumlah_sukarela'] ?? 0;
                  foreach ($mergedData as $mini) {
                        if ($m === $mini || ($m['id_transaksi'] !== $mini['id_transaksi'])) {
                              continue;
                        } else {
                              $jumlah_pokok += $mini['jumlah_pokok'] ?? 0;
                              $jumlah_wajib += $mini['jumlah_wajib'] ?? 0;
                              $jumlah_pthk += $mini['jumlah_pthk'] ?? 0;
                              $jumlah_khusus += $mini['jumlah_khusus'] ?? 0;
                              $jumlah_kapitalisasi += $mini['jumlah_kapitalisasi'] ?? 0;
                              $jumlah_sukarela += $mini['jumlah_sukarela'] ?? 0;
                        }
                  }
                  $dataUtama[] = [
                        'id_transaksi' => $m['id_transaksi'],
                        'tgl_transaksi' => $m['tgl_transaksi'],
                        'no_bukti' => $m['no_bukti'],
                        'jumlah_pokok' => $jumlah_pokok,
                        'jumlah_wajib' => $jumlah_wajib,
                        'jumlah_pthk' => $jumlah_pthk,
                        'jumlah_khusus' => $jumlah_khusus,
                        'jumlah_kapitalisasi' => $jumlah_kapitalisasi,
                        'jumlah_sukarela' => $jumlah_sukarela
                  ];
            }
            // dd($dataUtama);
            $uniqueDataUtama = unique_multi_array($dataUtama, 'id_transaksi');
            usort($uniqueDataUtama, function ($a, $b) {
                  return $a['tgl_transaksi'] <=> $b['tgl_transaksi'];
            });
            return $uniqueDataUtama;
      }

      private function getDataSukarelaBerbunga($id_anggota, $tahun)
      {
            $saldoAwalSimpanan = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Sukarela Berbunga', $this->unit, $tahun, 'saldo awal');
            $saldoAwalPenarikan = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, "Simpanan Sukarela Berbunga", $this->unit, 'sukarela berbunga', $tahun, 'saldo awal');
            $saldoAwal = $saldoAwalSimpanan - $saldoAwalPenarikan;
            $simpanan = $this->simpananService->getSimpananSukarelaBerbungaAnggota($id_anggota, "Simpanan Sukarela Berbunga", $this->unit, $tahun, 'simpanan tahun ini');
            $penarikanPokok = $this->penarikanService->getPenarikanSukarelaBerbungaAnggota($id_anggota, "Simpanan Sukarela Berbunga", $this->unit, 'sukarela berbunga', $tahun, 'penarikan tahun ini');
            $penarikanBunga = $this->penarikanService->getPenarikanSukarelaBerbungaAnggota($id_anggota, "Simpanan Sukarela Berbunga", $this->unit, 'bunga sukarela berbunga', $tahun, 'penarikan tahun ini');
            $data = $this->getDataSimpananSr($simpanan, $penarikanPokok, $penarikanBunga, $saldoAwal);
            // dd($data);
            return [
                  'data' => $data,
                  'saldoAwal' => $saldoAwal
            ];
      }

      private function getDataSimpananSr($simpanan, $penarikanPokok, $penarikanBunga, $saldoAwal)
      {
            $data = [];
            foreach ($simpanan as $s) {
                  $data[] = [
                        'tgl_transaksi' => $s->main_simpanan->transaksi->tgl_transaksi,
                        'no_bukti' => $s->main_simpanan->transaksi->no_bukti,
                        'setor_pokok' => $s->jumlah,
                        'tarik_pokok' => null,
                        'saldo' => null,
                        'bunga' => $s->bunga,
                        'tarik_bunga' => null,
                  ];
            }
            foreach ($penarikanPokok as $pk) {
                  $data[] = [
                        'tgl_transaksi' => $pk->transaksi->tgl_transaksi,
                        'no_bukti' => $pk->transaksi->no_bukti,
                        'setor_pokok' => null,
                        'tarik_pokok' => $pk->jumlah_penarikan,
                        'saldo' => null,
                        'bunga' => $pk->bunga,
                        'tarik_bunga' => null,
                  ];
            }
            foreach ($penarikanBunga as $pb) {
                  $data[] = [
                        'tgl_transaksi' => $pb->transaksi->tgl_transaksi,
                        'no_bukti' => $pb->transaksi->no_bukti,
                        'setor_pokok' => null,
                        'tarik_pokok' => null,
                        'saldo' => null,
                        'bunga' => $pb->bunga,
                        'tarik_bunga' => $pb->jumlah_penarikan,
                  ];
            }

            usort($data, function ($a, $b) {
                  return $a['tgl_transaksi'] <=> $b['tgl_transaksi'];
            });

            $total = 0;
            $total += $saldoAwal;
            foreach ($data as &$key) { //menggunakan &$key untuk mengakses array asli
                  if ($key['setor_pokok'] !== null) {
                        $total += $key['setor_pokok'];
                  }
                  if ($key['tarik_pokok'] !== null) {
                        $total -= $key['tarik_pokok'];
                  }
                  $key['saldo'] = $total;
            }

            return $data;
      }
}
