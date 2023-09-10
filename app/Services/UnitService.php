<?php

namespace App\Services;

use App\Models\Unit;

class UnitService
{
      public function getDataUnit($id)
      {
            return Unit::where('id_unit', $id)->first();
      }

      public function getKodeUnit($kode)
      {
            return Unit::where('kode_unit', $kode)->value('kode_unit');
      }

      public function getUnitToImport($nama, $unit)
      {

            return Unit::where('nama', $nama)
                  ->where('unit', $unit)->first();
      }

      public function createUnitToImport($data_unit, $indexUnit = null)
      {
            foreach ($data_unit as $row) {

                  $unit = self::getKodeUnit($row['kode_unit']);
                  if ($unit === $row['kode_unit']) {
                        continue;
                  } else {
                        $u = $indexUnit == null ? $row['unit'] : $indexUnit;
                        Unit::create([
                              'kode_unit' => $row['kode_unit'],
                              'nama' => $row['nama_unit'],
                              'unit' => $u,
                        ]);
                  }
            }
      }
}
