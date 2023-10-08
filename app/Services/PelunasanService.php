<?php

namespace App\Services;

use App\Models\Detail_pelunasan_belanja;
use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Models\Main_penjualan;
use App\Models\Detail_pelunasan_penjualan;
use App\Models\Detail_pelunasan_pinjaman;
use App\Models\Main_belanja;
use App\Models\Main_pinjaman;

class PelunasanService
{
      protected $coaService;

      public function __construct()
      {
            $this->coaService = new CoaService;
      }

      public function getPenyesuaianPembayaran($model, $mainTable, $unit, $jenis)
      {
            $penyesuaian = $model::with([$mainTable, 'transaksi'])
                  ->whereHas('transaksi', function ($query) use ($unit, $jenis) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              ->where('jenis_transaksi', $jenis)
                              ->where('unit', $unit);
                  })->get();
            return $penyesuaian;
      }

      public function getJenisPembayaran($detail)
      {
            $jenis = [
                  'Pengadaan Barang' => 'Pembayaran Hutang Belanja',
                  'Belanja' => 'Pembayaran Hutang Belanja',
                  'Penjualan Barang' => 'Pembayaran Piutang Penjualan',
                  'Penjualan Lainnya' => 'Pembayaran Piutang Penjualan',
                  'Pinjaman Anggota' => 'Pembayaran Pinjaman Anggota',
            ];
            return $jenis[$detail];
      }

      /**
       * undocumented function summary
       *
       **/
      public function getRouteStoreDetail($request)
      {
            $data = [];
            if ($request->input('detail') === 'Pinjaman Anggota') {
                  $data['storeRoute'] = route('pp-angsuran.store');
                  $data['detailRoute'] = 'pp-angsuran.detail-pelunasan';
            } else {
                  $data['storeRoute'] = route($request->input('route') . '.store-pelunasan');
                  $data['detailRoute'] = $request->input('route') . '.detail-pelunasan';
            }
            return $data;
      }

      public function getTagihanPenjualan($unit, $jenis)
      {
            $mainPenjualan = Main_penjualan::with(['transaksi', 'anggota'])
                  ->whereNot('status_penjualan', 'lunas')
                  ->whereHas('transaksi', function ($query) use ($unit, $jenis) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              ->where('unit', $unit)
                              ->where('jenis_transaksi', $jenis);
                  })
                  ->get();
            $tagihan = [];
            foreach ($mainPenjualan as $m) {
                  $nama = $m->nama_bukan_anggota;
                  if ($m->status_pembeli === 'pegawai') {
                        $nama = $m->anggota->nama;
                  }
                  array_push($tagihan, [
                        'id_penjualan' => $m->id_penjualan,
                        'kode' => $m->transaksi->kode,
                        'tgl_beli' => $m->transaksi->tgl_transaksi,
                        'status_pembeli' => $m->status_pembeli === 'pegawai' ? 'anggota' : 'bukan anggota',
                        'status_penjualan' => $m->status_penjualan,
                        'jumlah_penjualan' => $m->jumlah_penjualan,
                        'saldo_piutang' => $m->saldo_piutang,
                        'pembeli' => $nama
                  ]);
            }
            return $tagihan;
      }

      public function getTagihanBelanja($unit, $jenis)
      {
            $mainBelanja = Main_belanja::with(['transaksi', 'penyedia'])
                  ->whereNot('status_belanja', 'lunas')
                  ->whereHas('transaksi', function ($query) use ($unit, $jenis) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              ->where('unit', $unit)
                              ->where('jenis_transaksi', $jenis);
                  })
                  ->get();
            $tagihan = [];
            foreach ($mainBelanja as $m) {
                  array_push($tagihan, [
                        'id_belanja' => $m->id_belanja,
                        'kode' => $m->transaksi->kode,
                        'tgl_beli' => $m->transaksi->tgl_transaksi,
                        'penyedia' => $m->penyedia->nama ?? '-',
                        'status_belanja' => $m->status_belanja,
                        'jumlah_belanja' => $m->jumlah_belanja,
                        'saldo_hutang' => $m->saldo_hutang,
                        'jenis' => $m->transaksi->jenis_transaksi,
                  ]);
            }
            return $tagihan;
      }

      /**
       * Mengambil data tagihan pinjaman anggota
       *
       **/
      public function getTagihanPinjaman($unit, $jenis)
      {
            return Main_pinjaman::with(['transaksi', 'anggota'])
                  ->whereNot('status', 'lunas')
                  ->whereHas('transaksi', function ($query) use ($unit, $jenis) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              ->where('unit', $unit)
                              ->where('jenis_transaksi', $jenis);
                  })
                  ->get();
      }

      public function validateCustomField($request)
      {
            $jumlahPembayaran = convertToNumber($request->input('jumlah_bayar'));
            if ($request->input('cek_pembayaran') === 'penyesuaian') {

                  if ($request->input('jenis_transaksi') === 'Pembayaran Piutang Penjualan') {
                        $detailPenyesuaian = Detail_pelunasan_penjualan::with(['main_penjualan', 'transaksi'])
                              ->find($request->input('id_pny_pembayaran'));
                        $saldo = $detailPenyesuaian->main_penjualan->saldo_piutang;
                  } else {
                        $detailPenyesuaian = Detail_pelunasan_belanja::with(['main_belanja', 'transaksi'])
                              ->find($request->input('id_pny_pembayaran'));
                        $saldo = $detailPenyesuaian->main_belanja->saldo_hutang;
                  }

                  $saldoPnyAwal =  $saldo + $detailPenyesuaian->jumlah_pelunasan;
                  $saldoTagihanBaru = $saldoPnyAwal - $jumlahPembayaran;

                  $request->merge([
                        'saldo_tagihan' => $saldoTagihanBaru,
                        'jumlah_bayar' => $jumlahPembayaran
                  ]);

                  $request['invoicepny'] = $detailPenyesuaian->transaksi->kode;
                  $request['idTransPny'] = $detailPenyesuaian->transaksi->id_transaksi;
            } else {
                  $request->merge([
                        'saldo_tagihan' => convertToNumber($request->input('saldo_tagihan')),
                        'jumlah_bayar' => $jumlahPembayaran
                  ]);

                  $request['invoicepny'] = null;
                  $request['idTransPny'] = null;
            }
      }

      public function getTotalTransaksi($request)
      {
            if ($request['jenis_transaksi'] === 'Pembayaran Hutang Belanja') {
                  $bunga = $request['bunga_hutang'] ?? null;
                  $bungafix = convertToNumber($bunga);
                  $total = $request['jumlah_bayar'] + ($bungafix);
            } else {
                  $total = $request['jumlah_bayar'];
            }
            return $total;
      }

      public function createTransaksi($request, $imageName, $detail)
      {
            Transaksi::create([
                  'kode' => $request['no_pembayaran'],
                  'kode_pny' => $request['invoicepny'],
                  'no_bukti' => $request['no_bukti'],
                  'tipe' => $request['cek_pembayaran'],
                  'tgl_transaksi' => $request['tgl_transaksi'],
                  'detail_tabel' => $detail,
                  'jenis_transaksi' => $request['jenis_transaksi'],
                  'metode_transaksi' => $request['metode_transaksi'],
                  'nota_transaksi' => $imageName,
                  'total' => $request['total_transaksi'] ?? self::getTotalTransaksi($request),
                  'unit' => $request['unit'],
                  'keterangan' => $request['keterangan']
            ]);
      }

      public function createDetailTransaksi($id_transaksi, $request)
      {
            switch ($request->input('jenis_transaksi')) {
                  case 'Pembayaran Piutang Penjualan':
                        self::createDetailPelunasanPenjualan($id_transaksi, $request);
                        self::updateDetailPenjualan($request->input('saldo_tagihan'), $request->input('id_penjualan'));
                        break;
                  case 'Pembayaran Hutang Belanja':
                        self::createDetailPelunasanBelanja($id_transaksi, $request);
                        self::updateDetailBelanja($request->input('saldo_tagihan'), $request->input('id_belanja'));
                        break;
                  default:
                        break;
            }
      }

      /**
       * undocumented function summary
       *
       **/
      public function createDetailAngsuran($id_transaksi, $request, $id_penyesuaian)
      {
            $angsuranBunga = convertToNumber($request['angsuran_bunga']);
            $angsuranPokok = convertToNumber($request['angsuran_pokok']);
            Detail_pelunasan_pinjaman::create([
                  'id_pinjaman' => $request['id_pinjaman'],
                  'id_transaksi' => $id_transaksi,
                  'jenis_angsuran' => 'biasa',
                  'angsuran_bunga' => $angsuranBunga,
                  'angsuran_pokok' => $angsuranPokok,
                  'total_angsuran' => $request['total_transaksi'],
            ]);
            self::updateDetailAngsuran($angsuranBunga, $angsuranPokok, $request, $id_penyesuaian);
      }

      public function updateDetailAngsuran($angsuranBunga, $angsuranPokok, $request, $id_penyesuaian)
      {
            $pinjaman = Main_pinjaman::where('id_pinjaman', $request['id_pinjaman'])->first();
            $saldoPokok = $pinjaman->saldo_pokok;
            $saldoBunga = $pinjaman->saldo_bunga;

            if ($request['cek_pembayaran'] === 'penyesuaian') {
                  $pny = Detail_pelunasan_pinjaman::where('id_detail', $id_penyesuaian)
                        ->where('id_pinjaman', $request['id_pinjaman'])->first();

                  if ($pny) {
                        $saldoPokok += $pny->angsuran_pokok;
                        $saldoBunga += $pny->angsuran_bunga;
                  }
            }

            $saldoPokok -= $angsuranPokok;
            $saldoBunga -= $angsuranBunga;

            $data = [
                  'saldo_pokok' => $saldoPokok,
                  'saldo_bunga' => $saldoBunga,
                  'status' => self::getStatusPembayaran($saldoPokok, $saldoBunga)
            ];

            $pinjaman->update($data);
      }

      /**
       * Menginput detail transaksi pelunasan penjualan
       *
       * @param mixed $id_transaksi 
       * @param mixed $request
       * @return void
       **/
      public function createDetailPelunasanPenjualan($id_transaksi, $request)
      {
            Detail_pelunasan_penjualan::create([
                  'id_transaksi' => $id_transaksi,
                  'id_penjualan' => $request->input('id_penjualan'),
                  'jumlah_pelunasan' => $request->input('jumlah_bayar')
            ]);
      }

      /**
       * Menginput detail transaksi pelunasan belanja
       *
       **/
      public function createDetailPelunasanBelanja($id_transaksi, $request)
      {
            $bunga = $request->input('bunga_hutang') ?? null;
            Detail_pelunasan_belanja::create([
                  'id_transaksi' => $id_transaksi,
                  'id_belanja' => $request->input('id_belanja'),
                  'jumlah_pelunasan' => $request->input('jumlah_bayar'),
                  'bunga' => convertToNumber($bunga)
            ]);
      }

      public function updateDetailPenjualan($saldoPiutang, $id_penjualan)
      {
            //--update tabel detail_kontribusisiswa--//
            $data = [
                  'saldo_piutang' => $saldoPiutang,
                  'status_penjualan' => self::getStatusPembayaran($saldoPiutang)
            ];
            Main_penjualan::where('id_penjualan', $id_penjualan)->update($data);
      }

      public function updateDetailBelanja($saldoHutang, $id_belanja)
      {
            $data = [
                  'saldo_hutang' => $saldoHutang,
                  'status_belanja' => self::getStatusPembayaran($saldoHutang)
            ];
            Main_belanja::where('id_belanja', $id_belanja)->update($data);
      }

      public function getStatusPembayaran($saldoTagihan, $saldoBunga = null)
      {
            //--ambil status pembayaran--//
            if ($saldoBunga != null) {
                  if ($saldoTagihan <= 0 && $saldoBunga <= 0) {
                        $status = 'lunas';
                  } else {
                        $status = 'belum lunas';
                  }
            } else {
                  if ($saldoTagihan <= 0) {
                        $status = 'lunas';
                  } else {
                        $status = 'belum lunas';
                  }
            }
            return $status;
      }

      /**
       * Menginput jurnal pembayaran tagihan
       * atau pembayaran pinjaman
       *
       * @param mixed $request
       * @param mixed $id_transaksi
       * @return void
       **/
      public function createJurnal($request, $id_transaksi)
      {
            switch ($request['jenis_transaksi']) {
                  case 'Pembayaran Piutang Penjualan':
                        self::createJurnalPiutangPenjualan($request, $id_transaksi);
                        break;
                  case 'Pembayaran Hutang Belanja':
                        self::createJurnalHutangBelanja($request, $id_transaksi);
                        break;
                  default:
                        break;
            }
      }

      public function createJurnalAngsuranPinjaman($request, $id_transaksi, $id_penyesuaian)
      {
            /*jurnal pembalik*/
            $model = new Jurnal;
            if ($request['cek_pembayaran'] === 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $id_penyesuaian);
            }

            //--ambil variabel input jurnal--//
            $id_transaksi_jurnal = self::getIdTransaksiJurnal(new Main_pinjaman, 'id_pinjaman', $request['id_pinjaman']);
            $id_debet = $this->coaService->getIdDebet($request);
            $id_bunga = $this->coaService->getIdCoa('nama', 'Pendapatan Bunga Bank', 'subkategori', 'Pendapatan Bunga');
            $id_piutang = self::getIdPiutang($id_transaksi_jurnal);
            $angsuranBunga = convertToNumber($request['angsuran_bunga']);
            $angsuranPokok = convertToNumber($request['angsuran_pokok']);
            //--input tabel jurnal--//
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request['total_transaksi']);
            jurnal($model, $id_bunga, $id_transaksi, 'kredit', $angsuranBunga);
            jurnal($model, $id_piutang, $id_transaksi, 'kredit', $angsuranPokok);
      }

      public function createJurnalPiutangPenjualan($request, $id_transaksi)
      {
            /*jurnal pembalik*/
            $model = new Jurnal;
            if ($request['cek_pembayaran'] == 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $request['idTransPny']);
            }

            //--ambil variabel input jurnal--//
            $id_transaksi_jurnal = self::getIdTransaksiJurnal(new Main_penjualan, 'id_penjualan', $request['id_penjualan']);
            $id_debet = $this->coaService->getIdDebet($request);
            $id_kredit = self::getIdPiutang($id_transaksi_jurnal);

            //--input tabel jurnal--//
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request['jumlah_bayar']);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request['jumlah_bayar']);
      }

      public function createJurnalHutangBelanja($request, $id_transaksi)
      {
            /*jurnal pembalik*/
            $model = new Jurnal;
            if ($request['cek_pembayaran'] == 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $request['idTransPny']);
            }

            //--ambil variabel input jurnal--//
            $id_transaksi_jurnal = self::getIdTransaksiJurnal(new Main_belanja, 'id_belanja', $request['id_belanja']);
            $id_debet = self::getIdHutang($id_transaksi_jurnal);
            $id_kredit = $this->coaService->getIdKredit($request);
            $id_bunga = $this->coaService->getIdBungaHutang($request);
            $bunga = $request['bunga_hutang'] ?? null;
            $bungafix = convertToNumber($bunga);
            $total = self::getTotalTransaksi($request);
            //--input tabel jurnal--//
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request['jumlah_bayar']);
            jurnal($model, $id_bunga, $id_transaksi, 'debet', $bungafix);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $total);
      }

      public function getIdTransaksiJurnal($model, $idKey, $id)
      {
            $transaksi_jurnal = $model::where($idKey, $id)->first();
            return $transaksi_jurnal->id_transaksi;
      }

      public function getIdPiutang($id_transaksi_jurnal)
      {
            $jurnal = Jurnal::with(['coa', 'transaksi'])
                  ->whereHas('coa', function ($query) {
                        $query->where('nama', 'LIKE', "%Piutang%");
                  })->where('id_transaksi', $id_transaksi_jurnal)
                  ->where('posisi_dr_cr', 'debet')->first();
            return $jurnal->id_coa;
      }

      public function getIdHutang($id_transaksi_jurnal)
      {
            $jurnal = Jurnal::with(['coa', 'transaksi'])
                  ->whereHas('coa', function ($query) {
                        $query->where('nama', 'LIKE', "%Hutang%");
                  })->where('id_transaksi', $id_transaksi_jurnal)
                  ->where('posisi_dr_cr', 'kredit')->first();
            return $jurnal->id_coa;
      }

      public function getInvoicePembayaran($id, $tipe)
      {
            switch ($tipe) {
                  case 'main_penjualan':
                        $m = Detail_pelunasan_penjualan::with(['transaksi', 'main_penjualan', 'main_penjualan.anggota'])
                              ->where('id_penjualan', $id)->get();
                        break;
                  case 'main_belanja':
                        $m = Detail_pelunasan_belanja::with(['transaksi', 'main_belanja', 'main_belanja.penyedia'])
                              ->where('id_belanja', $id)->get();
                        break;
                  default:
                        break;
            }
            return $m;
      }

      public function getTotalPembayaran($id, $jenis)
      {
            switch ($jenis) {
                  case 'main_penjualan':
                        $m = Detail_pelunasan_penjualan::with('transaksi')
                              ->where('id_penjualan', $id)
                              ->whereHas('transaksi', function ($query) {
                                    $query->whereNot('tipe', 'kadaluwarsa');
                              })->get();
                        break;
                  case 'main_belanja':
                        $m = Detail_pelunasan_belanja::with('transaksi')
                              ->where('id_belanja', $id)
                              ->whereHas('transaksi', function ($query) {
                                    $query->whereNot('tipe', 'kadaluwarsa');
                              })->get();
                        break;
                  default:
                        break;
            }
            $collection = collect($m);
            $totalSum = $collection->sum('jumlah_pelunasan');
            return $totalSum;
      }

      /**
       * Mengambiljenis transaksi detail berdasarkan
       * route
       *
       **/
      public function getJenisDetail($route)
      {
            $jenis = [
                  'ptk-penjualan' => 'Pembayaran Piutang Penjualan',
                  'btk-belanja-barang' => 'Pembayaran Hutang Belanja',
                  'btk-belanja-lain' => 'Pembayaran Hutang Belanja',
                  'bsp-belanja-barang' => 'Pembayaran Hutang Belanja',
                  'bsp-belanja-lain' => 'Pembayaran Hutang Belanja',
                  'pp-angsuran' => 'Pembayaran Pinjaman Anggota',
            ];
            $route = str_replace(['.detail-pelunasan', '.detail-pelunasan', '.show-pelunasan'], '', $route);
            return $jenis[$route];
      }

      public function getDetailPembayaranPiutang($id)
      {
            $m = Detail_pelunasan_penjualan::with(['transaksi', 'main_penjualan', 'main_penjualan.anggota', 'main_penjualan.transaksi'])
                  ->where('id_detail', $id)->first();
            if ($m->main_penjualan->status_pembeli === 'pegawai') {
                  $nama = $m->main_penjualan->anggota->nama;
            } else {
                  $nama = $m->main_penjualan->nama_bukan_pegawai;
            }

            $result = [
                  'id_transaksi' => $m->transaksi->id_transaksi,
                  'invoice' => $m->transaksi->kode,
                  'no_bukti' => $m->transaksi->no_bukti,
                  'nama' => $nama,
                  'tanggal_bayar' => date('d-m-Y', strtotime($m->transaksi->tgl_transaksi)),
                  'jumlah_bayar' => cek_uang($m->jumlah_pelunasan),
                  'via' => $m->transaksi->jenis_transaksi,
                  'sisa_tagihan' => cek_uang($m->main_penjualan->saldo_piutang),
                  'status' => $m->main_penjualan->status_penjualan,
                  'invoice_tagihan' => $m->main_penjualan->transaksi->kode,
                  'nota_transaksi' => $m->transaksi->nota_transaksi,
                  'keterangan' => $m->transaksi->keterangan
            ];

            return $result;
      }

      public function getDetailPembayaranHutang($id)
      {
            $m = Detail_pelunasan_belanja::with(['transaksi', 'main_belanja', 'main_belanja.penyedia', 'main_belanja.transaksi'])
                  ->where('id_detail', $id)->first();

            $result = [
                  'id_transaksi' => $m->transaksi->id_transaksi,
                  'invoice' => $m->transaksi->kode,
                  'no_bukti' => $m->transaksi->no_bukti,
                  'nama' => $m->main_belanja->penyedia->nama ?? '-',
                  'tanggal_bayar' => date('d-m-Y', strtotime($m->transaksi->tgl_transaksi)),
                  'jumlah_bayar' => cek_uang($m->jumlah_pelunasan),
                  'bunga' => cek_uang($m->bunga),
                  'via' => $m->transaksi->jenis_transaksi,
                  'sisa_tagihan' => cek_uang($m->main_belanja->saldo_hutang),
                  'status' => $m->main_belanja->status_belanja,
                  'invoice_tagihan' => $m->main_belanja->transaksi->kode,
                  'nota_transaksi' => $m->transaksi->nota_transaksi,
                  'keterangan' => $m->transaksi->keterangan
            ];

            return $result;
      }

      public function getDetailPembayaranPinjaman($id)
      {
            $m = Detail_pelunasan_pinjaman::with(['transaksi', 'main_pinjaman', 'main_pinjaman.anggota', 'main_pinjaman.transaksi'])
                  ->where('id_detail', $id)->first();

            $result = [
                  'id_transaksi' => $m->transaksi->id_transaksi,
                  'invoice' => $m->transaksi->kode,
                  'no_bukti' => $m->transaksi->no_bukti,
                  'nama' => $m->main_pinjaman->anggota->nama ?? '-',
                  'tanggal_bayar' => date('d-m-Y', strtotime($m->transaksi->tgl_transaksi)),
                  'angsuran_pokok' => cek_uang($m->angsuran_pokok),
                  'angsuran_bunga' => cek_uang($m->angsuran_bunga),
                  'total_angsuran' => cek_uang($m->total_angsuran),
                  'saldo_pokok' => cek_uang($m->main_pinjaman->saldo_pokok),
                  'saldo_bunga' => cek_uang($m->main_pinjaman->saldo_bunga),
                  'status' => $m->main_pinjaman->status,
                  'invoice_tagihan' => $m->main_pinjaman->transaksi->kode,
                  'nota_transaksi' => $m->transaksi->nota_transaksi,
                  'keterangan' => $m->transaksi->keterangan
            ];

            return $result;
      }
}
