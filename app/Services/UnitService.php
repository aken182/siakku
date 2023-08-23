<?php

namespace App\Services;

use App\Models\Unit;

class UnitService
{
      public function getDataUnit($id)
      {
            return Unit::where('id_unit', $id)->first();
      }
}
