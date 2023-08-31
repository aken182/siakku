<?php

namespace App\Services;

use App\Models\Satuan;

class SatuanService
{
      public function getDataSatuan($id)
      {
            return Satuan::where('id_satuan', $id)->first();
      }

      public function getSatuanToImport($nama)
      {
            return Satuan::where('nama_satuan', $nama)->first();
      }

      public function createSatuanToImport($data)
      {
            foreach ($data as $d) {
                  $satuan = self::getNamaSatuan($d['satuan']);

                  if ($satuan === $d['satuan']) {
                        continue;
                  } else {
                        Satuan::create([
                              'nama_satuan' => $d['satuan']
                        ]);
                  }
            }
      }

      public function getNamaSatuan($satuan)
      {
            return Satuan::where('nama_satuan', $satuan)->value('nama_satuan');
      }
}
