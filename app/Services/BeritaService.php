<?php

namespace App\Services;

use App\Models\Berita;
use Illuminate\Support\Str;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class BeritaService
{
      protected $imageService;

      public function __construct()
      {
            $this->imageService = new ImageService;
      }

      public function getDataBerita($id)
      {
            return Berita::where('id_berita', $id)->first();
      }

      public function getDataBeritaSlug($slug)
      {
            $id = Berita::where('slug_berita', $slug)->value('id_berita');
            return Berita::where('id_berita', $id)->first();
      }

      public function getBerita()
      {
            return Berita::orderBy('tgl_berita', 'DESC')->paginate(6);
      }

      public function addGambarBerita($request, $kode)
      {
            if ($request->file('file_gambar') != null) {
                  $imageName = $this->imageService->getImageName('Gambar', $kode, $request->file('file_gambar'));
                  $this->imageService->uploadImage($request->file('file_gambar'), $imageName, 'berita');
                  $request['gambar_berita'] = $imageName;
            }
      }

      public function updateGambarBerita($request, $id, $kode)
      {
            if ($request->file('file_gambar') != null) {
                  self::deleteGambarBerita($id);
                  $imageName = $this->imageService->getImageName('Gambar', $kode, $request->file('file_gambar'));
                  $this->imageService->uploadImage($request->file('file_gambar'), $imageName, 'berita');
                  $request['gambar_berita'] = $imageName;
            }
      }

      public function deleteGambarBerita($id)
      {
            $berita = self::getDataBerita($id);
            $imageName = $berita->gambar_berita;
            $filePath = 'public/berita/' . $imageName;
            if (Storage::exists($filePath)) {
                  Storage::delete($filePath);
            }
      }

      public function updateSlug($title, $inputSlug, $id)
      {
            $oldTitle = Berita::where('id_berita', $id)->value('judul_berita');
            if ($oldTitle != $title) {
                  $slug = self::generateSlug($title);
            } else {
                  $slug = $inputSlug;
            }
            return $slug;
      }
      public function generateSlug($title)
      {
            $slug = Str::slug($title); // Mengubah judul menjadi slug
            $count = 2;

            // Cek apakah slug sudah ada dalam database, jika ada tambahkan angka unik
            while (Berita::where('slug_berita', $slug)->exists()) {
                  $slug = Str::slug($title) . '-' . $count;
                  $count++;
            }

            return $slug;
      }
}
