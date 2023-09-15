<?php

namespace App\Services;

use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Services\AccountingService;
use App\Models\Detail_transfer_saldo;

class TransferSaldoService
{
      public function getTransaksiPenyesuaian($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where('unit', $unit)
                  ->where('detail_tabel', 'detail_transfer_saldo')
                  ->get();
            return $penyesuaian;
      }

      /**
       * Dokumentasi getUnitTransaksi
       *
       * Mengambil unit berdasarkan routeName
       *
       * @param mixed $route
       * @return string
       **/
      public function getUnitTransaksi($route)
      {
            $units = [
                  'transfer-toko' => 'Pertokoan',
                  'transfer-sp' => 'Simpan Pinjam',
            ];
            // Mengekstrak kata pertama dari route untuk menentukan unit
            $routeParts = explode('.', $route);
            $unitKey = reset($routeParts);
            return $units[$unitKey] ?? null;
      }

      /**
       * Dokumentasi getRouteMain
       *
       * Mengambil route induk berdasarkan unit 
       *
       * @param mixed $unit
       * @return string
       **/
      public function getRouteMain($unit)
      {
            $route = [
                  'Pertokoan' => 'transfer-toko',
                  'Simpan Pinjam' => 'transfer-sp',
            ];
            return $route[$unit];
      }

      /**
       * Dokumentasi getRouteToIndex
       *
       * Mengambil route yang diperlukan untuk fungsi
       * index pada controller.
       *
       * @param mixed $route
       * @return string[]
       * 
       **/
      public function getRouteToIndex($route)
      {
            return [
                  'create' => route("{$route}.create"),
                  'show' => "{$route}.show",
                  'list' => "{$route}.list",
            ];
      }

      /**
       * Dokumentasi getRouteStoreToCreate
       *
       * Mengambil route store untuk fungsi
       * create pada controller.
       *
       * @param mixed $route
       * @return string
       * 
       **/
      public function getRouteStoreToCreate($route)
      {
            $store = [
                  'transfer-toko.create' => 'transfer-toko.store',
                  'transfer-sp.create' => 'transfer-sp.store',
            ];
            return $store[$route];
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
                  'transfer-toko.list' => 'transfer-toko.show',
                  'transfer-sp.list' => 'transfer-sp.show',
            ];
            return $store[$route];
      }

      public function getCoa()
      {
            return Coa::where('subkategori', 'LIKE', "%Kas & Bank%")->get();
      }

      public function getSaldoAkun($unit)
      {
            $getneraca = new AccountingService;
            $neraca = $getneraca->getNeracaSaldo(date('m'), date('Y'), $unit);
            return $neraca['neraca'];
      }

      public function getDetailPenyesuaian($request)
      {
            $data = [
                  'idTransPeny' => null,
                  'invoicepny' => null,
            ];
            if ($request->input('cek_penyesuaian') === 'penyesuaian') {
                  $transaksiPenyesuaian = Transaksi::where('id_transaksi', $request->input("id_penyesuaian"))->first();
                  $data['idTransPeny'] = $transaksiPenyesuaian->id_transaksi;
                  $data['invoicepny'] = $transaksiPenyesuaian->kode;
            }
            return $data;
      }

      public function createTransaksi($request, $invoice, $imageName, $unit)
      {
            Transaksi::create([
                  'kode' => $request->input('nomor'),
                  'kode_pny' => $invoice,
                  'no_bukti' => $request->input('no_bukti'),
                  'tipe' => $request->input('cek_penyesuaian'),
                  'tgl_transaksi' => $request->input('tgl_transaksi'),
                  'jenis_transaksi' => 'Transfer Saldo Kas & Bank',
                  'detail_tabel' => 'detail_transfer_saldo',
                  'metode_transaksi' => 'Kas',
                  'nota_transaksi' => $imageName,
                  'total' => $request['jumlah'],
                  'keterangan' => $request->input('keterangan'),
                  'unit' => $unit,
            ]);
      }

      public function createDetailTransaksi($request, $id_transaksi)
      {
            Detail_transfer_saldo::create([
                  'id_transaksi' => $id_transaksi,
                  'id_pengirim' => $request->input('id_pengirim'),
                  'id_penerima' => $request->input('id_penerima'),
                  'jumlah' => $request['jumlah']
            ]);
      }

      public function createJurnal($request, $id_transaksi, $idTransPeny)
      {
            $id_debet = $request->input('id_penerima');
            $id_kredit = $request->input('id_pengirim');

            /*deklarasi variabel lain untuk fungsi input jurnal*/
            $model = new Jurnal;

            /*Input Jurnal*/
            /*jurnal pembalik*/
            if ($request->input('cek_penyesuaian') === 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $idTransPeny);
            }
            /*jurnal baru*/
            jurnal($model, $id_debet, $id_transaksi, 'debet', $request["jumlah"]);
            jurnal($model, $id_kredit, $id_transaksi, 'kredit', $request["jumlah"]);
      }
}
