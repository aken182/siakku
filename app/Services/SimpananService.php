<?php

namespace App\Services;

use App\Models\Simpanan;

class SimpananService
{
      public function getSimpanan($id)
      {
            return Simpanan::where('id_simpanan', $id)->first();
      }
}
