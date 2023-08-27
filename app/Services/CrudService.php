<?php

namespace App\Services;

class CrudService
{
      public function create($request, $model)
      {
            $data = $request->except(['_token', 'file_foto', 'file_gambar']);
            $model::create($data);
      }

      public function update($request, $idColumn, $idValue, $model)
      {
            $data = $request->except(['_token', '_method', 'file_foto', 'file_gambar', 'slug']);
            $model::where($idColumn, $idValue)->update($data);
      }

      public function delete($idColumn, $idValue, $model)
      {
            $model::where($idColumn, $idValue)->delete();
      }

      public function messageConfirmDelete($title)
      {
            $data['title'] = 'Hapus ' . $title . '!';
            $data['text'] = "Yakin ingin menghapus data " . $title . " ini? 
            Sebaiknya hapus terlebih dahulu data transaksi atau master data lain yang memiliki 
            data " . $title . " ini sebelum anda menghapusnya.";
            return $data;
      }
}
