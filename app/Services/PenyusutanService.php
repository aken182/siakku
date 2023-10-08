<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Coa;
use App\Models\Barang;
use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Models\Barang_eceran;
use App\Models\Detail_penyusutan;
use App\Services\AccountingService;
use Illuminate\Support\Facades\Validator;

class PenyusutanService
{
      private $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }

      /**
       * Mengambil unit berdasarkan 
       * nama route sekarang
       *
       * @param mixed $route
       * @return string
       **/
      public function getUnit($route)
      {
            $unit = [
                  'penyusutan-toko' => 'Pertokoan',
                  'penyusutan-sp' => 'Simpan Pinjam',
            ];

            // Menghapus bagian yang sama dalam kunci
            $route = str_replace([
                  '.list', '.invoice', '.step-satu', '.store-satu', '.step-dua', '.store-dua',
                  '.step-tiga', '.store-tiga', '.store-empat', '.show', '.detail'
            ], '', $route);

            return $unit[$route];
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
                  'penyusutan-toko.list' => 'penyusutan-toko.show',
                  'penyusutan-sp.list' => 'penyusutan-sp.show',
            ];
            return $store[$route];
      }

      /**
       * Mengambil route utama dari transaksi 
       * penyusutan
       *
       * @param mixed $unit
       * @return string
       **/
      public function getMainRoute($unit)
      {
            $route = [
                  'Pertokoan' => 'penyusutan-toko',
                  'Simpan Pinjam' => 'penyusutan-sp'
            ];
            return $route[$unit];
      }

      public function getInventaris($unit)
      {
            return Barang::with(['satuan', 'unit'])->where('posisi_pi', 'inventaris')
                  ->whereHas('unit', function ($query) use ($unit) {
                        $query->where('unit', $unit);
                  })->get();
      }

      public function getUnitInventaris($inventaris)
      {
            $unique = $inventaris->unique('id_unit');
            $unit = $unique->values()->all();
            return $unit;
      }

      public function getPenyesuaianInvoice($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit) {
                        $query->where('jenis_transaksi', 'Penyusutan')
                              ->where('unit', $unit);
                  })->get();
            return $penyesuaian;
      }

      public function getDataPenyesuaian($request)
      {
            if ($request->input('cek_penyusutan') == 'penyesuaian') {
                  $invoice_penyesuaian = Transaksi::where('id_transaksi', $request->input('id_penyusutan_penyesuaian'))->value('kode');
                  $id_transaksi_penyesuaian = $request->input('id_penyusutan_penyesuaian');
            } else {
                  $invoice_penyesuaian = null;
                  $id_transaksi_penyesuaian = null;
            }
            $data = [
                  'id_transaksi_penyesuaian' => $id_transaksi_penyesuaian,
                  'invoice_penyesuaian' => $invoice_penyesuaian,
                  'tipe' => $request->input('cek_penyusutan'),
            ];
            return $data;
      }

      public function getInvoice($unit)
      {
            $model = new Transaksi;
            $prefix = $unit === 'Simpan Pinjam' ? 'PNYI-SP-' : 'PNYI-TK-';
            $column = 'kode';
            return kode($model, $prefix, $column);
      }

      public function createTransaksi($nomor, $details, $tanggal, $penyesuaian, $unit)
      {
            Transaksi::create([
                  'kode' => $nomor,
                  'kode_pny' => $penyesuaian['invoice_penyesuaian'],
                  'tgl_transaksi' => self::getTanggalTransaksi($tanggal),
                  'detail_tabel' => 'detail_penyusutan',
                  'unit' => $unit,
                  'jenis_transaksi' => 'Penyusutan',
                  'metode_transaksi' => 'Depresiasi',
                  'total' => self::getTotalTransaksi($details),
                  'tipe' => $penyesuaian['tipe'],
                  'tpk' => 'Larantuka',
                  'keterangan' => $penyesuaian['tipe'] === 'penyesuaian' ? 'Penyesuaian Penyusutan Inventaris' : 'Penyusutan Inventaris'
            ]);
      }

      public function getTitleTipe($tipe)
      {
            $data = [
                  'baru' => 'normal',
                  'penyesuaian' => 'penyesuaian',
                  'kadaluwarsa' => 'kadaluwarsa',
            ];
            return $data[$tipe];
      }

      public function createDetailTransaksi($details, $id_transaksi)
      {
            foreach ($details as $d) {
                  $barang = Barang::where('id_barang', $d['id'])->first();
                  $id_barang = $barang->id_barang;
                  $id_satuan = $barang->id_satuan;
                  if ($d['status'] == 'S') {
                        $konversi = Barang_eceran::where('id_barang', $d['id'])->first();
                        $id_konversi = $konversi->id_eceran;
                        $id_satuan_eceran = $konversi->id_satuan;
                        self::createDetailPenyusutan($id_transaksi, $id_barang, $id_satuan_eceran, $d['stok_e'], $d['nilai_buku_se'], $d['nilai_penyusutan_e'], $d['subtotal_e'], $id_konversi);
                        self::createDetailPenyusutan($id_transaksi, $id_barang, $id_satuan, $d['stok'], $d['nilai_buku_s'], $d['nilai_penyusutan'], $d['subtotal']);
                        self::updateBarangEceran($konversi, $d['nilai_buku_se']);
                        self::updateBarangGrosir($id_barang, $d['nilai_buku_s']);
                  } else {
                        self::createDetailPenyusutan($id_transaksi, $id_barang, $id_satuan, $d['stok'], $d['nilai_buku_s'], $d['nilai_penyusutan'], $d['subtotal']);
                        self::updateBarangGrosir($id_barang, $d['nilai_buku_s']);
                  }
            }
      }

      public function createDetailPenyusutan($id_transaksi, $id_barang, $id_satuan, $stok, $nilai_buku, $nilai_penyusutan, $subtotal, $id_konversi = null)
      {
            Detail_penyusutan::create([
                  'id_transaksi' => $id_transaksi,
                  'id_barang' => $id_barang,
                  'id_eceran' => $id_konversi,
                  'id_satuan' => $id_satuan,
                  'qty' => $stok,
                  'harga_brg_sekarang' => $nilai_buku,
                  'harga_penyusutan' => $nilai_penyusutan,
                  'subtotal' => $subtotal
            ]);
      }

      public function updateBarangEceran($konversi, $nilai_buku)
      {
            $dataEceran = [
                  'nilai_saat_ini' => $nilai_buku
            ];
            $konversi->update($dataEceran);
      }

      public function updateBarangGrosir($id_barang, $nilai_buku)
      {
            $barang = Barang::find($id_barang);
            $barang->nilai_saat_ini = $nilai_buku;
            $barang->save();
      }

      public function getTanggalTransaksi($tanggal)
      {
            $tanggal_carbon = Carbon::createFromFormat('d/m/Y', $tanggal);
            return $tanggal_carbon->format('Y-m-d');
      }

      public function getTotalTransaksi($details)
      {
            $detail = collect($details);
            return $detail->sum('total');
      }

      public function getDetail($i, $id_transaksi, $tipe)
      {
            $inventaris = [];

            $barangs = Barang::with(['unit', 'satuan'])->whereIn('id_barang', $i)->get();

            foreach ($barangs as $barang) {
                  $status = $barang->status_konversi;
                  list($harga_e, $satuan_e, $stok_e, $nilai_buku_e) = $this->getKonversiData($status, $barang->id_barang);

                  $nilai = $this->getNilaiBukuSebelum($tipe, $barang->id_barang, $id_transaksi, $barang->nilai_saat_ini, $nilai_buku_e);

                  $inventaris[] = [
                        'id' => $barang->id_barang,
                        'kode' => $barang->kode_barang,
                        'nama' => $barang->nama_barang,
                        'tgl_beli' => $barang->tgl_beli,
                        'harga' => $barang->harga_barang,
                        'jenis' => $barang->jenis_barang,
                        'unit' => $barang->unit->nama,
                        'unit_induk' => $barang->unit->unit,
                        'satuan' => $barang->satuan->nama_satuan,
                        'umur' => $barang->umur_ekonomis,
                        'nilai_buku' => $nilai['grosir'],
                        'stok' => $barang->stok,
                        'harga_e' => $harga_e,
                        'nilai_buku_e' => $nilai['eceran'],
                        'stok_e' => $stok_e,
                        'satuan_e' => $satuan_e,
                        'status' => $status
                  ];
            }

            return $inventaris;
      }

      private function getKonversiData($status, $id_barang)
      {
            if ($status == 'S') {
                  $konversi = Barang_eceran::with(['satuan'])->where('id_barang', $id_barang)->first();
                  return [
                        'harga_e' => $konversi->harga_barang,
                        'satuan_e' => $konversi->satuan->nama_satuan,
                        'stok_e' => $konversi->stok,
                        'nilai_buku_e' => $konversi->nilai_saat_ini
                  ];
            } else {
                  return ['-', '-', '-', '-'];
            }
      }


      /*penyusutan asset*/
      public function getNilaiBukuSebelum($tipe, $id_barang, $id_transaksi, $nilai_saat_ini, $nilai_saat_ini_e)
      {
            $nilai = [
                  'grosir' => $nilai_saat_ini,
                  'eceran' => $nilai_saat_ini_e,
            ];
            if ($tipe == 'penyesuaian') {
                  $details = Detail_penyusutan::where('id_transaksi', $id_transaksi)
                        ->where('id_barang', $id_barang)->get();
                  foreach ($details as $detail) {
                        if ($detail->id_konversi != null) {
                              $nilai['eceran'] += $detail->harga_penyusutan;
                        } else {
                              $nilai['grosir'] += $detail->harga_penyusutan;
                        }
                  }
            }
            return $nilai;
      }

      public function validasiStepDua($request)
      {
            return Validator::make($request->all(), [
                  'tgl_transaksi' => 'required',
            ], [
                  'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            ]);
      }

      public function getDataStoreDua($request)
      {
            $penyesuaian = json_decode($request->input('penyesuaian'), true);
            $detailPenyusutan = $this->getDetailPenyusutan($request->input('data'), $request->input('tgl_transaksi'), $penyesuaian['id_transaksi_penyesuaian'], $penyesuaian['tipe']);
            $data = [
                  "title" => "Penyusutan Inventaris",
                  "title2" => "Form Penyusutan",
                  "inventaris" => $request->input('id_inventaris'),
                  "penyusutans" => $detailPenyusutan,
                  "tgl_transaksi" => $request->input('tgl_transaksi'),
                  "penyesuaian" => $request->input('penyesuaian'),
                  "coas" => self::getCoaPenyusutan(),
                  "data_prev" => self::buatDataSebelumnya($request, $detailPenyusutan),
                  "step" => 'tiga'
            ];
            return $data;
      }

      public function getDetailPenyusutan($data, $tgl_transaksi, $id_penyesuaian, $tipe)
      {
            $tanggal = date('Y-m-d', strtotime($tgl_transaksi));
            $tahunSekarang = date('Y', strtotime($tanggal));
            $inventaris = [];
            foreach ($data as $key) {
                  if ($key['keterangan'] == 'Inventaris dapat disusutkan.') {
                        $barang = Barang::with(['unit', 'satuan'])->where('id_barang', $key['id_inventaris'])->first();
                        $tahunBeli = date('Y', strtotime($barang->tgl_beli));
                        $status = $barang->status_konversi;
                        if ($status == 'S') {
                              $konversi = Barang_eceran::with(['barang', 'satuan'])->where('id_barang', $key['id_inventaris'])->first();
                              $harga_e = $konversi->harga_barang;
                              $satuan_e = $konversi->satuan->nama_satuan;
                              $stok_e = $konversi->stok;
                              $nilai_buku_e = $konversi->nilai_saat_ini;
                              $nilai = self::getNilaiBukuSebelum($tipe, $barang->id_barang, $id_penyesuaian, $barang->nilai_saat_ini, $nilai_buku_e);
                              $penyusutan_e = self::hitungPenyusutan($tahunSekarang, $tahunBeli, $barang->umur_ekonomis, $konversi->harga_barang, $nilai['eceran']);
                              $nilaiBukuSekarangEceran = $penyusutan_e['nilai_buku'];
                              $nilaiPenyusutanEceran = $penyusutan_e['penyusutan'];
                              $penyusutan = self::hitungPenyusutan($tahunSekarang, $tahunBeli, $barang->umur_ekonomis, $barang->harga_barang, $nilai['grosir']);
                              $nilaiBukuSekarang = $penyusutan['nilai_buku'];
                              $nilaiPenyusutan = $penyusutan['penyusutan'];
                        } else {
                              $harga_e = $satuan_e = $nilai_buku_e = $nilaiBukuSekarangEceran = '-';
                              $nilai = self::getNilaiBukuSebelum($tipe, $barang->id_barang, $id_penyesuaian, $barang->nilai_saat_ini, $nilai_buku_e);
                              $penyusutan = self::hitungPenyusutan($tahunSekarang, $tahunBeli, $barang->umur_ekonomis, $barang->harga_barang, $nilai['grosir']);
                              $nilaiBukuSekarang = $penyusutan['nilai_buku'];
                              $nilaiPenyusutan = $penyusutan['penyusutan'];
                              $nilaiPenyusutanEceran =  $stok_e = 0;
                        }
                        $totalPenyusutan = $nilaiPenyusutan + $nilaiPenyusutanEceran;
                        array_push($inventaris, [
                              'id' => $key['id_inventaris'],
                              'kode' => $barang->kode_barang,
                              'nama' => $barang->nama_barang,
                              'harga' => $barang->harga_barang,
                              'tgl_beli' => $barang->tgl_beli,
                              'jenis' => $barang->jenis_barang,
                              'unit' => $barang->unit->nama,
                              'unit_induk' => $barang->unit->unit,
                              'satuan' => $barang->satuan->nama_satuan,
                              'umur' => $barang->umur_ekonomis,
                              'nilai_buku' => $nilai['grosir'],
                              'stok' => $barang->stok,
                              'harga_e' => $harga_e,
                              'nilai_buku_e' => $nilai['eceran'],
                              'stok_e' => $stok_e,
                              'satuan_e' => $satuan_e,
                              'nilai_buku_s' => $nilaiBukuSekarang,
                              'nilai_buku_se' => $nilaiBukuSekarangEceran,
                              'nilai_penyusutan' => $nilaiPenyusutan,
                              'nilai_penyusutan_e' => $nilaiPenyusutanEceran,
                              'total_penyusutan' => $totalPenyusutan,
                              'subtotal_e' => $stok_e * $nilaiPenyusutanEceran,
                              'subtotal' => $barang->stok * $nilaiPenyusutan,
                              'status' => $status
                        ]);
                  }
            }
            return $inventaris;
      }

      public function getCoaPenyusutan()
      {
            return Coa::where('nama', 'LIKE', "%Penyusutan%")
                  ->where('kategori', 'Depresiasi dan Amortisasi')->get();
      }

      public function hitungPenyusutan($tahunSekarang, $tahunBeli, $umur_ekonomis, $harga_beli, $nilai_saat_ini)
      {
            $tahunBerjalan = $tahunSekarang - $tahunBeli;

            if ($tahunBerjalan < $umur_ekonomis) {
                  $nilaiSaatIni = $harga_beli * (1 - $tahunBerjalan / $umur_ekonomis);
                  $nilaiPenyusutan = $nilai_saat_ini - $nilaiSaatIni;
                  $data = [
                        'nilai_buku' => $nilaiSaatIni,
                        'penyusutan' => $nilaiPenyusutan,
                  ];
            } else {
                  $data = [
                        'nilai_buku' => $nilai_saat_ini,
                        'penyusutan' => 0,
                  ];
            }
            return $data;
      }

      public function buatDataSebelumnya($request, $detailPenyusutan)
      {
            $data = [
                  "requestInput" => $request->input('id_inventaris'),
                  "detailPenyusutan" => $detailPenyusutan,
                  "requestTglTransaksi" => $request->input('tgl_transaksi'),
                  "requestPenyesuaian" => json_decode($request->input('penyesuaian'), true)
            ];

            return json_encode($data);
      }

      public function getKonvertDataPrev($dataJson)
      {
            $data = json_decode($dataJson, true);
            return $data;
      }

      public function getDetailTransaksi($data)
      {
            $detail = [];
            foreach ($data as $d) {
                  if ($d['total_penyusutan'] > 0) {
                        array_push($detail, [
                              'id' => $d['id'],
                              'nama' => $d['nama'],
                              'jenis' => $d['jenis'],
                              'unit' => $d['unit'],
                              'harga' => $d['harga'],
                              'harga_e' => $d['harga_e'],
                              'stok' => $d['stok'],
                              'stok_e' => $d['stok_e'],
                              'satuan' => $d['satuan'],
                              'satuan_e' => $d['satuan_e'],
                              'nilai_buku_s' => $d['nilai_buku_s'],
                              'nilai_buku_se' => $d['nilai_buku_se'],
                              'nilai_penyusutan' => $d['nilai_penyusutan'],
                              'nilai_penyusutan_e' => $d['nilai_penyusutan_e'],
                              'total_penyusutan' => $d['total_penyusutan'],
                              'subtotal' => $d['subtotal'],
                              'subtotal_e' => $d['subtotal_e'],
                              'total' => $d['subtotal_e'] + $d['subtotal'],
                              'status' => $d['status']
                        ]);
                  }
            }
            return $detail;
      }

      public function getDataStoreTiga($request, $detailTransaksi, $penyesuaian)
      {
            $data = [
                  "title" => "Penyusutan Inventaris",
                  "title2" => "Form Penyusutan",
                  "tipe" => $penyesuaian['tipe'],
                  "invoice_penyesuaian" => $penyesuaian['invoice_penyesuaian'],
                  "id_penyesuaian" => $penyesuaian['id_transaksi_penyesuaian'],
                  "data_prev" => $request->input('data_prev'),
                  "tgl_transaksi" => self::getTanggalFormat($request->input('tgl_transaksi')),
                  "detail" => $detailTransaksi,
                  "jurnalPny" => self::getViewJurnalPenyesuaian($penyesuaian['id_transaksi_penyesuaian']),
                  "jurnal" => $this->accountingService->getDetailJurnalPenyusutan($request->input('data'), $detailTransaksi),
                  "step" => 'empat'
            ];
            return $data;
      }

      public function getTanggalFormat($tgl)
      {
            $tanggal = date('Y-m-d', strtotime($tgl));
            return date('d/m/Y', strtotime($tanggal));
      }

      public function getViewJurnalPenyesuaian($id)
      {
            return Jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id)
                  ->orderBy('id_jurnal', 'desc')->get();
      }

      public function getDataStepTiga($dataprev)
      {
            return [
                  "title" => "Penyusutan Inventaris",
                  "title2" => "Form Penyusutan",
                  "inventaris" => $dataprev['requestInput'],
                  "penyesuaian" => json_encode($dataprev['requestPenyesuaian']),
                  "penyusutans" => $dataprev['detailPenyusutan'],
                  "tgl_transaksi" => $dataprev['requestTglTransaksi'],
                  "coas" => self::getCoaPenyusutan(),
                  "data_prev" => json_encode($dataprev),
                  "step" => 'tiga'
            ];
      }

      public function createJurnal($jurnal, $jurnalpny, $id_transaksi, $idTransPny, $tipe)
      {
            $modelJurnal = new Jurnal;

            if ($tipe == 'penyesuaian') {
                  self::jurnalPembalikPenyusutan($modelJurnal, $jurnalpny, $id_transaksi, $idTransPny);
            }

            foreach ($jurnal as $j) {
                  $id_debet = Coa::where('kode', $j['kode_debet'])->value('id_coa');
                  $id_kredit = Coa::where('kode', $j['kode_kredit'])->value('id_coa');
                  jurnal($modelJurnal, $id_debet, $id_transaksi, 'debet', $j['nominal']);
                  jurnal($modelJurnal, $id_kredit, $id_transaksi, 'kredit', $j['nominal']);
            }
      }

      public function jurnalPembalikPenyusutan($model, $jurnalpny, $id_transaksi, $idTransPny)
      {
            foreach ($jurnalpny as $d) {
                  if ($d['posisi_dr_cr'] == 'kredit') {
                        jurnal($model, $d['id_coa'], $id_transaksi, 'debet', $d['nominal']);
                  } else {
                        jurnal($model, $d['id_coa'], $id_transaksi, 'kredit', $d['nominal']);
                  }
            }
            $transaksi = Transaksi::find($idTransPny);
            $transaksi->tipe = 'kadaluwarsa';
            $transaksi->save();
      }
}
