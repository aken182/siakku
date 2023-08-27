<?php

namespace App\Services;

use App\Models\Coa;

class CoaService
{
      public function getDataCoa($id)
      {
            return Coa::where('id_coa', $id)->first();
      }
}
