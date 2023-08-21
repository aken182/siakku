<?php

namespace App\Services;

use App\Models\Profil_kpri;

class ProfilKpriService
{
      public function getAllData($id)
      {
            return Profil_kpri::find($id);
      }

      public function update($id, $request)
      {
            $data = $request->except(['_token', '_method']);
            // dd($data);
            Profil_kpri::where('id', $id)->update($data);
      }
}
