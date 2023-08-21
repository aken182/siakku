<?php

namespace App\Services;

use App\Models\Anggota;

class AnggotaService
{
      public function getDataAnggotaView()
      {
            return Anggota::select('id_anggota', 'kode', 'nama', 'pekerjaan', 'tempat_tugas', 'status')->get();
      }

      public function create($request)
      {
            $data = $request->except(['_token']);
            Anggota::create($data);
      }

      public function getKode()
      {
            $kode = kode(new Anggota, 'AGT', 'kode');
            return $kode;
      }
}
