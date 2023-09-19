<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\Penyedia;
use App\Models\Transaksi;
use App\Models\Main_belanja;
use App\Models\Detail_belanja_barang;
use App\Models\Detail_belanja_operasionallain;
use App\Models\Jurnal;
use App\Models\Unit;

class BelanjaService
{
      private $barangService;
      private $coaService;
      private $accountingService;
      private $pelunasanService;

      public function __construct()
      {
            $this->barangService = new BarangService;
            $this->coaService = new CoaService;
            $this->accountingService = new AccountingService;
            $this->pelunasanService = new PelunasanService;
      }

      /**
       * Mengambil unit transaksi belanja
       * barang
       * 
       **/
      public function getUnit($route)
      {
            $unit = [
                  'btk-belanja-barang' => 'Pertokoan',
                  'bsp-belanja-barang' => 'Simpan Pinjam',
            ];
            // Menghapus bagian yang sama dalam kunci
            $route = str_replace(['.list', '.store', '.create-lrtk', '.create-psr', '.create-wrg', '.show', '.detail'], '', $route);
            return $unit[$route];
      }

      /**
       * Mengambil unit transaksi belanja
       * 
       **/
      public function getUnitBelanja($route)
      {
            $unit = [
                  'btk-belanja-lain' => 'Pertokoan',
                  'bsp-belanja-lain' => 'Simpan Pinjam',
            ];
            // Menghapus bagian yang sama dalam kunci
            $route = str_replace(['.list', '.store', '.create', '.show', '.detail'], '', $route);
            return $unit[$route];
      }

      /**
       * Mengambil route utama transaksi belanja
       * barang
       * 
       **/
      public function getMainRoute($unit)
      {
            $route = [
                  'Pertokoan' => 'btk-belanja-barang',
                  'Simpan Pinjam' => 'bsp-belanja-barang',
            ];
            return $route[$unit];
      }

      /**
       * Mengambil route utama transaksi belanja
       * barang
       * 
       **/
      public function getMainRouteBelanja($unit)
      {
            $route = [
                  'Pertokoan' => 'btk-belanja-lain',
                  'Simpan Pinjam' => 'bsp-belanja-lain',
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
      public function getRouteShowToTable($route)
      {
            $store = [
                  'btk-belanja-barang.list' => 'btk-belanja-barang.show',
                  'bsp-belanja-barang.list' => 'bsp-belanja-barang.show',
                  'btk-belanja-lain.list' => 'btk-belanja-lain.show',
                  'bsp-belanja-lain.list' => 'bsp-belanja-lain.show',
            ];
            return $store[$route];
      }

      /**
       * Mengambil data grup tombol tambah pengadaan
       * persediaan
       *
       **/
      public function getDataButtonGroupPersediaan($route)
      {
            return [
                  'title' => 'Pengadaan Persediaan',
                  'createLarantuka' => route($route . '.create-lrtk', ['jenis' => 'persediaan']),
                  'createWaiwerang' => route($route . '.create-wrg', ['jenis' => 'persediaan']),
                  'createPasarBaru' => route($route . '.create-psr', ['jenis' => 'persediaan']),
            ];
      }

      /**
       * Mengambil data grup tombol tambah pengadaan
       * inventaris
       *
       **/
      public function getDataButtonGroupInventaris($route)
      {
            return [
                  'title' => 'Pengadaan Inventaris',
                  'createLarantuka' => route($route . '.create-lrtk', ['jenis' => 'inventaris']),
                  'createWaiwerang' => route($route . '.create-wrg', ['jenis' => 'inventaris']),
                  'createPasarBaru' => route($route . '.create-psr', ['jenis' => 'inventaris']),
            ];
      }

      public function getPenyesuaianBelanjaBarang($unit, $jenis)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit, $jenis) {
                        $query->where('unit', $unit)
                              ->where('detail_tabel', 'detail_belanja_' . $jenis)
                              ->where('jenis_transaksi', 'Pengadaan Barang');
                  })->get();
            return $penyesuaian;
      }

      public function getPenyesuaianBelanja($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('detail_tabel', 'detail_belanja_operasional')
                              ->where('jenis_transaksi', 'Belanja');
                  })->get();
            return $penyesuaian;
      }

      /**
       * Mengambil nilai tpk berdasarkan routeName
       *
       * @param mixed $route
       * 
       **/
      public function getTpk($route)
      {
            $tpk = [
                  'lrtk' => 'Larantuka',
                  'wrg' => 'Waiwerang',
                  'psr' => 'Pasar Baru',
            ];
            // Menghapus bagian yang sama dalam kunci
            $route = str_replace(['btk-belanja-barang.create-', 'bsp-belanja-barang.create-'], '', $route);
            return $tpk[$route];
      }

      public function updateBarangKadaluwarsa($idTransPeny)
      {
            $id_belanja = Main_belanja::where('id_transaksi', $idTransPeny)->value('id_belanja');
            $detailKadaluwarsa = Detail_belanja_barang::where('id_belanja', $id_belanja)->get();
            foreach ($detailKadaluwarsa as $detail) {
                  $barangKadaluwarsa = Barang::where('id_barang', $detail->id_barang)->first();
                  if ($barangKadaluwarsa->id_barang === $detail->id_barang) {
                        $qtySebelum = $barangKadaluwarsa->stok - $detail->qty;
                        $qtySebelumfix = $qtySebelum < 0 ? null : $qtySebelum;
                        $dataSebelum = [
                              'stok' => $qtySebelumfix,
                        ];
                        $barangKadaluwarsa->update($dataSebelum);
                  }
            }
      }

      /**
       * Menginput transaksi ke dalam tabel 
       * main_belanja dan detail_belanja_barang
       * serta mengupdate data barang pada tabel barang
       *
       **/
      public function createDetailTransaksi($request, $id_transaksi)
      {
            self::createMainBelanja($request, $id_transaksi);
            $id_belanja = Main_belanja::where('id_transaksi', $id_transaksi)->value('id_belanja');
            if ($request['jenis_transaksi'] === 'Pengadaan Barang') {
                  $data = json_decode($request['data_barang'], true);
                  self::createMainBelanjaBarang($data, $id_belanja, $request['tgl_transaksi'], $request['jenis']);
            } else {
                  self::createDetailBelanjaLain($request['data'], $id_belanja);
            }
      }

      public function createMainBelanja($request, $id_transaksi)
      {
            $jenis_transaksi = isset($request['metode_transaksi']) && $request['metode_transaksi'] === 'Hutang' ? 'kredit' : 'debet';
            $status_transaksi = isset($request['metode_transaksi']) && $request['metode_transaksi'] === 'Hutang' ? 'belum terbayar' : 'lunas';

            $total = Transaksi::where('id_transaksi', $id_transaksi)->value('total') ?? 0;
            $data = [
                  'id_transaksi' => $id_transaksi,
                  'id_penyedia' => $request['id_penyedia'] ?? null,
                  'jenis_belanja' => $jenis_transaksi,
                  'status_belanja' => $status_transaksi,
                  'jumlah_belanja' => $total,
                  'saldo_hutang' => $jenis_transaksi == 'kredit' ? $total : 0,
            ];
            Main_belanja::create($data);
      }

      /**
       *Input detail transaksi belanja barang
       *
       * Menyimpan data detail ke dalam 
       * tabel detail_belanja_barang & kedalam tabel barang
       *
       **/
      public function createMainBelanjaBarang($dataBelanja, $id_belanja, $tanggal, $jenis)
      {
            foreach ($dataBelanja as $data) {
                  $model = new Barang;
                  $data['tgl_beli'] = $tanggal;
                  if ($data['jenis'] === "barang baru") {
                        $prefix = Unit::where('id_unit', $data['id_unit'])->value('kode_unit');
                        $kode = kode($model, $prefix, 'kode_barang');
                        $this->barangService->createPengadaanBarang($model, $data, $kode, $jenis);
                        $id_barang = $model::where('kode_barang', $kode)->value('id_barang');
                        $id_satuan = $data['id_satuan'];
                  } else {
                        $this->barangService->updatePengadaanBarang($model, $data);
                        $id_barang = $data['id_barang'];
                        $id_satuan = $model::where('id_barang', $id_barang)->value('id_satuan');
                  }
                  self::createDetailBelanjaBarang($id_belanja, $id_satuan, $id_barang, $data);
            }
      }

      /**
       * Menyimpan detail belanja barang ke dalam
       * tabel sdetail_belanja_barang
       *
       **/
      public function createDetailBelanjaBarang($id_belanja, $id_satuan, $id_barang, $data)
      {
            Detail_belanja_barang::create([
                  'id_belanja' => $id_belanja,
                  'id_barang' => $id_barang,
                  'id_satuan' => $id_satuan,
                  'qty' => $data['qty'],
                  'harga' => $data['harga'],
                  'subtotal' => $data['subtotal']
            ]);
      }

      /**
       * Menyimpan detail belanja operasional lain
       * ke dalam tabel sdetail_belanja_operasionallain
       *
       **/
      public function createDetailBelanjaLain($data, $id)
      {
            foreach ($data as $datum) {
                  Detail_belanja_operasionallain::create([
                        'id_belanja' => $id,
                        'id_satuan' => $datum['satuan'],
                        'jenis' => $datum['nama'],
                        'nama_belanja' => $datum['nama'],
                        'qty' => $datum['kuantitas'],
                        'harga' => convertToNumber($datum['harga']),
                        'subtotal' => convertToNumber($datum['total'])
                  ]);
            }
      }

      /**
       * Menginput transaksi ke dalam tabel
       * transaksi
       *
       **/
      public function createTransaksi($request, $invoicepny, $imageName, $detailTransaksi)
      {
            //--input ke tabel transaksi--//
            Transaksi::create([
                  'kode' => $request->input('nomor'),
                  'kode_pny' => $invoicepny,
                  'no_bukti' => $request->input('no_bukti'),
                  'tipe' => $request->input('cek_belanja'),
                  'tgl_transaksi' => $request->input('tgl_transaksi'),
                  'detail_tabel' => $detailTransaksi,
                  'jenis_transaksi' => $request->input('jenis_transaksi'),
                  'metode_transaksi' => $request->input('metode_transaksi'),
                  'nota_transaksi' => $imageName,
                  'tpk' => $request->input('tpk') ?? 'Larantuka',
                  'unit' => $request->input('unit'),
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
            if ($request->input('keterangan') == null) {
                  $vendor = Penyedia::where('id_penyedia', $request->input('id_penyedia'))->value('nama');
                  if ($invoicepny == null) {
                        $keterangan = 'Pengadaan Barang TPK ' . $request->input('tpk') . ' dari ' . $vendor;
                  } else {
                        $keterangan = 'Penyesuaian Belanja ' . $invoicepny . ' - Pengadaan Barang TPK ' . $request->input('tpk') . ' dari ' . $vendor;
                  }
                  return $keterangan;
            } else {
                  return $request->input('keterangan');
            }
      }

      /**
       * Memuat fungsi-fungsi untuk menyimpan jurnal
       * pengadaan barang
       *
       **/
      public function createJurnalPengadaanBarang($request, $id_transaksi, $id_penyesuaian)
      {
            $id_kredit = $this->coaService->getIdKredit($request);
            $data = json_decode($request['data_barang'], true);
            /*jurnal pembalik*/
            if ($request['cek_belanja'] === 'penyesuaian') {
                  jurnalPembalik(new Jurnal, $id_transaksi, $id_penyesuaian);
            }
            /*jurnal barang*/
            if ($request['jenis'] === 'persediaan') {
                  $this->accountingService->jurnalPersediaan($data, $id_transaksi, $id_kredit);
            } else {
                  $this->accountingService->jurnalInventaris($data, $id_transaksi, $id_kredit);
            }
      }

      /**
       * Memuat fungsi-fungsi untuk menyimpan jurnal
       * belanja
       *
       **/
      public function createJurnalBelanja($request, $id_transaksi, $idTransPeny)
      {
            $id_kredit = $this->coaService->getIdKredit($request);
            $id_debet = $request['metode_transaksi'] === 'Hutang' ? $request['id_penerima'] : $request['id_belanja'];
            $model = new Jurnal;

            /*jurnal pembalik*/
            if ($request['cek_belanja'] === 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $idTransPeny);
            }
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["total_transaksi"]);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["total_transaksi"]);
      }

      /**
       * Mengambil detail transaksi belanja
       *
       **/
      public function getDetailBelanja($id)
      {
            $data = [];
            $transaksi = Transaksi::where('id_transaksi', $id)->first();
            $id_belanja = Main_belanja::where('id_transaksi', $id)->value('id_belanja');

            if ($transaksi->jenis_transaksi === 'Pengadaan Barang') {
                  $data['details'] = Detail_belanja_barang::with(['barang', 'satuan', 'main_belanja'])
                        ->where('id_belanja', $id_belanja)->get();
            } else {
                  $data['details'] = Detail_belanja_operasionallain::with(['satuan', 'main_belanja'])
                        ->where('id_belanja', $id_belanja)->get();
            }

            $data['jurnals'] = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $id)->get();
            $data['transaksi'] = $transaksi;
            $data['belanja'] = Main_belanja::with('transaksi')->where('id_belanja', $id_belanja)->first();

            return $data;
      }

      public function getDataShow($id, $route)
      {
            $detailBelanja = self::getDetailBelanja($id);
            $transaksi = $detailBelanja['belanja'];
            return [
                  'title' => $transaksi->transaksi->jenis_transaksi,
                  'unit' => $transaksi->transaksi->unit,
                  'id_transaksi' => $transaksi->id_transaksi,
                  'invoice' => $transaksi->transaksi->kode,
                  'no_bukti' => $transaksi->transaksi->no_bukti,
                  'tanggal' => $transaksi->transaksi->tgl_transaksi,
                  'metode' => $transaksi->transaksi->metode_transaksi,
                  'total' => $transaksi->transaksi->total,
                  'nota' => $transaksi->transaksi->nota_transaksi,
                  'tipe' => $transaksi->transaksi->tipe,
                  'status' => $transaksi->status_belanja,
                  'saldo_hutang' => $transaksi->saldo_hutang,
                  'invoicePny' => $transaksi->transaksi->kode_pny,
                  'keterangan' => $transaksi->transaksi->keterangan,
                  'jenis' => $transaksi->jenis_belanja,
                  'routeMain' => $route,
                  'routeDetailPembayaran' => $route . '.show-pelunasan',
                  'pembayaran' => $this->pelunasanService->getInvoicePembayaran($transaksi->id_belanja, 'main_belanja'),
                  'totalPembayaran' => $this->pelunasanService->getTotalPembayaran($transaksi->id_belanja, 'main_belanja'),
                  'transaksis' => $detailBelanja['details']
            ];
      }
}
