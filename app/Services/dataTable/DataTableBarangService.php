<?php

namespace App\Services\dataTable;

use App\Models\Barang;
use Yajra\DataTables\DataTables;

class DataTableBarangService
{
      /**
       * mengambil value kolom stok
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultStok($barang)
      {
            if ($barang->stok == null | $barang->stok <= 0) {
                  $result = '<span class="badge bg-danger">Stok kosong !</span>';
            } else {
                  $result = $barang->stok . " " . $barang->satuan->nama_satuan;
            }
            return $result;
      }

      /**
       * mengambil value kolom harga jual
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultHargaBarang($barang)
      {
            if ($barang->harga_barang == null | $barang->harga_barang == 0) {
                  $result = '<span class="badge bg-danger">Harga kosong!</span>';
            } else {
                  $result = buatrp($barang->harga_barang) . "/" . $barang->satuan->nama_satuan;
            }
            return $result;
      }

      /**
       * mengambil value kolom nilai buku
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultNilaiBuku($barang)
      {
            if ($barang->nilai_saat_ini == null | $barang->nilai_saat_ini == 0) {
                  $result = '<span class="badge bg-danger">Nilai kosong!</span>';
            } else {
                  $result = buatrp($barang->nilai_saat_ini) . "/" . $barang->satuan->nama_satuan;
            }
            return $result;
      }

      /**
       * mengambil value kolom harga jual
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultHargaJual($barang)
      {
            if ($barang->harga_jual == null | $barang->harga_jual <= 0) {
                  $result = '<span class="badge bg-danger">Harga kosong!</span>';
            } else {
                  $result = buatrp($barang->harga_jual) . "/" . $barang->satuan->nama_satuan;
            }
            return $result;
      }

      /**
       * mengambil value kolom aksi
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultAksi($barang, $routeMain)
      {
            $route = self::getRouteDataTable($routeMain);
            $result = '<a type="button" class="btn btn-sm btn-outline-primary" href="' . route($route['edit'], ['id' => $barang->id_barang]) . '">Edit</a> 
            <a type="button" class="btn btn-sm btn-outline-danger" href="' . route($route['destroy'], ['id' => $barang->id_barang]) . '" data-confirm-delete="true">Hapus</a>';
            return $result;
      }

      /**
       * mengambil route untuk value 
       * kolom aksi
       *
       * @param mixed $barang
       * @return string
       **/
      public function getRouteDataTable($route)
      {
            $data = [];
            switch ($route) {
                  case 'mdt-persediaan.list':
                        $data['edit'] = 'mdt-persediaan.edit';
                        $data['destroy'] = 'mdt-persediaan.destroy';
                        $data['posisi'] = 'persediaan';
                        $data['unit'] = 'Pertokoan';
                        break;
                  case 'mdt-inventaris.list':
                        $data['edit'] = 'mdt-inventaris.edit';
                        $data['destroy'] = 'mdt-inventaris.destroy';
                        $data['posisi'] = 'inventaris';
                        $data['unit'] = 'Pertokoan';
                        break;
                  case 'mds-inventaris.list':
                        $data['edit'] = 'mds-inventaris.edit';
                        $data['destroy'] = 'mds-inventaris.destroy';
                        $data['posisi'] = 'inventaris';
                        $data['unit'] = 'Simpan Pinjam';
                        break;
            }
            return $data;
      }

      /**
       * Merender dan mengambil data tabel
       * persediaan dalam bentuk json
       *
       * @param mixed $data
       * @param mixed $route
       * @return \Illuminate\Http\JsonResponse
       *
       **/
      public function getDataTablePersediaan($data, $route)
      {
            return DataTables::of($data)
                  ->addIndexColumn()
                  ->addColumn('tpk', function ($data) {
                        return $data->unit->nama;
                  })
                  ->editColumn('stok', function (Barang $barang) {
                        return self::getResultStok($barang);
                  })
                  ->addColumn('harga_barang', function (Barang $barang) {
                        return self::getResultHargaBarang($barang);
                  })
                  ->editColumn('harga_jual', function (Barang $barang) {
                        return self::getResultHargaJual($barang);
                  })
                  ->addColumn('aksi', function (Barang $barang) use ($route) {
                        return self::getResultAksi($barang, $route);
                  })
                  ->rawColumns(['stok', 'harga_barang', 'harga_jual', 'aksi'])
                  ->make(true);
      }

      /**
       * Merender dan mengambil data tabel
       * inventaris dalam bentuk json
       *
       * @param mixed $data
       * @param mixed $route
       * @return \Illuminate\Http\JsonResponse
       *
       **/
      public function getDataTableInventaris($data, $route)
      {
            return DataTables::of($data)
                  ->addIndexColumn()
                  ->addColumn('tpk', function ($data) {
                        return $data->unit->nama;
                  })
                  ->editColumn('stok', function (Barang $barang) {
                        return self::getResultStok($barang);
                  })
                  ->editColumn('harga_barang', function (Barang $barang) {
                        return self::getResultHargaBarang($barang);
                  })
                  ->editColumn('nilai_saat_ini', function (Barang $barang) {
                        return self::getResultNilaiBuku($barang);
                  })
                  ->editColumn('umur_ekonomis', function (Barang $barang) {
                        return $barang->umur_ekonomis . ' tahun';
                  })
                  ->editColumn('harga_jual', function (Barang $barang) {
                        return self::getResultHargaJual($barang);
                  })
                  ->addColumn('aksi', function (Barang $barang) use ($route) {
                        return self::getResultAksi($barang, $route);
                  })
                  ->rawColumns(['stok', 'harga_barang', 'nilai_saat_ini', 'umur_ekonomis', 'harga_jual', 'aksi'])
                  ->make(true);
      }
}
