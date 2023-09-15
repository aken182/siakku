<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Models\Main_penjualan;
use App\Models\Detail_pelunasan_penjualan;

class PelunasanService
{
      protected $coaService;

      public function __construct()
      {
            $this->coaService = new CoaService;
      }

      public function getPenyesuaianPembayaranPiutang($unit, $jenis)
      {
            $penyesuaian = Detail_pelunasan_penjualan::with(['main_penjualan', 'transaksi'])
                  ->whereHas('transaksi', function ($query) use ($unit, $jenis) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              // ->where(function ($query) use ($unit, $jenis) {
                              // $query->where('unit', $unit)
                              ->where('jenis_transaksi', $jenis)
                              ->where('unit', $unit);
                        // });
                  })->get();
            return $penyesuaian;
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


      public function validateCustomField($request)
      {
            $jumlahPembayaran = convertToNumber($request->input('jumlah_bayar'));
            if ($request->input('cek_pembayaran') === 'penyesuaian') {

                  $detailPenyesuaian = Detail_pelunasan_penjualan::with(['main_penjualan', 'transaksi'])
                        ->find($request->input('id_pny_pembayaran'));

                  $saldoPnyAwal = $detailPenyesuaian->main_penjualan->saldo_piutang + $detailPenyesuaian->jumlah_pelunasan;
                  $saldoPiutangBaru = $saldoPnyAwal - $jumlahPembayaran;

                  $request->merge([
                        'saldo_piutang' => $saldoPiutangBaru,
                        'jumlah_bayar' => $jumlahPembayaran
                  ]);

                  $request['invoicepny'] = $detailPenyesuaian->transaksi->invoice;
                  $request['idTransPny'] = $detailPenyesuaian->transaksi->id_transaksi;
            } else {
                  $request->merge([
                        'saldo_piutang' => convertToNumber($request->input('saldo_piutang')),
                        'jumlah_bayar' => $jumlahPembayaran
                  ]);

                  $request['invoicepny'] = null;
                  $request['idTransPny'] = null;
            }
      }

      public function createTransaksi($request, $imageName, $detail)
      {
            Transaksi::create([
                  'kode' => $request->input('no_pembayaran'),
                  'kode_pny' => $request['invoicepny'],
                  'no_bukti' => $request->input('no_bukti'),
                  'tipe' => $request->input('cek_pembayaran'),
                  'tgl_transaksi' => $request->input('tgl_transaksi'),
                  'detail_tabel' => $detail,
                  'jenis_transaksi' => $request->input('jenis_transaksi'),
                  'metode_transaksi' => $request->input('metode_transaksi'),
                  'nota_transaksi' => $imageName,
                  'total' => $request->input('jumlah_bayar'),
                  'unit' => $request->input('unit'),
                  'keterangan' => $request->input('keterangan')
            ]);
      }

      public function createDetailTransaksi($id_transaksi, $request)
      {
            switch ($request->input('jenis_transaksi')) {
                  case 'Pembayaran Piutang Penjualan':
                        self::createDetailPelunasanPenjualan($id_transaksi, $request);
                        self::updateDetailPenjualan($request->input('saldo_piutang'), $request->input('id_penjualan'));
                        break;
                  default:
                        break;
            }
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
      public function updateDetailPenjualan($saldoPiutang, $id_penjualan)
      {
            //--update tabel detail_kontribusisiswa--//
            $data = [
                  'saldo_piutang' => $saldoPiutang,
                  'status_penjualan' => self::getStatusPembayaran($saldoPiutang)
            ];
            Main_penjualan::where('id_penjualan', $id_penjualan)->update($data);
      }

      public function getStatusPembayaran($saldoPiutang)
      {
            //--ambil status pembayaran--//
            if ($saldoPiutang <= 0) {
                  $status = 'lunas';
            } else {
                  $status = 'belum lunas';
            }
            return $status;
      }

      /**
       * Menginput jurnal pembayaran piutang 
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
                  default:
                        break;
            }
      }

      public function createJurnalPiutangPenjualan($request, $id_transaksi)
      {
            /*jurnal pembalik*/
            $model = new Jurnal;
            if ($request['cek_pembayaran'] == 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $request['idTransPny']);
            }

            //--ambil variabel input jurnal--//
            $id_debet = $this->coaService->getIdDebet($request);
            $id_transaksi_jurnal = self::getIdTransaksiJurnal($request['id_penjualan']);
            $id_kredit = self::getIdKredit($id_transaksi_jurnal);

            //--input tabel jurnal--//
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request['jumlah_bayar']);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request['jumlah_bayar']);
      }

      public function getIdTransaksiJurnal($id)
      {
            $transaksi_jurnal = Main_penjualan::where('id_penjualan', $id)->first();
            return $transaksi_jurnal->id_transaksi;
      }

      public function getIdKredit($id_transaksi_jurnal)
      {
            $jurnal = Jurnal::with(['coa', 'transaksi'])
                  ->whereHas('coa', function ($query) {
                        $query->where('nama', 'LIKE', '%Piutang Barang%');
                  })->where('id_transaksi', $id_transaksi_jurnal)
                  ->where('posisi_dr_cr', 'debet')->first();
            return $jurnal->id_coa;
      }

      public function getInvoicePembayaran($id, $jenis)
      {
            if ($jenis == "kredit") {
                  $m = Detail_pelunasan_penjualan::with(['transaksi', 'main_penjualan', 'main_penjualan.anggota'])
                        ->where('id_penjualan', $id)->get();
                  return $m;
            }
      }

      public function getTotalPembayaran($id, $jenis)
      {
            if ($jenis == "kredit") {
                  $m = Detail_pelunasan_penjualan::with('transaksi')
                        ->where('id_penjualan', $id)
                        ->whereHas('transaksi', function ($query) {
                              $query->whereNot('tipe', 'kadaluwarsa');
                        })->get();
                  $collection = collect($m);
                  $totalSum = $collection->sum('jumlah_pelunasan');
                  return $totalSum;
            }
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
}
