<?php

namespace App\Services;

use App\Models\Coa;

class CoaService
{
      public function getDataCoa($id)
      {
            return Coa::where('id_coa', $id)->first();
      }

      /**
       * Dokumentasi createCoa
       *
       * Berfungsi untuk menginput data array ke dalam
       * tabel coa pada database
       *
       * @param mixed $data
       * @return void
       **/
      public function createCoa($data)
      {
            Coa::create([
                  'kode' => $data['kode'],
                  'nama' => $data['nama'],
                  'kategori' => $data['kategori'],
                  'subkategori' => $data['subkategori'],
                  'header' => $data['header']
            ]);
      }

      /**
       * Dokumentasi importCoaFromSaldoAwal
       *
       * Mengimport data coa dari file excel
       * saldo awal coa ke dalam tabel coa
       * dalam database.
       *
       * @param mixed $rows
       * @return void
       **/
      public function importCoaFromSaldoAwal($rows)
      {
            foreach ($rows as $row) {
                  $id_coa = Coa::where('kode', $row['kode'])
                        ->where('nama', $row['nama'])
                        ->value('id_coa');
                  if ($id_coa) {
                        continue;
                  } else {
                        self::createCoa($row);
                  }
            }
      }

      /**
       * Mengambil akun-akun penjualan barang dalam
       * tabel coa pada database.
       *
       * @return mixed
       **/
      public function getAkunPenjualanBarang()
      {
            return Coa::where('nama', 'LIKE', "%Penjualan Barang%")->get();
      }

      /**
       * Mengambil akun-akun pembelian barang dalam
       * tabel coa pada database.
       *
       * @return mixed
       **/
      public function getAkunBelanjaBarang()
      {
            return Coa::where('nama', 'LIKE', "%Pembelian Barang%")->get();
      }

      /**
       * Mengambil akun-akun pendapatan selain penjualan 
       * barang dalam tabel coa pada database.
       *
       * @return mixed
       **/
      public function getAkunPendapatan()
      {
            return Coa::whereNot('nama', 'LIKE', "%Penjualan Barang%")
                  ->where('kategori', "Pendapatan")
                  ->orWhere(function ($query) {
                        $query->where('nama', "Ekuitas Saldo Awal");
                  })->get();
      }

      /**
       * ambil id_coa untuk akun debet jurnal
       *
       * @param mixed $request
       * @return mixed
       **/
      public function getIdDebet($request)
      {
            if ($request['metode_transaksi'] == "Kas") {
                  return $request['id_kas'];
            } elseif ($request['metode_transaksi'] == "Bank") {
                  return $request['id_bank'];
            } else {
                  return $request['id_piutang'];
            }
      }

      /**
       * ambil id_coa untuk akun kredit jurnal
       *
       * @param mixed $request
       * @return mixed
       **/
      public function getIdKredit($request)
      {
            if ($request['metode_transaksi'] == "Kas") {
                  return $request['id_kas'];
            } elseif ($request['metode_transaksi'] == "Bank") {
                  return $request['id_bank'];
            } else {
                  return $request['id_hutang'];
            }
      }

      public function getKasBank()
      {
            return [
                  'akunKas' => self::getCoaKas(),
                  'akunBank' => self::getCoaBank(),
                  'akunPiutang' => self::getCoaPiutang(),
            ];
      }

      public function getAkunBelanja()
      {
            return [
                  'akunKas' => self::getCoaKas(),
                  'akunBank' => self::getCoaBank(),
                  'akunHutang' => self::getCoaHutang(),
            ];
      }

      public function getCoaKas()
      {
            return Coa::where('nama', 'Kas')->get();
      }

      public function getCoaBank()
      {
            return Coa::where('subkategori', 'Kas & Bank')
                  ->whereNot('nama', 'Kas')->get();
      }

      public function getCoaPiutang()
      {
            return Coa::where('subkategori', 'Piutang')->get();
      }

      public function getCoaHutang()
      {
            return Coa::where('subkategori', 'Hutang')->get();
      }

      public function getJenisPendapatan($id)
      {
            return Coa::where('id_coa', $id)->value('nama');
      }
}
