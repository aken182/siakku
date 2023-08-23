<?php

namespace App\Services;

use App\Models\Jabatan;

class JabatanService
{
      public function getDataJabatan($id)
      {
            return Jabatan::with('anggota')->where('id_jabatan', $id)->first();
      }
}
