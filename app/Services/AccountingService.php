<?php

namespace App\Services;

use App\Models\Coa;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Route;

class AccountingService
{

      /**
       * Dokumentasi getTanggal
       *
       * Mengambil data bulan dan tanggal
       * berdasarkan request.
       *
       * @param mixed $request
       * @param mixed $jenis
       * @return $data
       **/
      public function getTanggal($request)
      {
            $data = [];
            if ($request->input('bulan') == null && $request->input('tahun') == null) {
                  $data['bulan'] = date('m');
                  $data['tahun'] = date('Y');
            } elseif ($request->input('bulan') == null && $request->input('tahun') != null) {
                  $data['bulan'] = date('m');
                  $data['tahun'] = $request->input('tahun');
            } elseif ($request->input('bulan') != null && $request->input('tahun') == null) {
                  $data['bulan'] = $request->input('bulan');
                  $data['tahun'] = date('Y');
            } else {
                  $data['bulan'] = $request->input('bulan');
                  $data['tahun'] = $request->input('tahun');
            }
            return $data;
      }

      /**
       * Dokumentasi getDataJurnal
       *
       * Mengambil data untuk jurnal berdasarkan
       * nama route saat ini.
       *
       * @return $data
       **/
      public function getDataToJurnal()
      {
            $cek_route = Route::currentRouteName();
            $data = [];
            if ($cek_route == "lut-jurnal") {
                  $data['title'] = 'Jurnal Umum Unit Pertokoan';
                  $data['unit'] = 'Pertokoan';
                  $data['route_post'] = 'lut-jurnal';
                  $data['route_pdf'] = 'lut-jurnal';
                  $data['route_detail'] = 'lut-jurnal';
            } else {
                  $data['title'] = 'Jurnal Umum Unit Simpan Pinjam';
                  $data['unit'] = 'Simpan Pinjam';
                  $data['route_post'] = 'lus-jurnal';
                  $data['route_pdf'] = 'lus-jurnal';
                  $data['route_detail'] = 'lus-jurnal';
            }
            return $data;
      }

      /**
       * Dokumentasi getJurnal
       *
       * Mengambil data jurnal dari database berdasarkan
       * bulan, tanggal, dan unit.
       *
       * @param mixed $bulan
       * @param mixed $tahun
       * @param mixed $unit
       * @return $jurnal
       **/
      public function getJurnal($bulan, $tahun, $unit)
      {
            $jurnal = Jurnal::with(['coa', 'transaksi'])
                  ->whereHas('transaksi', function ($query) use ($bulan, $tahun, $unit) {
                        $query->whereMonth('tgl_transaksi', $bulan)
                              ->whereYear('tgl_transaksi', $tahun)
                              ->where(function ($query) use ($unit) {
                                    $query->where('unit', $unit);
                              });
                  })->get();
            return $jurnal;
      }

      /**
       * Dokumentasi jurnalSaldoAwalBarang
       *
       * Merangkum semua fungsi untuk menyimpan saldo
       * awal barang ke dalam jurnal
       *
       * @param Array $data
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @return void
       **/
      public function jurnalSaldoAwalBarang($data, $id_transaksi, $jenis)
      {
            if ($jenis === "inventaris") {
                  self::jurnalInventaris($data, $id_transaksi);
            } else {
                  self::jurnalPersediaan($data, $id_transaksi);
            }
      }

      /**
       * Dokumentasi updateJurnalSaldoAwalBarang
       *
       * Merangkum semua fungsi untuk mengupdate saldo
       * awal barang ke dalam jurnal
       *
       * @param Array $data
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @return void
       **/
      public function updateJurnalSaldoAwalBarang($data, $id_transaksi, $jenis)
      {
            if ($jenis === "inventaris") {
                  self::updateJurnalInventaris($data, $id_transaksi);
            } else {
                  self::updateJurnalPersediaan($data, $id_transaksi);
            }
      }

      /**
       * Dokumentasi JurnalInventaris
       *
       * Merangkum semua fungsi untuk menyimpan saldo 
       * inventaris ke dalam jurnal
       *
       * @param Array $data
       * @param mixed $id_transaksi
       * @param mixed $id_kredit
       * @return void
       **/
      public function jurnalInventaris($data, $id_transaksi, $id_kredit = null)
      {
            $total = self::getNilaiInventaris($data);
            if ($total['inventaris'] > 0) {
                  $model = new Jurnal;
                  if ($id_kredit === null) {
                        $id_kredit = self::getIdCoa("%Ekuitas Saldo Awal%");
                  }
                  $coa = self::getIdInventaris();
                  jurnal($model, $coa['id_perlengkapan'], $id_transaksi, 'debet', $total['perlengkapan']);
                  jurnal($model, $coa['id_peralatan'], $id_transaksi, 'debet', $total['peralatan']);
                  jurnal($model, $coa['id_mesin'], $id_transaksi, 'debet', $total['mesin']);
                  jurnal($model, $coa['id_kendaraan'], $id_transaksi, 'debet', $total['kendaraan']);
                  jurnal($model, $coa['id_gedung'], $id_transaksi, 'debet', $total['gedung']);
                  jurnal($model, $coa['id_tanah'], $id_transaksi, 'debet', $total['tanah']);
                  jurnal($model, $coa['id_kredit'], $id_transaksi, 'kredit', $total['inventaris']);
            }
      }

      /**
       * Dokumentasi updateJurnalInventaris
       *
       * Merangkum semua fungsi untuk mengupdate saldo 
       * inventaris ke dalam jurnal
       *
       * @param Array $data
       * @param mixed $id_transaksi
       * @param mixed $id_kredit
       * @return void
       **/
      public function updateJurnalInventaris($data, $id_transaksi, $id_kredit = null)
      {
            $total = self::getNilaiInventaris($data);
            if ($total['inventaris'] > 0) {
                  if ($id_kredit === null) {
                        $id_kredit = self::getIdCoa("%Ekuitas Saldo Awal%");
                  }
                  $coa = self::getIdInventaris();
                  self::mainUpdateJurnal($coa['id_perlengkapan'], $id_transaksi, 'debet', $total['perlengkapan']);
                  self::mainUpdateJurnal($coa['id_peralatan'], $id_transaksi, 'debet', $total['peralatan']);
                  self::mainUpdateJurnal($coa['id_mesin'], $id_transaksi, 'debet', $total['mesin']);
                  self::mainUpdateJurnal($coa['id_kendaraan'], $id_transaksi, 'debet', $total['kendaraan']);
                  self::mainUpdateJurnal($coa['id_gedung'], $id_transaksi, 'debet', $total['gedung']);
                  self::mainUpdateJurnal($coa['id_tanah'], $id_transaksi, 'debet', $total['tanah']);
                  self::mainUpdateJurnal($id_kredit, $id_transaksi, 'kredit', $total['inventaris']);
            }
      }

      /**
       * Dokumentasi mainUpdateJurnal
       *
       * Merangkum semua fungsi untuk mengupdate 
       * jurnal berdasarkan id_coa dan id_transaksi 
       * pada tabel jurnal
       *
       * @param mixed $id_coa
       * @param mixed $id
       * @param mixed $posisi
       * @param mixed $nominal
       * @return void
       **/
      public function mainUpdateJurnal($id_coa, $id, $posisi, $nominal)
      {
            $id_jurnal = self::getIdJurnal($id, $id_coa);
            if ($id_jurnal) {
                  self::updateJurnal($id_jurnal, $posisi, $nominal);
            } else {
                  jurnal(new Jurnal, $id_coa, $id, $posisi, $nominal);
            }
      }

      /**
       * Dokumentasi getIdJurnal
       *
       * Mengambil nilai id_jurnal berdasarkan id_coa 
       * dan id_transaksi pada tabel jurnal
       *
       * @param mixed $id
       * @param mixed $id_coa
       * @return mixed
       **/
      public function getIdJurnal($id, $id_coa)
      {
            return Jurnal::where('id_transaksi', $id)->where('id_coa', $id_coa)->value('id_jurnal');
      }

      /**
       * Dokumentasi updateJurnalCoa
       *
       * Mengupdate jurnal berdasarkan id_coa 
       * dan id_transaksi pada tabel jurnal
       *
       * @param mixed $id_jurnal
       * @param mixed $posisi
       * @param mixed $nominal
       * @return void
       **/
      function updateJurnal($id_jurnal, $posisi, $nominal)
      {
            $update_jurnal = [
                  'posisi_dr_cr' => $posisi,
                  'nominal' => $nominal
            ];
            Jurnal::where('id_jurnal', $id_jurnal)->update($update_jurnal);
      }

      /**
       * Dokumentasi JurnalPersediaan
       *
       * Merangkum semua fungsi untuk menyimpan saldo 
       * persediaan ke dalam jurnal
       *
       * @param Array $data
       * @param mixed $id_transaksi
       * @param mixed $id_kredit
       * @return void
       **/
      public function jurnalPersediaan($data, $id_transaksi, $id_kredit = null)
      {
            $total = self::getNilaiPersediaan($data);
            if ($total['persediaan'] > 0) {
                  $model = new Jurnal;
                  if ($id_kredit === null) {
                        $id_kredit = self::getIdCoa("%Ekuitas Saldo Awal%");
                  }
                  $coa = self::getIdPersediaan();
                  jurnal($model, $coa['id_konsumsi'], $id_transaksi, 'debet', $total['konsumsi']);
                  jurnal($model, $coa['id_sandang'], $id_transaksi, 'debet', $total['sandang']);
                  jurnal($model, $coa['id_kosmetik'], $id_transaksi, 'debet', $total['kosmetik']);
                  jurnal($model, $coa['id_atm'], $id_transaksi, 'debet', $total['atm']);
                  jurnal($model, $coa['id_elektronik'], $id_transaksi, 'debet', $total['elektronik']);
                  jurnal($model, $coa['id_bangunan'], $id_transaksi, 'debet', $total['bangunan']);
                  jurnal($model, $id_kredit, $id_transaksi, 'kredit', $total['persediaan']);
            }
      }

      /**
       * Dokumentasi updateJurnalPersediaan
       *
       * Merangkum semua fungsi untuk mengupdate saldo 
       * persediaan ke dalam jurnal
       *
       * @param Array $data
       * @param mixed $id_transaksi
       * @param mixed $id_kredit
       * @return void
       **/
      public function updateJurnalPersediaan($data, $id_transaksi, $id_kredit = null)
      {
            $total = self::getNilaiPersediaan($data);
            if ($total['persediaan'] > 0) {
                  if ($id_kredit === null) {
                        $id_kredit = self::getIdCoa("%Ekuitas Saldo Awal%");
                  }
                  $coa = self::getIdPersediaan();
                  self::mainUpdateJurnal($coa['id_konsumsi'], $id_transaksi, 'debet', $total['konsumsi']);
                  self::mainUpdateJurnal($coa['id_sandang'], $id_transaksi, 'debet', $total['sandang']);
                  self::mainUpdateJurnal($coa['id_kosmetik'], $id_transaksi, 'debet', $total['kosmetik']);
                  self::mainUpdateJurnal($coa['id_atm'], $id_transaksi, 'debet', $total['atm']);
                  self::mainUpdateJurnal($coa['id_elektronik'], $id_transaksi, 'debet', $total['elektronik']);
                  self::mainUpdateJurnal($coa['id_bangunan'], $id_transaksi, 'debet', $total['bangunan']);
                  self::mainUpdateJurnal($id_kredit, $id_transaksi, 'kredit', $total['persediaan']);
            }
      }

      /**
       * Dokumentasi getIdCoa
       *
       * Mengambil id_coa dari tabel coa untuk 
       * parameter dalam input jurnal
       *
       * @param mixed $nama
       * @param mixed $columLain
       * @param mixed $columLainValue
       * @return $id_coa
       **/
      public function getIdCoa($nama, $columLain = null, $columLainValue = null)
      {
            $model = new Coa;
            if ($columLain === null) {
                  $id_coa = $model::where('nama', 'LIKE', $nama)->value('id_coa');
            } else {
                  $id_coa = $model::where('nama', 'LIKE', $nama)
                        ->where($columLain, 'LIKE', $columLainValue)
                        ->value('id_coa');
            }

            return $id_coa;
      }

      /**
       * Dokumentasi getNilaiPersediaan
       *
       * Mengambil nilai persediaan dari saldo awal barang 
       * sebagai parameter dalam input jurnal
       *
       * @param Array $data
       * @return Array $totals
       **/
      public function getNilaiPersediaan($data)
      {
            $totals = [
                  'konsumsi' => 0,
                  'sandang' => 0,
                  'kosmetik' => 0,
                  'atm' => 0,
                  'elektronik' => 0,
                  'bangunan' => 0,
                  'persediaan' => 0,
            ];

            foreach ($data as $d) {
                  $subtotal = $d['subtotal'];
                  switch ($d['jenis_barang']) {
                        case 'Barang Konsumsi':
                              $totals['konsumsi'] += $subtotal;
                              break;
                        case 'Barang Sandang':
                              $totals['sandang'] += $subtotal;
                              break;
                        case 'Barang Kosmetik':
                              $totals['kosmetik'] += $subtotal;
                              break;
                        case 'Barang ATM':
                              $totals['atm'] += $subtotal;
                              break;
                        case 'Barang Elektronik':
                              $totals['elektronik'] += $subtotal;
                              break;
                        case 'Barang Bangunan':
                              $totals['bangunan'] += $subtotal;
                              break;
                  }
                  $totals['persediaan'] += $subtotal;
            }

            return $totals;
      }

      /**
       * Dokumentasi getNilaiInventaris
       *
       * Mengambil nilai Inventaris dari saldo awal barang 
       * sebagai parameter dalam input jurnal
       *
       * @param Array $data
       * @return Array $totals
       **/
      public function getNilaiInventaris($data)
      {
            $totals = [
                  'perlengkapan' => 0,
                  'peralatan' => 0,
                  'mesin' => 0,
                  'kendaraan' => 0,
                  'gedung' => 0,
                  'tanah' => 0,
                  'inventaris' => 0,
            ];

            foreach ($data as $d) {
                  $subtotal = $d['subtotal'];
                  switch ($d['jenis_barang']) {
                        case 'Perlengkapan':
                              $totals['perlengkapan'] += $subtotal;
                              break;
                        case 'Peralatan':
                              $totals['peralatan'] += $subtotal;
                              break;
                        case 'Mesin':
                              $totals['mesin'] += $subtotal;
                              break;
                        case 'Kendaraan':
                              $totals['kendaraan'] += $subtotal;
                              break;
                        case 'Gedung':
                              $totals['gedung'] += $subtotal;
                              break;
                        case 'Tanah':
                              $totals['tanah'] += $subtotal;
                              break;
                  }
                  $totals['inventaris'] += $subtotal;
            }

            return $totals;
      }

      /**
       * Dokumentasi getIdInventaris
       *
       * Mengambil id_coa inventaris dari tabel coa
       * pada database dengan parameter tertentu
       *
       * @return mixed $data
       **/
      public function getIdInventaris()
      {
            $data = [];
            $data['id_perlengkapan'] = self::getIdCoa("%Perlengkapan%", 'kategori', "%Aktiva Tetap%");
            $data['id_peralatan'] = self::getIdCoa("%Peralatan%", 'kategori', "%Aktiva Tetap%");
            $data['id_mesin'] = self::getIdCoa("%Mesin%", 'kategori', "%Aktiva Tetap%");
            $data['id_kendaraan'] = self::getIdCoa("%Kendaraan%", 'kategori', "%Aktiva Tetap%");
            $data['id_gedung'] = self::getIdCoa("%Gedung%", 'kategori', "%Aktiva Tetap%");
            $data['id_tanah'] = self::getIdCoa("%Tanah%");
            return $data;
      }

      /**
       * Dokumentasi getIdPersediaan
       *
       * Mengambil id_coa persediaan dari tabel coa
       * pada database dengan parameter tertentu
       *
       * @return mixed $data
       **/
      public function getIdPersediaan()
      {
            $data = [];
            $data['id_konsumsi'] = self::getIdCoa("%Persediaan Barang Konsumsi%");
            $data['id_sandang'] = self::getIdCoa("%Persediaan Barang Sandang%");
            $data['id_kosmetik'] = self::getIdCoa("%Persediaan Barang Kosmetik%");
            $data['id_atm'] = self::getIdCoa("%Persediaan Barang ATM%");
            $data['id_elektronik'] = self::getIdCoa("%Persediaan Barang Elektronik%");
            $data['id_bangunan'] = self::getIdCoa("%Persediaan Barang Bangunan%");
            return $data;
      }
}
