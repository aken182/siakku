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
}
