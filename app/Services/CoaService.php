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
}
