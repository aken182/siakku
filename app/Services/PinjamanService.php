<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\Anggota;
use App\Models\Detail_pelunasan_pinjaman;
use App\Models\Transaksi;
use App\Models\Main_pinjaman;
use App\Models\Pengajuan_pinjaman;

class PinjamanService
{
      private $coaService;

      public function __construct()
      {
            $this->coaService = new CoaService;
      }

      /**
       * Mengambil jenis pinjaman berdasarkan
       * routeName
       *
       **/
      public function getJenisPinjaman($route)
      {
            $jenis = [
                  'baru' => 'pinjaman baru',
                  'masa-lalu' => 'pinjaman masa lalu',
                  'pinjam-tindis' => 'pinjam tindis'
            ];
            $route = str_replace(['pp-pinjaman.create-', 'pp-pinjaman.store-'], '', $route);
            return $jenis[$route];
      }

      /**
       * Mengambil route store pinjaman berdasarkan
       * routeName
       *
       **/
      public function getRouteStore($route)
      {
            $jenis = [
                  'baru' => 'pp-pinjaman.store-baru',
                  'masa-lalu' => 'pp-pinjaman.store-masa-lalu',
                  'pinjam-tindis' => 'pp-pinjaman.store-pinjam-tindis'
            ];
            $route = str_replace(['pp-pinjaman.create-'], '', $route);
            return $jenis[$route];
      }

      public function getConvertToNumberRequest($request)
      {
            $request['gaji_perbulan'] = convertToNumber($request->input('gaji_perbulan'));
            $request['potongan_perbulan'] = convertToNumber($request->input('potongan_perbulan'));
            $request['cicilan_perbulan'] = convertToNumber($request->input('cicilan_perbulan'));
            $request['biaya_perbulan'] = convertToNumber($request->input('biaya_perbulan'));
            $request['sisa_penghasilan'] = convertToNumber($request->input('sisa_penghasilan'));
            $request['kemampuan_bayar'] = convertToNumber($request->input('kemampuan_bayar'));
            $request['jumlah_pinjaman'] = convertToNumber($request->input('jumlah_pinjaman'));
            $request['kapitalisasi'] = convertToNumber($request->input('kapitalisasi'));
            $request['asuransi'] = convertToNumber($request->input('asuransi'));
            $request['angsuran_bunga'] = convertToNumber($request->input('angsuran_bunga'));
            $request['angsuran_pokok'] = convertToNumber($request->input('angsuran_pokok'));
            $request['total_angsuran'] = convertToNumber($request->input('total_angsuran'));
            $request['total_pinjaman'] = convertToNumber($request->input('total_pinjaman'));

            return $request;
      }

      public function getPengajuan($id)
      {
            return Pengajuan_pinjaman::with(['anggota'])->where('id_pengajuan', $id)->first();
      }

      /**
       * undocumented function summary
       *
       **/
      public function getDetailPinjamanAnggota($id)
      {
            $id_main = Main_pinjaman::where('id_transaksi', $id)->value('id_pinjaman');
            return Main_pinjaman::with(['transaksi', 'anggota'])->where('id_pinjaman', $id_main)->first();
      }

      /**
       * Mengambil data pinjaman tindis
       * berdasarkan id_transaksi pinjaman
       *
       **/
      public function getDataPinjamanTindis($id)
      {
            $id_pinjaman = Main_pinjaman::where('id_transaksi', $id)->value('id_pinjaman');
            return Detail_pelunasan_pinjaman::where('id_pinjaman', $id_pinjaman)
                  ->where('jenis_angsuran', 'pinjam tindis')->get();
      }

      /**
       * Mengambil detail pinjaman tindis berdasarkan 
       * id_transaksi
       *
       **/
      public function getDetailPinjamanTindis($id)
      {
            return Detail_pelunasan_pinjaman::with(['transaksi', 'main_pinjaman', 'main_pinjaman.transaksi', 'main_pinjaman.anggota'])
                  ->where('id_transaksi', $id)
                  ->where('jenis_angsuran', 'pinjam tindis')->first();
      }

      /**
       * undocumented function summary
       *
       **/
      public function getDataAngsuran($id)
      {
            $id_pinjaman = Main_pinjaman::where('id_transaksi', $id)->value('id_pinjaman');
            return Detail_pelunasan_pinjaman::where('id_pinjaman', $id_pinjaman)
                  ->where('jenis_angsuran', 'biasa')->get();
      }

      public function getDataPengajuan()
      {
            return Pengajuan_pinjaman::with(['anggota'])
                  ->where('status', 'acc')
                  ->get();
      }

      public function getDataPinjamanAnggota()
      {
            return Main_pinjaman::with(['transaksi', 'anggota'])
                  ->where('status', 'belum lunas')
                  ->whereHas('transaksi', function ($query) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              ->where('unit', 'Simpan Pinjam');
                  })
                  ->get();
      }

      public function getPnyPinjamanTindis($unit)
      {
            return Detail_pelunasan_pinjaman::with(['transaksi', 'main_pinjaman'])
                  ->where('jenis_angsuran', 'pinjam tindis')
                  ->whereHas('main_pinjaman', function ($query)  use ($unit) {
                        $query->where('status', 'belum lunas')
                              ->whereHas('transaksi', function ($query)  use ($unit) {
                                    $query->whereNot('tipe', 'kadaluwarsa')
                                          ->where('unit', $unit);
                              });
                  })
                  ->whereHas('transaksi', function ($query) use ($unit) {
                        $query->whereNot('tipe', 'kadaluwarsa')
                              ->where('unit', $unit);
                  })
                  ->get();
      }


      public function getDataPinjaman($unit, $route = null, $keywords = null)
      {
            $detailPinjaman = self::getDetailPinjaman($unit, $keywords);
            $pinjaman = self::getListPinjaman($detailPinjaman);
            return $pinjaman;
      }

      public function getDetailPinjaman($unit, $keywords = null)
      {
            return Transaksi::where('unit', $unit)
                  ->where('jenis_transaksi', 'Pinjaman Anggota')
                  ->where(function ($query) use ($keywords) {
                        $query->where('kode', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('tgl_transaksi', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('keterangan', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('total', 'LIKE', '%' . $keywords . '%');
                  })->get();
      }

      public function getListPinjaman($detailPinjaman)
      {
            $pinjaman = [];
            foreach ($detailPinjaman as $p) {
                  $status = Main_pinjaman::where('id_transaksi', $p->id_transaksi)->value('status');
                  array_push($pinjaman, [
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
            return $pinjaman;
      }

      public function getPenyesuaian($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('jenis_transaksi', 'Pinjaman Anggota');
                  })->get();
            return $penyesuaian;
      }


      /**
       * undocumented function summary
       *
       **/
      public function createTransaksi($request, $invoicepny, $imageName, $jenis, $unit)
      {
            $detail = self::getJenisDetail($jenis);
            Transaksi::create([
                  'kode' => $request['nomor'],
                  'kode_pny' => $invoicepny ?? null,
                  'no_bukti' => $request['no_bukti'],
                  'tipe' => $request['cek_penyesuaian'],
                  'tgl_transaksi' => $request['tgl_transaksi'],
                  'detail_tabel' => $detail['detail_tabel'],
                  'jenis_transaksi' => $detail['jenis_transaksi'],
                  'metode_transaksi' => $request['metode_transaksi'],
                  'nota_transaksi' => $imageName ?? null,
                  'tpk' => $request['tpk'] ?? 'Larantuka',
                  'unit' => $unit,
                  'total' => $request['total_transaksi'],
                  'keterangan' => self::getKeteranganTransaksi($request, $invoicepny, $jenis)
            ]);
      }

      public function getJenisDetail($jenis)
      {
            $data = [
                  'detail_tabel' => 'detail_pinjaman',
                  'jenis_transaksi' => 'Pinjaman Anggota'
            ];

            if ($jenis === 'pinjam tindis') {
                  $data['detail_tabel'] = 'detail_pinjam_tindis';
                  $data['jenis_transaksi'] = 'Pinjam Tindis';
            }
            return $data;
      }

      /**
       * Mengambil keterangan transaksi
       *
       **/
      public function getKeteranganTransaksi($request, $invoicepny, $jenis)
      {
            if ($jenis === 'pinjaman baru') {
                  $pengajuan = self::getPengajuan($request['id_pengajuan']);
                  $id_anggota = $pengajuan->id_anggota;
            }

            if ($jenis === 'pinjam tindis') {
                  $pinjaman = self::getPinjamanByRequest($request['id_pinjaman']);
                  $id_anggota = $pinjaman->id_anggota;
            }

            $anggota = Anggota::where('id_anggota', $id_anggota)->value('nama');
            if ($invoicepny == null) {
                  $keterangan = $jenis . ' - ' . $anggota;
            } else {
                  $keterangan = 'Penyesuaian ' . $jenis . ' ' . $invoicepny . ' - '  . $jenis .  ' - ' . $anggota;
            }
            return $keterangan;
      }

      /**
       * undocumented function summary
       *
       **/
      public function getTotalTransaksi($request, $jenis)
      {
            if ($jenis === 'pinjaman baru') {
                  $pengajuan = self::getPengajuan($request['id_pengajuan']);
                  $total = $pengajuan->jumlah_pinjaman;
            } else {
                  $total = convertToNumber($request['total_transaksi']);
            }
            return $total;
      }

      /**
       * undocumented function summary
       *
       **/
      public function createDetailTransaksi($request, $id_transaksi, $jenis, $id_pny)
      {
            $data = [];
            $data['id_transaksi'] = $id_transaksi;
            $data['status'] = 'belum lunas';
            $data['total_pinjaman'] = $request['total_transaksi'];

            if ($jenis === 'pinjaman baru') {
                  $pengajuan = self::getPengajuan($request['id_pengajuan']);
                  $saldoBunga = $pengajuan->angsuran_bunga * $pengajuan->jangka_waktu;

                  $data['id_anggota'] = $pengajuan->id_anggota;
                  $data['id_pengajuan'] = $request['id_pengajuan'];
                  $data['asuransi'] = $pengajuan->asuransi;
                  $data['kapitalisasi'] = $pengajuan->kapitalisasi;
                  $data['angsuran_pokok'] = $pengajuan->angsuran_pokok;
                  $data['angsuran_bunga'] = $pengajuan->angsuran_bunga;
                  $data['saldo_pokok'] = $request['total_transaksi'];
                  $data['saldo_bunga'] = $saldoBunga;
                  $data['jenis'] = 'baru';
                  Main_pinjaman::create($data);
                  $p = ['status_pencairan' => 'sudah cair'];
                  $pengajuan->update($p);
            }

            if ($jenis === 'pinjam tindis') {
                  $pinjaman = self::getPinjamanByRequest($request['id_pinjaman']);
                  $pinjam_tindis = self::getNilaiPinjamTindis($pinjaman, $request, $id_pny);
                  $u = [
                        'pinjam_tindis' => $pinjam_tindis,
                        'saldo_pokok' => convertToNumber($request['saldo_pokok'])
                  ];
                  $pinjaman->update($u);
                  self::createPinjamTindis($request, $id_transaksi);
            }
      }

      /**
       * Mengambil nilai transaksi pinjam
       * tindis
       *
       **/
      public function getNilaiPinjamTindis($pinjaman, $request, $id_penyesuaian)
      {
            $n = $pinjaman->pinjam_tindis ?? 0;

            if ($request['cek_penyesuaian'] === 'penyesuaian') {
                  $pny = Detail_pelunasan_pinjaman::where('id_transaksi', $id_penyesuaian)
                        ->where('id_pinjaman', $request['id_pinjaman'])->first();
                  $pinjam_tindis = $n - ($pny ? $pny->besar_pinjaman : 0) + $request['total_transaksi'];
            } else {
                  $pinjam_tindis = $n + $request['total_transaksi'];
            }

            return $pinjam_tindis;
      }

      /**
       * undocumented function summary
       *
       **/
      public function getPinjamanByRequest($id_pinjaman)
      {
            $pinjaman = Main_pinjaman::where('id_pinjaman', $id_pinjaman)->first();
            return $pinjaman;
      }

      /**
       * undocumented function summary
       *
       **/
      public function createPinjamTindis($request, $id_transaksi)
      {
            Detail_pelunasan_pinjaman::create([
                  'id_pinjaman' => $request['id_pinjaman'],
                  'id_transaksi' => $id_transaksi,
                  'jenis_angsuran' => 'pinjam tindis',
                  'besar_pinjaman' => $request['total_transaksi']
            ]);
      }

      /**
       * undocumented function summary
       *
       **/
      public function createJurnal($request, $id_transaksi, $id_penyesuaian, $jenis)
      {
            /*jurnal pembalik*/
            if ($request['cek_penyesuaian'] === 'penyesuaian') {
                  jurnalPembalik(new Jurnal, $id_transaksi, $id_penyesuaian);
            }

            if ($jenis === 'pinjaman baru') {
                  self::createJurnalPinjamanBaru($request, $id_transaksi);
            }

            if ($jenis === 'pinjam tindis' || $jenis === 'pinjaman masa lalu') {
                  self::createJurnalPinjaman($request, $id_transaksi);
            }
      }

      /**
       * undocumented function summary
       *
       **/
      public function createJurnalPinjamanBaru($request, $id_transaksi)
      {
            $model = new Jurnal;
            $pengajuan = self::getPengajuan($request['id_pengajuan']);

            $idTotalPinjaman = $this->coaService->getIdCoa('nama', 'Piutang Simpan Pinjam', 'subkategori', 'Piutang');
            $idAsuransi = $this->coaService->getIdCoa('nama', 'Asuransi', 'subkategori', 'Biaya Tidak Langsung');
            $idKapitalisasi = $this->coaService->getIdCoa('nama', 'Simpanan Kapitalisasi', 'subkategori', 'Simpanan');
            $idKasBank = $this->coaService->getIdKredit($request);

            jurnal($model, $idTotalPinjaman, $id_transaksi, 'debet', $pengajuan->jumlah_pinjaman);
            jurnal($model, $idAsuransi, $id_transaksi, 'kredit', $pengajuan->asuransi);
            jurnal($model, $idKapitalisasi, $id_transaksi, 'kredit', $pengajuan->kapitalisasi);
            jurnal($model, $idKasBank, $id_transaksi, 'kredit', $pengajuan->total_pinjaman);
      }

      public function createJurnalPinjaman($request, $id_transaksi)
      {
            $model = new Jurnal;
            $id_debet = $this->coaService->getIdCoa('nama', 'Piutang Simpan Pinjam', 'subkategori', 'Piutang');
            $id_kredit = $this->coaService->getIdKredit($request);
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request['total_transaksi']);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request['total_transaksi']);
      }
}
