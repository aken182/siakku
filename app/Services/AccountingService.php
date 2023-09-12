<?php

namespace App\Services;

use App\Models\Coa;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;
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
       * @return $data
       **/
      public function getTanggal($request)
      {
            $data = [
                  'bulan' => $request->input('bulan') ?: date('m'),
                  'tahun' => $request->input('tahun') ?: date('Y'),
            ];
            return $data;
      }

      public function getTanggalIdCoa($request)
      {
            $data = [
                  'bulan' => $request->input('bulan') ?: date('m'),
                  'tahun' => $request->input('tahun') ?: date('Y'),
                  'id_coa' => $request->input('id_coa') ?: 1,
            ];

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
            $data = [
                  'title' => ($cek_route == "lut-jurnal") ? 'Jurnal Umum Unit Pertokoan' : 'Jurnal Umum Unit Simpan Pinjam',
                  'unit' => ($cek_route == "lut-jurnal") ? 'Pertokoan' : 'Simpan Pinjam',
                  'route_post' => ($cek_route == "lut-jurnal") ? 'lut-jurnal' : 'lus-jurnal',
                  'route_pdf' => ($cek_route == "lut-jurnal") ? 'lut-jurnal.pdf' : 'lus-jurnal.pdf',
                  'route_detail' => ($cek_route == "lut-jurnal") ? 'lut-jurnal.detail' : 'lus-jurnal.detail',
            ];

            return $data;
      }

      /**
       * Dokumentasi getDatatoBukuBesar
       *
       * Mengambil data untuk buku besar berdasarkan
       * nama route saat ini.
       *
       * @return $data
       **/
      public function getDataToBukuBesar()
      {
            $cek_route = Route::currentRouteName();
            $data = [];
            $data['title'] = 'Buku Besar';
            if ($cek_route == "lut-buku-besar") {
                  $data['unit'] = 'Pertokoan';
                  $data['route_post'] = 'lut-buku-besar';
                  $data['route_detail'] = 'lut-buku-besar.detail';
                  $data['route_pdf'] = 'lut-buku-besar.pdf';
            } else {
                  $data['unit'] = 'Simpan Pinjam';
                  $data['route_post'] = 'lus-buku-besar';
                  $data['route_detail'] = 'lus-buku-besar.detail';
                  $data['route_pdf'] = 'lus-buku-besar.pdf';
            }
            return $data;
      }

      /**
       * Dokumentasi getCoaToBukuBesar
       *
       * Mengambil data akun pada tabel
       * coa berdasarkan id_coa
       *
       * @param mixed $id
       * @return mixed $data
       **/
      public function getCoaToBukuBesar($id, $unit)
      {
            $data = [];
            $coa = Coa::all();
            $coas = $coa->firstWhere('id_coa', $id);
            $data['coa'] = $coa;
            if (empty($coas)) {
                  $data['kode'] = '';
                  $data['nama'] = '';
                  $data['kategori'] = '';
            } else {
                  $data['kode'] = $coas->kode;
                  $data['nama'] = $coas->nama;
                  $data['kategori'] = $coas->kategori;
            }
            return $data;
      }

      /**
       * Dokumentasi getBukuBesar
       *
       * Mengambil data buku besar dari database.
       *
       * @param Type $var Description
       * @param mixed $id_coa
       * @param mixed $bulan
       * @param mixed $tahun
       * @param mixed $unit
       * @return \Illuminate\Database\Eloquent\Collection<array-key, 
       * \Illuminate\Database\Eloquent\Builder>
       **/
      public function getBukuBesar($id_coa, $bulan, $tahun, $unit, $keywords = null)
      {
            $buku_besar = Jurnal::with(['coa', 'transaksi'])
                  ->where('id_coa', $id_coa)
                  ->whereHas('transaksi', function ($query) use ($bulan, $tahun, $unit) {
                        $query->whereMonth('tgl_transaksi', $bulan)
                              ->whereYear('tgl_transaksi', $tahun)
                              ->where(function ($query) use ($unit) {
                                    $query->where('unit', $unit);
                              });
                  })
                  ->where(function ($query) use ($keywords) {
                        $query->where('posisi_dr_cr', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('nominal', 'LIKE', '%' . $keywords . '%')
                              ->orWhereHas('transaksi', function ($query) use ($keywords) {
                                    $query->where('tgl_transaksi', 'LIKE', '%' . $keywords . '%');
                              })
                              ->orWhereHas('coa', function ($query) use ($keywords) {
                                    $query->where('nama', 'LIKE', '%' . $keywords . '%')
                                          ->orWhere('kode', 'LIKE', '%' . $keywords . '%');
                              });
                  })->get();

            return $buku_besar;
      }

      /**
       * Dokumentasi getSaldoAwal
       *
       * Mengambil data saldo awal buku besar dari database berdasarkan
       * id coa, tanggal, dan unit.
       *
       * @param mixed $id_coa
       * @param mixed $date
       * @param mixed $unit
       * @return $saldo_awal
       **/
      public function getSaldoAwal($id_coa, $date, $unit)
      {
            $saldo_awal = Jurnal::with(['coa', 'transaksi'])
                  ->select('coa.header', DB::raw('SUM(IF(posisi_dr_cr = "debet", nominal, 0)) as total_debet'), DB::raw('SUM(IF(posisi_dr_cr = "kredit", nominal, 0)) as total_kredit'))
                  ->join('coa', 'jurnal.id_coa', '=', 'coa.id_coa')
                  ->where('jurnal.id_coa', $id_coa)
                  ->whereHas('transaksi', function ($query) use ($date, $unit) {
                        $query->whereDate('tgl_transaksi', '<', $date)
                              ->where(function ($query) use ($unit) {
                                    $query->where('unit', $unit);
                              });
                  })
                  ->groupBy('jurnal.id_jurnal', 'jurnal.id_coa', 'coa.header')
                  ->get();

            return $saldo_awal;
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
                  jurnal($model, $id_kredit, $id_transaksi, 'kredit', $total['inventaris']);
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
                  $subtotal = $d['subtotal'] ?? ($d['stok'] * $d['harga_barang']);

                  // Menggunakan array asosiatif untuk memetakan jenis_barang ke subtotalnya
                  $jenisBarangMapping = [
                        'Barang Konsumsi' => 'konsumsi',
                        'Barang Sandang' => 'sandang',
                        'Barang Kosmetik' => 'kosmetik',
                        'Barang ATM' => 'atm',
                        'Barang Elektronik' => 'elektronik',
                        'Barang Bangunan' => 'bangunan',
                  ];

                  // Menambahkan subtotal ke jenis barang yang sesuai
                  $jenisBarang = $d['jenis_barang'];
                  if (isset($jenisBarangMapping[$jenisBarang])) {
                        $totals[$jenisBarangMapping[$jenisBarang]] += $subtotal;
                  }

                  // Menambahkan subtotal ke persediaan
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
                  $subtotal = $d['subtotal'] ?? ($d['stok'] * $d['nilai_saat_ini']);
                  // Menggunakan array asosiatif untuk memetakan jenis_barang ke subtotalnya
                  $jenisBarangMapping = [
                        'Perlengkapan' => 'perlengkapan',
                        'Peralatan' => 'peralatan',
                        'Mesin' => 'mesin',
                        'Kendaraan' => 'kendaraan',
                        'Gedung' => 'gedung',
                        'Tanah' => 'tanah',
                  ];

                  // Menambahkan subtotal ke jenis barang yang sesuai
                  $jenisBarang = $d['jenis_barang'];
                  if (isset($jenisBarangMapping[$jenisBarang])) {
                        $totals[$jenisBarangMapping[$jenisBarang]] += $subtotal;
                  }

                  // Menambahkan subtotal ke inventaris
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

      /**
       * Dokumentasi getNeracaSaldo
       *
       * Mengambil data neraca dan kategori yang sudah
       * dikelola dalam bentuk array berdasarkan
       * parameter unit, bulan dan tahun .
       *
       * @param mixed $bulan
       * @param mixed $tahun
       * @param mixed $unit
       * @return array<int, mixed>[]
       **/
      public function getNeracaSaldo($bulan, $tahun, $unit)
      {
            if ($bulan == date('m') && $tahun == date('Y')) {
                  $hari = date('d');
            } else {
                  $hari = getTglHari($bulan, $tahun);
            }
            $neraca = self::getNeraca($hari, $bulan, $tahun, $unit);
            $collection = new ImportExportService;
            return [
                  'neraca' => $collection->getDataUnique($neraca, 'id_coa'),
                  'kategori' => $collection->getDataUnique($neraca, 'kategori')
            ];
      }

      /**
       * Dokumentasi getNeraca
       *
       * Mengambil data neraca dari database 
       * dengan parameter bulan,tahun dan hari.
       *
       * @param mixed $hari
       * @param mixed $bulan
       * @param mixed $tahun
       * @param mixed $unit
       * @return mixed
       **/
      public function getNeraca($hari, $bulan, $tahun, $unit)
      {
            return Jurnal::with(['coa', 'transaksi'])
                  ->select(
                        'coa.header',
                        'coa.kode',
                        'coa.kategori',
                        'coa.nama',
                        'jurnal.id_coa',
                        DB::raw('SUM(IF(posisi_dr_cr = "debet", nominal, 0)) as total_debet'),
                        DB::raw('SUM(IF(posisi_dr_cr = "kredit", nominal, 0)) as total_kredit')
                  )
                  ->join('coa', 'jurnal.id_coa', '=', 'coa.id_coa')
                  ->whereHas('transaksi', function ($query) use ($bulan, $tahun, $hari, $unit) {
                        $query->whereDate('tgl_transaksi', '<=', $tahun . '-' . $bulan . '-' . $hari)
                              ->where('unit', $unit);
                  })->groupBy('jurnal.id_coa', 'coa.header', 'coa.kode', 'coa.nama', 'coa.kategori')
                  ->get();
      }
}
