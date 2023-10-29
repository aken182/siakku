<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Transaksi;
use App\Services\CoaService;
use App\Models\Main_simpanan;
use App\Models\Detail_simpanan;
use App\Models\Main_pinjaman;

class SimpananService
{
      protected $coaService;

      public function __construct()
      {
            $this->coaService = new CoaService;
      }

      public function getSimpanan($id)
      {
            return Simpanan::where('id_simpanan', $id)->first();
      }

      /**
       * Mengambil unit simpanan berdasarkan
       * routeName
       *
       **/
      public function getUnit($route)
      {
            $unit = [
                  'stk-simpanan' => 'Pertokoan',
                  'sp-simpanan' => 'Simpan Pinjam',
                  'sp-simpanan-srb' => 'Simpan Pinjam'
            ];
            $route = str_replace(['.create', '.create-srb', '.get-srb', '.store', '.list', '.show', '.detail'], '', $route);
            return $unit[$route];
      }

      /**
       * Mengambil total simpanan sukarela
       * berbunga
       *
       **/
      public function getTotalPnySbr($id_penyesuaian, $id_anggota)
      {
            if ($id_penyesuaian != null) {
                  $jumlah_penarikan = Main_simpanan::where('id_transaksi', $id_penyesuaian)
                        ->where('id_anggota', $id_anggota)
                        ->where('jenis_simpanan', 'sukarela berbunga')
                        ->value('total_simpanan');
                  $total_pny = $jumlah_penarikan === null ? 0 : $jumlah_penarikan;
            } else {
                  $total_pny = 0;
            }
            return $total_pny;
      }

      /**
       * Mengambil total simpanan anggota
       *
       **/
      public function getTotalSimpananAnggota($idAnggota, $jenis, $unit, $tahun = null, $type = null)
      {
            $total = 0;
            if ($jenis == 'Simpanan Sukarela Berbunga') {
                  $dataTotal = self::getSimpananSukarelaBerbungaAnggota($idAnggota, $jenis, $unit, $tahun, $type);
            } else {
                  if ($unit === 'Pertokoan') {
                        $dataTotal = self::getSimpananPertokoanAnggota($idAnggota, $unit, $tahun, $type);
                  } else {
                        if ($jenis === 'Simpanan Kapitalisasi') {
                              $kapitalisasi = self::getKapitalisasiFromPinjaman($idAnggota, $unit, $tahun, $type);
                              $totalKapitalisasi = 0;
                              foreach ($kapitalisasi as $d) {
                                    $totalKapitalisasi += $d->kapitalisasi;
                              }
                              $total += $totalKapitalisasi;
                        }
                        $idSimpanan = self::getIdSimpananSimpanPinjam($jenis);
                        $dataTotal = self::getSimpananSimpanPinjamAnggota($idSimpanan, $idAnggota, $unit, $tahun, $type);
                  }
            }
            if ($dataTotal) {
                  foreach ($dataTotal as $data) {
                        $total += $data->jumlah;
                  }
            }
            return $total;
      }

      /**
       * Mengambil simpanan kapitalisasi dari 
       * potongan pinjaman baru anggota
       *
       **/
      public function getKapitalisasiFromPinjaman($id_anggota, $unit, $tahun = null, $type = null)
      {
            $transaksi = $this->getWhereTransaksiSimpanan($unit, $tahun, $type);
            $data = Main_pinjaman::with('transaksi')
                  ->where('id_anggota', $id_anggota)
                  ->where('jenis', 'baru')
                  ->whereHas('transaksi', $transaksi)->get();
            return $data;
      }

      /**
       * Mengambil id_simpanan unit simpan pinjam
       *
       **/
      public function getIdSimpananSimpanPinjam($jenis)
      {
            return Simpanan::where('nama', $jenis)->value('id_simpanan');
      }
      /**
       * Mengambil total simpanan sukarela berbunga
       * berdasarkan id_anggota
       *
       **/
      public function getSimpananSukarelaBerbungaAnggota($idAnggota, $jenis, $unit, $tahun = null, $type = null)
      {
            $transaksi = $this->getWhereTransaksiSimpananSr($unit, $jenis, $tahun, $type);
            return Detail_simpanan::with('main_simpanan.transaksi', 'main_simpanan', 'main_simpanan.anggota')
                  ->whereHas('main_simpanan', function ($query) use ($idAnggota, $transaksi) {
                        $query->where('id_anggota', $idAnggota)
                              ->where('jenis_simpanan', 'sukarela berbunga')
                              ->whereHas('transaksi', $transaksi);
                  })->get();
      }

      /**
       * Mengambil total simpanan unit
       * simpan pinjam berdasarkan id_anggota
       *
       **/
      public function getSimpananSimpanPinjamAnggota($idSimpanan, $idAnggota, $unit, $tahun = null, $type = null)
      {
            $transaksi = $this->getWhereTransaksiSimpanan($unit, $tahun, $type);
            return Detail_simpanan::with('main_simpanan.transaksi', 'main_simpanan', 'main_simpanan.anggota')
                  ->where('id_simpanan', $idSimpanan)
                  ->whereHas('main_simpanan', function ($query) use ($idAnggota, $transaksi) {
                        $query->where('id_anggota', $idAnggota)
                              ->where('jenis_simpanan', 'umum')
                              ->whereHas('transaksi', $transaksi);
                  })->get();
      }

      /**
       * Mengambil total simpanan unit
       * pertokoan berdasarkan id_anggota
       *
       **/
      public function getSimpananPertokoanAnggota($idAnggota, $unit, $tahun = null, $type = null)
      {
            $transaksi = $this->getWhereTransaksiSimpanan($unit, $tahun, $type);
            return Detail_simpanan::with('main_simpanan.transaksi', 'main_simpanan', 'main_simpanan.anggota')
                  ->whereHas('main_simpanan', function ($query) use ($idAnggota, $transaksi) {
                        $query->where('id_anggota', $idAnggota)
                              ->where('jenis_simpanan', 'umum')
                              ->whereHas('transaksi', $transaksi);
                  })->get();
      }

      /**
       * Mengambil kondisi transaksi berdasarkan
       * unit, tahun, tipe transaksi
       *
       **/
      private function getWhereTransaksiSimpanan($unit, $tahun = null, $type = null)
      {
            $transaksi = function ($query) use ($unit) {
                  $query->where('unit', $unit)
                        ->whereNot('tipe', 'kadaluwarsa');
            };

            if ($tahun != null && $type != null) {
                  if ($type === 'saldo awal') {
                        $transaksi = function ($query) use ($unit, $tahun) {
                              $query->where('unit', $unit)
                                    ->whereDate('tgl_transaksi', '<', "$tahun-01-01")
                                    ->whereNot('tipe', 'kadaluwarsa');
                        };
                  } else {
                        $transaksi = function ($query) use ($unit, $tahun) {
                              $query->where('unit', $unit)
                                    ->whereDate('tgl_transaksi', '>=', "$tahun-01-01")
                                    ->whereDate('tgl_transaksi', '<=', "$tahun-12-31")
                                    ->whereNot('tipe', 'kadaluwarsa');
                        };
                  }
            }
            return $transaksi;
      }

      /**
       * Mengambil kondisi transaksi simpanan sukarela berbunga
       * berdasarkan unit, tahun, tipe transaksi
       *
       **/
      private function getWhereTransaksiSimpananSr($unit, $jenis, $tahun = null, $type = null)
      {
            $transaksi = function ($query) use ($jenis, $unit) {
                  $query->where('unit', $unit)
                        ->where('jenis_transaksi', $jenis)
                        ->whereNot('tipe', 'kadaluwarsa');
            };

            if ($tahun != null && $type != null) {
                  if ($type === 'saldo awal') {
                        $transaksi = function ($query) use ($unit, $jenis, $tahun) {
                              $query->where('unit', $unit)
                                    ->where('jenis_transaksi', $jenis)
                                    ->whereDate('tgl_transaksi', '<', "$tahun-01-01")
                                    ->whereNot('tipe', 'kadaluwarsa');
                        };
                  } else {
                        $transaksi = function ($query) use ($unit, $jenis, $tahun) {
                              $query->where('unit', $unit)
                                    ->where('jenis_transaksi', $jenis)
                                    ->whereDate('tgl_transaksi', '>=', "$tahun-01-01")
                                    ->whereDate('tgl_transaksi', '<=', "$tahun-12-31")
                                    ->whereNot('tipe', 'kadaluwarsa');
                        };
                  }
            }
            return $transaksi;
      }

      /**
       * Mengambil unit route utama berdasarkan
       * unit
       *
       **/
      public function getRouteMain($unit)
      {
            $route = [
                  'Pertokoan' => 'stk-simpanan',
                  'Simpan Pinjam' => 'sp-simpanan'
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
                  'stk-simpanan.list' => 'stk-simpanan.show',
                  'sp-simpanan.list' => 'sp-simpanan.show',
            ];
            return $store[$route];
      }

      /**
       * Mengambil prefix untuk kode transaksi
       * simpanan
       *
       **/
      public function getPrefixSimpanan($jenis, $unit)
      {
            if ($jenis === 'sukarela berbunga') {
                  return 'SSRB-SP-';
            } else {
                  return $unit === 'Pertokoan' ? 'SMN-TK-' : 'SMN-SP-';
            }
      }

      public function getPenyesuaian($unit, $jenis)
      {
            $jenisTransaksi = $jenis === 'umum' ? 'Simpanan' : 'Simpanan Sukarela Berbunga';
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit, $jenisTransaksi) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', $jenisTransaksi);
                  })->get();
            return $penyesuaian;
      }

      public function getJenisSimpanan($route)
      {
            $jenis = 'umum';
            if ($route === 'sp-simpanan.create-srb') {
                  $jenis = 'sukarela berbunga';
            }
            return $jenis;
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
                  'tipe' => $request['cek_simpanan'],
                  'tgl_transaksi' => $request['tgl_transaksi'],
                  'detail_tabel' => 'detail_simpanan',
                  'jenis_transaksi' => $request['jenis_transaksi'],
                  'metode_transaksi' => $request['metode_transaksi'],
                  'nota_transaksi' => $imageName,
                  'tpk' => $request['tpk'] ?? 'Larantuka',
                  'unit' => $request['unit'],
                  'total' => $request['total_transaksi'],
                  'keterangan' => self::getKeteranganTransaksi($request, $invoicepny)
            ]);
      }

      /**
       * Mengambil keterangan transaksi
       *
       **/
      public function getKeteranganTransaksi($request, $invoicepny)
      {
            $anggota = Anggota::where('id_anggota', $request['id_anggota'])->value('nama');
            if ($invoicepny == null) {
                  $keterangan = 'Penerimaan ' . $request['jenis_transaksi'] . ' - ' . $anggota;
            } else {
                  $keterangan = 'Penyesuaian Transaksi ' . $invoicepny . ' - Penerimaan ' . $request['jenis_transaksi'] . ' - ' . $anggota;
            }
            return $keterangan;
      }

      /**
       * Undocumented function long description
       *
       **/
      public function createDetailTransaksi($request, $id_transaksi)
      {
            self::createMainSimpanan($request, $id_transaksi);
            $id_main = Main_simpanan::where('id_transaksi', $id_transaksi)->value('id_main');
            if ($request['unit'] === 'Pertokoan') {
                  self::createSimpananPertokoan($request, $id_main);
            } else {
                  if ($request['jenis_transaksi'] === 'Simpanan Sukarela Berbunga') {
                        self::createSimpananSukarelaBerbunga($request, $id_main);
                  } else {
                        self::createSimpananSimpanPinjam($request, $id_main);
                  }
            }
      }

      /**
       * undocumented function summary
       *
       **/
      public function createMainSimpanan($request, $id_transaksi)
      {
            $jenis_simpanan = $request['jenis_transaksi'] === 'Simpanan Sukarela Berbunga' ? 'sukarela berbunga' : 'umum';
            Main_simpanan::create([
                  'id_transaksi' => $id_transaksi,
                  'id_anggota' => $request['id_anggota'],
                  'jenis_simpanan' => $jenis_simpanan,
                  'total_simpanan' => $request['total_transaksi'],
            ]);
      }

      /**
       * undocumented function summary
       *
       **/
      public function createSimpananPertokoan($request, $id_main)
      {
            Detail_simpanan::create([
                  'id_main' => $id_main,
                  'jumlah' => $request['total_transaksi'],
            ]);
      }

      /**
       * undocumented function summary
       *
       **/
      public function createSimpananSimpanPinjam($request, $id_main)
      {
            $data = json_decode($request['data_simpanan'], true);
            foreach ($data as $d) {
                  Detail_simpanan::create([
                        'id_main' => $id_main,
                        'id_simpanan' => $d['id_simpanan'],
                        'jumlah' => $d['jumlah']
                  ]);
            }
      }

      /**
       * undocumented function summary
       *
       **/
      public function createSimpananSukarelaBerbunga($request, $id_main)
      {
            Detail_simpanan::create([
                  'id_main' => $id_main,
                  'jumlah' => $request['total_transaksi'],
                  'bunga' => convertToNumber($request['bunga']),
            ]);
      }

      /**
       * undocumented function summary
       *
       **/
      public function createJurnal($request, $id_transaksi, $id_penyesuaian)
      {
            /*jurnal pembalik*/
            if ($request['cek_simpanan'] === 'penyesuaian') {
                  jurnalPembalik(new Jurnal, $id_transaksi, $id_penyesuaian);
            }
            if ($request['unit'] === 'Pertokoan') {
                  self::createJurnalPertokoan($request, $id_transaksi);
            } else {
                  if ($request['jenis_transaksi'] === 'Simpanan Sukarela Berbunga') {
                        self::createJurnalSukarelaBerbunga($request, $id_transaksi);
                  } else {
                        self::createJurnalSimpanPinjam($request, $id_transaksi);
                  }
            }
      }

      /**
       * Undocumented function long description
       *
       **/
      public function createJurnalPertokoan($request, $id_transaksi)
      {
            $id_debet = $this->coaService->getIdDebet($request);
            $id_kredit = $this->coaService->getIdSimpanan('Simpanan Khusus Pertokoan');
            $model = new Jurnal;
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["total_transaksi"]);
      }

      /**
       * Undocumented function long description
       *
       **/
      public function createJurnalSimpanPinjam($request, $id_transaksi)
      {
            $id_debet = $this->coaService->getIdDebet($request);
            $kredit = $this->coaService->getSimpananSimpanPinjam();
            $data = json_decode($request['data_simpanan'], true);
            $total = self::getNilaiSimpanan($data);
            $model = new Jurnal;
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $kredit['id_pokok'], $id_transaksi, 'kredit', $total["pokok"]);
            jurnal($model, $kredit['id_wajib'], $id_transaksi, 'kredit', $total["wajib"]);
            jurnal($model, $kredit['id_pthk'], $id_transaksi, 'kredit', $total["pthk"]);
            jurnal($model, $kredit['id_khusus'], $id_transaksi, 'kredit', $total["khusus"]);
            jurnal($model, $kredit['id_kapitalisasi'], $id_transaksi, 'kredit', $total["kapitalisasi"]);
            jurnal($model, $kredit['id_sukarela'], $id_transaksi, 'kredit', $total["sukarela"]);
      }

      /**
       * undocumented function summary
       *
       **/
      public function getNilaiSimpanan($data)
      {
            $totals = [
                  'pokok' => 0,
                  'wajib' => 0,
                  'pthk' => 0,
                  'khusus' => 0,
                  'kapitalisasi' => 0,
                  'sukarela' => 0,
            ];

            foreach ($data as $d) {
                  $namaSimpanan = strtolower(str_replace('Simpanan ', '', $d['nama']));
                  $totals[$namaSimpanan] += $d['jumlah'];
            }
            return $totals;
      }

      /**
       * Undocumented function long description
       *
       **/
      public function createJurnalSukarelaBerbunga($request, $id_transaksi)
      {
            $id_debet = $this->coaService->getIdDebet($request);
            $id_kredit = $this->coaService->getIdSimpanan('Simpanan Sukarela Berbunga');
            $model = new Jurnal;
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["total_transaksi"]);
      }
}
