<?php

namespace App\Services;

use App\Models\Coa;
use App\Models\Barang;
use App\Models\Jurnal;
use App\Models\Anggota;
use App\Models\Transaksi;
use App\Models\Barang_eceran;
use App\Models\Main_penjualan;
use App\Models\Detail_penjualan;
use App\Models\Detail_penjualan_lain;
use App\Services\AccountingService;

class PenjualanService
{
      private $jurnalService;
      private $coaService;

      public function __construct()
      {
            $this->jurnalService = new AccountingService;
            $this->coaService = new CoaService;
      }

      public function getDetailPenyesuaian($request)
      {
            if ($request->input('cek_penjualan') === 'penyesuaian') {
                  $transaksiPenyesuaian = Transaksi::where('id_transaksi', $request->input("id_penjualan_penyesuaian"))->first();
                  $data = [
                        'idTransPeny' => $transaksiPenyesuaian->id_transaksi,
                        'invoicepny' => $transaksiPenyesuaian->kode,
                  ];
                  return $data;
            } else {
                  $data = [
                        'idTransPeny' => null,
                        'invoicepny' => null,
                  ];
                  return $data;
            }
      }

      public function updateBarangJualKadaluwarsa($idTransPeny)
      {
            $id_penjualan = Main_penjualan::where('id_transaksi', $idTransPeny)->value('id_penjualan');
            $detailKadaluwarsa = Detail_penjualan::where('id_penjualan', $id_penjualan)->get();
            foreach ($detailKadaluwarsa as $detail) {
                  if ($detail->jenis_barang === "grosir") {
                        $barangKadaluwarsa = Barang::where('id_barang', $detail->id_barang)->first();
                        if ($barangKadaluwarsa->id_barang === $detail->id_barang) {
                              $qtySebelum = $barangKadaluwarsa->stok + $detail->qty;
                              $dataSebelum = [
                                    'stok' => $qtySebelum,
                              ];
                              $barangKadaluwarsa->update($dataSebelum);
                        }
                  } else {
                        $barangKadaluwarsa = Barang_eceran::where('id_eceran', $detail->id_eceran)->first();
                        if ($barangKadaluwarsa->id_eceran === $detail->id_eceran) {
                              $qtySebelum = $barangKadaluwarsa->stok + $detail->qty;
                              $dataSebelum = [
                                    'stok' => $qtySebelum,
                              ];
                              $barangKadaluwarsa->update($dataSebelum);
                        }
                  }
            }
      }

      public function createTransaksi($request, $invoicepny, $imageName, $detailTransaksi)
      {
            //--input ke tabel transaksi--//
            Transaksi::create([
                  'kode' => $request->input('nomor'),
                  'kode_pny' => $invoicepny,
                  'no_bukti' => $request->input('no_bukti'),
                  'tipe' => $request->input('cek_penjualan'),
                  'tgl_transaksi' => $request->input('tgl_transaksi'),
                  'detail_tabel' => $detailTransaksi,
                  'jenis_transaksi' => $request->input('jenis_transaksi'),
                  'metode_transaksi' => $request->input('metode_transaksi'),
                  'nota_transaksi' => $imageName,
                  'tpk' => $request->input('tpk'),
                  'unit' => $request->input('unit'),
                  'total' => $request['total_transaksi'],
                  'keterangan' => self::getKeteranganTransaksi($request, $invoicepny)
            ]);
      }

      public function getKeteranganTransaksi($request, $invoicepny)
      {
            if ($request->input('keterangan') == null) {
                  if ($request->input('pembeli') === 'pegawai') {
                        $pembeli = Anggota::where('id_anggota', $request->input('pegawai_id'))->value('nama');
                  } else {
                        $pembeli = $request->input('nama_bukan_pegawai');
                  }
                  if ($invoicepny == null) {
                        $keterangan = 'Penjualan Barang TPK ' . $request->input('tpk') . ' kepada ' . $pembeli;
                  } else {
                        $keterangan = 'Penyesuaian Penjualan ' . $invoicepny . ' menjadi Penjualan Barang TPK ' . $request->input('tpk') . ' kepada ' . $pembeli;
                  }
                  return $keterangan;
            } else {
                  return $request->input('keterangan');
            }
      }

      public function validasiStokBarang($dataBarang, $id)
      {
            $data = json_decode($dataBarang, true);
            $pny = self::getDataPenyesuaianSblm($id);
            $stokTakCukup = 0;
            foreach ($data as $d) {
                  $barang = self::getDataBarang($d['id_barang'], $d['id_eceran']);
                  foreach ($pny as $p) {
                        if ($barang['jenis_barang'] == "grosir") {
                              if ($p['id_barang'] == $d['id_barang']) {
                                    if ($d['qty'] > $p['stok_sebelum']) {
                                          $stokTakCukup += 1;
                                    }
                              } else {
                                    if ($d['qty'] > $barang['stok']) {
                                          $stokTakCukup += 1;
                                    }
                              }
                        } else {
                              if ($p['id_eceran'] == $d['id_eceran']) {
                                    if ($d['qty'] > $p['stok_sebelum']) {
                                          $stokTakCukup += 1;
                                    }
                              } else {
                                    if ($d['qty'] > $barang['stok']) {
                                          $stokTakCukup += 1;
                                    }
                              }
                        }
                  }
            }
            return $stokTakCukup;
      }

      public function getDataBarang($id_barang, $id_eceran)
      {
            if ($id_eceran === "") {
                  $data['jenis_barang'] = 'grosir';
                  $data['id_barang'] = $id_barang;
                  $data['id_eceran'] = null;
                  $grosir = Barang::with('unit')->where('id_barang', $id_barang)->first();
                  $data['id_satuan'] = $grosir->id_satuan;
                  $data['stok'] = $grosir->stok;
                  $data['posisi_pi'] = $grosir->posisi_pi;
                  $data['kegunaan'] = $grosir->jenis_barang;
                  $data['nilai_buku'] = $grosir->nilai_saat_ini;
                  $data['harga_beli'] = $grosir->harga_barang;
            } else {
                  $data['jenis_barang'] = 'eceran';
                  $data['id_barang'] = null;
                  $data['id_eceran'] = $id_eceran;
                  $eceran = Barang_eceran::with(['barang', 'barang.unit'])->where('id_eceran', $id_eceran)->first();
                  $data['id_satuan'] = $eceran->id_satuan;
                  $data['stok'] = $eceran->stok;
                  $data['posisi_pi'] = $eceran->barang->posisi_pi;
                  $data['kegunaan'] = $eceran->barang->jenis_barang;
                  $data['nilai_buku'] = $eceran->nilai_saat_ini;
                  $data['harga_beli'] = $eceran->harga_barang;
            }
            return $data;
      }

      public function getDataPenyesuaianSblm($id)
      {
            $id_penjualan = Main_penjualan::where('id_transaksi', $id)->value('id_penjualan');
            $detail = Detail_penjualan::where('id_penjualan', $id_penjualan)->get();
            $result = [];
            foreach ($detail as $d) {
                  if ($d->jenis_barang === "grosir") {
                        $barangKadaluwarsa = Barang::where('id_barang', $d->id_barang)->first();
                        if ($barangKadaluwarsa->id_barang === $d->id_barang) {
                              $stokSebelum = $barangKadaluwarsa->stok + $d->qty;
                              $id_barang = $d->id_barang;
                              $id_eceran = null;
                        }
                  } else {
                        $barangKadaluwarsa = Barang_eceran::where('id_eceran', $d->id_eceran)->first();
                        if ($barangKadaluwarsa->id_eceran === $d->id_eceran) {
                              $stokSebelum = $barangKadaluwarsa->stok + $d->qty;
                              $id_barang = null;
                              $id_eceran = $d->id_eceran;
                        }
                  }
                  array_push($result, [
                        'id_barang' => $id_barang,
                        'id_eceran' => $id_eceran,
                        'stok_sebelum' => $stokSebelum,
                  ]);
            }
            return $result;
      }

      public function getPenyesuaianPenjualanBarang($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Penjualan Barang');
                  })->get();
            return $penyesuaian;
      }

      public function getPenyesuaianPenjualanLainnya($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Penjualan Lainnya');
                  })->get();
            return $penyesuaian;
      }

      public function getDataPenjualan($unit, $route = null, $keywords = null)
      {
            $detailPenjualan = self::getDetailPenjualan($unit, $keywords);
            $penjualan = self::getPenjualan($detailPenjualan);
            return $penjualan;
      }

      public function getDetailPenjualan($unit, $keywords = null)
      {
            return Transaksi::where('unit', $unit)
                  ->where(function ($query) {
                        $query->where('jenis_transaksi', 'Penjualan Barang');
                  })
                  ->orWhere(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Penjualan Lainnya');
                  })
                  ->where(function ($query) use ($keywords) {
                        $query->where('kode', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('tgl_transaksi', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('keterangan', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('total', 'LIKE', '%' . $keywords . '%');
                  })->get();
      }

      public function getPenjualan($detailPenjualan)
      {
            $penjualan = [];
            foreach ($detailPenjualan as $p) {
                  $status = Main_penjualan::where('id_transaksi', $p->id_transaksi)->value('status_penjualan');
                  array_push($penjualan, [
                        'id_transaksi' => $p->id_transaksi,
                        'detail_tabel' => $p->detail_tabel,
                        'jenis_transaksi' => $p->jenis_transaksi,
                        'kode' => $p->kode,
                        'tipe' => $p->tipe,
                        'tgl_transaksi' => $p->tgl_transaksi,
                        'keterangan' => $p->keterangan,
                        'total' => $p->total,
                        'status' => $status
                  ]);
            }
            return $penjualan;
      }

      public function getBarang($unit, $tpk)
      {
            return Barang::with(['unit', 'satuan'])
                  ->whereHas('unit', function ($query) use ($unit, $tpk) {
                        $query->where('nama', 'LIKE', "%" . $tpk . "%")
                              ->where('unit', 'LIKE', '%' . $unit . '%');
                  })->get();
      }

      /**
       * Mengambil nilai tpk berdasarkan routeName
       *
       * @param mixed $route
       * 
       **/
      public function getTpk($route)
      {
            $data = [
                  'ptk-penjualan.create-barang-lrtk' => 'Larantuka',
                  'ptk-penjualan.create-barang-wrg' => 'Waiwerang',
                  'ptk-penjualan.create-barang-psr' => 'Pasar Baru',
                  'ptk-penjualan.create-lainnya-lrtk' => 'Larantuka',
                  'ptk-penjualan.create-lainnya-wrg' => 'Waiwerang',
                  'ptk-penjualan.create-lainnya-psr' => 'Pasar Baru',
            ];
            return $data[$route];
      }

      public function getBarangEceran($unit, $tpk)
      {
            return Barang_eceran::with(['satuan', 'barang', 'barang.unit'])
                  ->OrderBy('id_eceran', 'asc')
                  ->whereHas('barang', function ($query) use ($unit, $tpk) {
                        $query->whereHas('unit', function ($query) use ($unit, $tpk) {
                              $query->where('nama', 'LIKE', "%" . $tpk . "%")
                                    ->where('unit', 'LIKE', '%' . $unit . '%');
                        });
                  })->get();
      }

      public function createDetailTransaksi($request, $id_transaksi)
      {
            self::createMainPenjualan($request, $id_transaksi);
            $id_penjualan = Main_penjualan::where('id_transaksi', $id_transaksi)->value('id_penjualan');
            if ($request['jenis_transaksi'] === 'Penjualan Barang') {
                  $data = json_decode($request['data_barang'], true);
                  self::createDetailPenjualanBarang($data, $id_penjualan);
                  self::updateStokBarang($data);
            } else {
                  self::createDetailPenjualanLain($request['data'], $id_penjualan);
            }
      }

      public function createDetailPenjualanBarang($data, $id_penjualan)
      {
            foreach ($data as $datum) {
                  $barang = self::getDataBarang($datum['id_barang'], $datum['id_eceran']);
                  Detail_penjualan::create([
                        'id_penjualan' => $id_penjualan,
                        'jenis_barang' => $barang['jenis_barang'],
                        'id_barang' => $barang['id_barang'],
                        'id_eceran' => $barang['id_eceran'],
                        'id_satuan' => $barang['id_satuan'],
                        'qty' => $datum['qty'],
                        'harga' => $datum['harga'],
                        'subtotal' => $datum['subtotal']
                  ]);
            }
      }

      public function createDetailPenjualanLain($data, $id)
      {
            foreach ($data as $datum) {
                  Detail_penjualan_lain::create([
                        'id_penjualan' => $id,
                        'id_satuan' => $datum['satuan'],
                        'jenis' => $datum['jenis'],
                        'nama' => $datum['nama'],
                        'qty' => $datum['kuantitas'],
                        'harga' => convertToNumber($datum['harga']),
                        'subtotal' => convertToNumber($datum['total'])
                  ]);
            }
      }

      public function createMainPenjualan($request, $id_transaksi)
      {
            $status = isset($request['pembeli']) && $request['pembeli'] == 'non-pegawai' ? 'bukan pegawai' : 'pegawai';
            $jenis_transaksi = isset($request['metode_transaksi']) && $request['metode_transaksi'] != 'Piutang' ? 'debet' : 'kredit';
            $status_transaksi = isset($request['metode_transaksi']) && $request['metode_transaksi'] != 'Piutang' ? 'lunas' : 'belum terbayar';

            $total = Transaksi::where('id_transaksi', $id_transaksi)->value('total') ?? 0;
            $data = [
                  'id_transaksi' => $id_transaksi,
                  'status_pembeli' => $status,
                  'id_anggota' => $request['pegawai_id'] ?? null,
                  'nama_bukan_anggota' => $request['nama_bukan_pegawai'] ?? null,
                  'jenis_penjualan' => $jenis_transaksi,
                  'status_penjualan' => $status_transaksi,
                  'jumlah_penjualan' => $total,
                  'saldo_piutang' => $jenis_transaksi == 'kredit' ? $total : 0,
            ];

            Main_penjualan::create($data);
      }


      public function updateStokBarang($data)
      {
            foreach ($data as $d) {
                  $barang = self::getDataBarang($d['id_barang'], $d['id_eceran']);
                  $stok = $barang['stok'] - $d['qty'];
                  if ($barang['jenis_barang'] === 'eceran') {
                        $e = [
                              'stok' => $stok
                        ];
                        Barang_eceran::where('id_eceran', $d['id_eceran'])->update($e);
                  } else {
                        $g = [
                              'stok' => $stok
                        ];
                        Barang::where('id_barang', $d['id_barang'])->update($g);
                  }
            }
      }


      /**
       * Deklarasi variabel untuk input jurnal penjualan barang
       * untuk menginput jurnal pembalik dan jurnal baru
       *
       * @param mixed $request
       * @param mixed $id_transaksi
       * @param mixed $idTransPeny
       * @return void
       **/
      public function createJurnalBarang($request, $id_transaksi, $idTransPeny)
      {
            $id_debet = $this->coaService->getIdDebet($request);
            $data = json_decode($request['data_barang'], true);

            /*Input Jurnal*/
            /*jurnal pembalik*/
            if ($request['cek_penjualan'] === 'penyesuaian') {
                  jurnalPembalik(new Jurnal, $id_transaksi, $idTransPeny);
            }
            /*jurnal baru*/
            $this->jurnalService->jurnalPenjualanPersediaan($data, $id_debet, $id_transaksi);
            $this->jurnalService->jurnalPenjualanInventaris($data, $id_debet, $id_transaksi);
      }

      /**
       * Deklarasi variabel untuk input jurnal penjualan lainnya
       * untuk menginput jurnal pembalik dan jurnal baru
       *
       * @param mixed $request
       * @param mixed $id_transaksi
       * @param mixed $idTransPeny
       * @return void
       **/
      public function createJurnal($request, $id_transaksi, $idTransPeny)
      {
            $id_debet = $this->coaService->getIdDebet($request);
            $model = new Jurnal;
            /*jurnal pembalik*/
            if ($request['cek_penjualan'] === 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $idTransPeny);
            }
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $request['id_kredit'], $id_transaksi, 'kredit', $request["total_transaksi"]);
      }

      public function getDetailPenjualanBarang($id)
      {
            $id_penjualan = Main_penjualan::where('id_transaksi', $id)->value('id_penjualan');
            $transaksi = Detail_penjualan::with(['satuan', 'barang', 'barang_eceran', 'barang_eceran.barang'])
                  ->where('id_penjualan', $id_penjualan)
                  ->get();
            $penjualan = [];
            foreach ($transaksi as $t) {
                  if ($t->jenis_barang === 'grosir') {
                        $nama = $t->barang->nama_barang;
                        $jenis = $t->barang->jenis_barang;
                  } else {
                        $nama = $t->barang_eceran->barang->nama_barang;
                        $jenis = $t->barang_eceran->barang->jenis_barang;
                  }

                  array_push($penjualan, [
                        'nama' => $nama,
                        'jenis' => $jenis,
                        'satuan' => $t->satuan->nama_satuan,
                        'qty' => $t->qty,
                        'harga' => $t->harga,
                        'subtotal' => $t->subtotal
                  ]);
            }

            return $penjualan;
      }

      public function getDetailPenjualanLainnya($id)
      {
            $id_penjualan = Main_penjualan::where('id_transaksi', $id)->value('id_penjualan');
            $transaksi = Detail_penjualan_lain::with(['satuan'])
                  ->where('id_penjualan', $id_penjualan)
                  ->get();
            $penjualan = [];
            foreach ($transaksi as $t) {
                  array_push($penjualan, [
                        'nama' => $t->nama,
                        'jenis' => $t->jenis,
                        'satuan' => $t->satuan->nama_satuan,
                        'qty' => $t->qty,
                        'harga' => $t->harga,
                        'subtotal' => $t->subtotal
                  ]);
            }

            return $penjualan;
      }
}
