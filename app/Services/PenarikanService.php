<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Anggota;
use App\Models\Transaksi;
use App\Models\Detail_penarikan;

class PenarikanService
{
      private $coaService;

      public function __construct()
      {
            $this->coaService = new CoaService;
      }

      /**
       * Mengambil unit untuk routeName 
       * fitur transaksi penarikan
       *
       **/
      public function getUnit($route)
      {
            $unit = [
                  'stk-penarikan' => 'Pertokoan',
                  'sp-penarikan' => 'Simpan Pinjam',
                  'sp-penarikan-srb' => 'Simpan Pinjam'
            ];
            $route = str_replace(['.create', '.create-srb', '.get-srb', '.store', '.list', '.show', '.detail', '.saldo', '.saldo-srb'], '', $route);
            return $unit[$route];
      }

      /**
       * Mengambil route utama transaksi penarikan
       * berdasarkan unit
       *
       **/
      public function getRouteMain($unit)
      {
            $route = [
                  'Pertokoan' => 'stk-penarikan',
                  'Simpan Pinjam' => 'sp-penarikan'
            ];
            return $route[$unit];
      }

      /**
       * Mengambil route show untuk fungsi
       * untuk digunakan dalam list transaksi.
       *
       * @param mixed $route
       * @return string
       * 
       **/
      public function getRouteToTable($route)
      {
            $store = [
                  'stk-penarikan.list' => 'stk-penarikan.show',
                  'sp-penarikan.list' => 'sp-penarikan.show',
            ];
            return $store[$route];
      }

      public function getJenisSimpanan($route)
      {
            $jenis = 'umum';
            if ($route === 'sp-penarikan.create-srb') {
                  $jenis = 'sukarela berbunga';
            }
            return $jenis;
      }

      /**
       * Mengambil prefix untuk kode transaksi
       * simpanan
       *
       **/
      public function getPrefixSimpanan($jenis, $unit)
      {
            if ($jenis === 'sukarela berbunga') {
                  return 'PSRB-SP-';
            } else {
                  return $unit === 'Pertokoan' ? 'PSMN-TK-' : 'PSMN-SP-';
            }
      }

      public function getPenyesuaian($unit, $jenis)
      {
            $transaksi = $jenis === 'umum' ? 'Penarikan Simpanan' : 'Penarikan Simpanan Sukarela Berbunga';
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit, $transaksi) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', $transaksi);
                  })->get();
            return $penyesuaian;
      }

      /**
       * Menginput transaksi ke dalam tabel
       * transaksi
       *
       **/
      public function createTransaksi($request, $invoicepny, $imageName)
      {
            //--input ke tabel transaksi--//
            Transaksi::create([
                  'kode' => $request['nomor'],
                  'kode_pny' => $invoicepny,
                  'no_bukti' => $request['no_bukti'],
                  'tipe' => $request['cek_penarikan'],
                  'tgl_transaksi' => $request['tgl_transaksi'],
                  'detail_tabel' => 'detail_penarikan',
                  'jenis_transaksi' => $request['jenis_transaksi'],
                  'metode_transaksi' => $request['metode_transaksi'],
                  'nota_transaksi' => $imageName,
                  'tpk' => $request['tpk'] ?? 'Larantuka',
                  'unit' => $request['unit'],
                  'total' => self::getTotalTransaksi($request),
                  'keterangan' => self::getKeteranganTransaksi($request, $invoicepny)
            ]);
      }

      /**
       * Mengambil total transaksi penarikan
       * simpanan
       **/
      public function getTotalTransaksi($request)
      {
            $jenis = $request['jenis'];
            $cek_penarikan_simpanan = $request['cek_penarikan_simpanan'] ?? '';
            $total_transaksi = $request['total_transaksi'];

            if ($jenis === 'umum' || $cek_penarikan_simpanan === 'penarikan pokok') {
                  return $total_transaksi;
            } else {
                  $bunga = convertToNumber($request['bunga']);
                  $pajak = self::getPPN($bunga, $total_transaksi);
                  $total = $pajak['total'] ?? $total_transaksi;
                  return $total;
            }
      }

      /**
       * Mengambil keterangan transaksi
       *
       **/
      public function getKeteranganTransaksi($request, $invoicepny)
      {
            $anggota = Anggota::where('id_anggota', $request['id_anggota'])->value('nama');
            if ($invoicepny == null) {
                  if ($request['jenis'] === 'umum') {
                        $keterangan = 'Penarikan ' . $request['nama_simpanan'] . ' - ' . $anggota;
                  } else {
                        $penarikan = $request['cek_penarikan_simpanan'] === 'penarikan pokok' ? 'Penarikan Pokok' : 'Penarikan Bunga';
                        $keterangan = $penarikan . ' Simpanan Sukarela Berbunga' . ' - ' . $anggota;
                  }
            } else {
                  if ($request['jenis'] === 'umum') {
                        $keterangan = 'Penyesuaian Transaksi ' . $invoicepny . ' - Penarikan ' . $request['nama_simpanan'] . ' - ' . $anggota;
                  } else {
                        $penarikan = $request['cek_penarikan_simpanan'] === 'penarikan pokok' ? 'Penarikan Pokok' : 'Penarikan Bunga';
                        $keterangan = 'Penyesuaian Transaksi ' . $invoicepny . ' - ' . $penarikan . ' Simpanan Sukarela Berbunga' . ' - ' . $anggota;
                  }
            }
            return $keterangan;
      }

      /**
       * Menginput detail transaksi penarikan ke dalam 
       * tabel detail_penarikan
       *
       **/
      public function createDetailTransaksi($request, $id_transaksi)
      {
            if ($request['jenis'] === 'umum') {
                  $jenis = $request['jenis'];
                  $nama = $request['nama_simpanan'];
            } else {
                  $jenis = $request['cek_penarikan_simpanan'] === 'penarikan pokok' ? 'sukarela berbunga' : 'bunga sukarela berbunga';
                  $bunga = convertToNumber($request['bunga']);
                  $nama = 'Simpanan Sukarela Berbunga';
                  if ($request['cek_penarikan_simpanan'] === 'penarikan bunga') {
                        $pajak = self::getPPN($bunga, $request['total_transaksi']);
                  }
            }

            Detail_penarikan::create([
                  'id_transaksi' => $id_transaksi,
                  'id_anggota' => $request['id_anggota'],
                  'jenis_penarikan' => $jenis,
                  'nama_penarikan' => $nama,
                  'bunga' => $bunga ?? null,
                  'pajak' => $pajak['ppn'] ?? null,
                  'jumlah_penarikan' => $pajak['total'] ?? $request['total_transaksi']
            ]);
      }

      /**
       * Menginput jurnal transaksi penarikan
       *
       **/
      public function createJurnal($request, $id_transaksi, $id_penyesuaian)
      {
            /*jurnal pembalik*/
            if ($request['cek_penarikan'] === 'penyesuaian') {
                  jurnalPembalik(new Jurnal, $id_transaksi, $id_penyesuaian);
            }
            if ($request['jenis'] === 'umum') {
                  self::createJurnalUmum($request, $id_transaksi);
            } else {
                  self::createJurnalSukarelaBerbunga($request, $id_transaksi);
            }
      }

      /**
       * Menginput jurnal transaksi 
       * penarikan simpanan umum
       *
       **/
      public function createJurnalUmum($request, $id_transaksi)
      {
            if ($request['nama_simpanan'] === 'Simpanan Sukarela') {
                  $id_debet = $this->coaService->getIdSimpananSukarela($request['nama_simpanan']);
            } else {
                  $id_debet = $this->coaService->getIdSimpanan($request['nama_simpanan']);
            }

            $id_kredit = $this->coaService->getIdKredit($request);
            $model = new Jurnal;
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["total_transaksi"]);
      }

      /**
       * Menginput jurnal transaksi 
       * penarikan simpanan umum
       *
       **/
      public function createJurnalSukarelaBerbunga($request, $id_transaksi)
      {
            $model = new Jurnal;
            $id_kredit = $this->coaService->getIdKredit($request);
            if ($request['cek_penarikan_simpanan'] === 'penarikan pokok') {
                  $id_debet = $this->coaService->getIdSimpananSukarela('Simpanan Sukarela Berbunga');
                  jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
                  jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["total_transaksi"]);
            } else {
                  $id_debet = $this->coaService->getIdCoa('nama', 'Bunga Simpanan Sukarela Berbunga', 'kategori', 'biaya');
                  $bunga = convertToNumber($request['bunga']);
                  if ($bunga <= 240000) {
                        jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
                        jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["total_transaksi"]);
                  } else {
                        $pajak = self::getPPN($bunga, $request['total_transaksi']);
                        jurnal($model, $id_debet, $id_transaksi, 'debet', $pajak['total']);
                        jurnal($model, $id_kredit, $id_transaksi, 'kredit', $pajak['total']);
                  }
            }
      }

      /**
       * Mengambil nilai pajak dan total transaksi
       * setelah pajak
       *
       **/
      public function getPPN($bunga, $totalSebelum)
      {
            if ($bunga <= 240000) {
                  return null;
            } else {
                  $ppn = ($bunga - 240000) * 0.1;
                  $total = $totalSebelum - $ppn;
                  $data = [
                        'ppn' => $ppn,
                        'total' => $total
                  ];
                  return $data;
            }
      }

      /**
       * Mengambil total simpanan anggota
       *
       **/
      public function getTotalPenarikanAnggota($idAnggota, $jenis, $unit, $sukarela = null)
      {
            $total = 0;
            if ($jenis == 'Simpanan Sukarela Berbunga') {
                  $dataTotal = self::getPenarikanSukarelaBerbungaAnggota($idAnggota, $jenis, $unit, $sukarela);
            } else {
                  $dataTotal = self::getPenarikanAnggota($idAnggota, $jenis, $unit);
            }
            if ($dataTotal) {
                  foreach ($dataTotal as $data) {
                        $total += $data->jumlah_penarikan;
                  }
            }
            return $total;
      }

      /**
       * Mengambil total penarikan simpanan sukarela berbunga
       * berdasarkan id_anggota
       *
       **/
      public function getPenarikanSukarelaBerbungaAnggota($idAnggota, $jenis, $unit, $sukarela)
      {
            return Detail_penarikan::with('transaksi', 'anggota')
                  ->where('id_anggota', $idAnggota)
                  ->where('jenis_penarikan', $sukarela)
                  ->where('nama_penarikan', $jenis)
                  ->whereHas('transaksi', function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Penarikan Simpanan Sukarela Berbunga')
                              ->whereNot('tipe', 'kadaluwarsa');
                  })->get();
      }

      /**
       * Mengambil total penarikan simpanan
       * berdasarkan id_anggota
       *
       **/
      public function getPenarikanAnggota($idAnggota, $jenis, $unit)
      {
            return Detail_penarikan::with('transaksi', 'anggota')
                  ->where('id_anggota', $idAnggota)
                  ->where('jenis_penarikan', 'umum')
                  ->where('nama_penarikan', $jenis)
                  ->whereHas('transaksi', function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Penarikan Simpanan')
                              ->whereNot('tipe', 'kadaluwarsa');
                  })->get();
      }
}
