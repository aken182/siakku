<?php

namespace App\Services;

class ImageService
{

      public function getImageName($nama, $kode, $file)
      {

            $imageName = $nama . '-' . $kode . '-' . time() . '.' . $file->extension();
            return $imageName;
      }

      public function uploadImage($file, $imageName, $folder)
      {
            $file->storeAs($folder, $imageName, 'public');
      }
}
