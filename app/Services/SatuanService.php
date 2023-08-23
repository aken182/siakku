<?php

namespace App\Services;

use App\Models\Satuan;

class SatuanService
{
      public function getDataSatuan($id)
      {
            return Satuan::where('id_satuan', $id)->first();
      }
}
