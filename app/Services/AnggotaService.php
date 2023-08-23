<?php

namespace App\Services;

use App\Models\Anggota;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class AnggotaService
{
      protected $imageService;

      public function __construct(ImageService $var)
      {
            $this->imageService = $var;
      }

      public function getDataAnggotaView()
      {
            return Anggota::select('id_anggota', 'kode', 'nama', 'pekerjaan', 'tempat_tugas', 'status')->get();
      }

      public function getDataAnggota($id)
      {
            return Anggota::where('id_anggota', $id)->first();
      }

      public function getDataAnggotaToForm()
      {
            return Anggota::select('id_anggota', 'nama')
                  ->where('status', 'Aktif')->get();
      }

      public function getKode()
      {
            $kode = kode(new Anggota, 'AGT', 'kode');
            return $kode;
      }

      public function addPasFoto($request)
      {
            if ($request->file('file_foto') != null) {
                  $imageName = $this->imageService->getImageName('Foto', $request['kode'], $request->file('file_foto'));
                  $this->imageService->uploadImage($request->file('file_foto'), $imageName, 'foto-anggota');
                  $request['pas_foto'] = $imageName;
            }
      }

      public function updatePasFoto($request, $id)
      {
            if ($request->file('file_foto') != null) {
                  self::deletePasFoto($id);
                  $imageName = $this->imageService->getImageName('Foto', $request['kode'], $request->file('file_foto'));
                  $this->imageService->uploadImage($request->file('file_foto'), $imageName, 'foto-anggota');
                  $request['pas_foto'] = $imageName;
            }
      }

      public function deletePasFoto($id)
      {
            $anggota = self::getDataAnggota($id);
            $imageName = $anggota->pas_foto;
            $filePath = 'public/foto-anggota/' . $imageName;
            if (Storage::exists($filePath)) {
                  Storage::delete($filePath);
            }
      }
}
