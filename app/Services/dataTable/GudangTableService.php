<?php

namespace App\Services\dataTable;

use Yajra\DataTables\DataTables;

class GudangTableService
{
      /**
       * mengambil value kolom stok
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultStok($data)
      {
            $tipeClass = $data['stok'] === 'stok kosong!' ? 'text-danger' : '';
            $result = '<div class="' . $tipeClass . '" style="text-align:right;">' . $data['stok'] . '</div>';
            return $result;
      }

      /**
       * Merender dan mengambil data tabel
       * gudang dalam bentuk json
       *
       * @param mixed $data
       * @return \Illuminate\Http\JsonResponse
       *
       **/
      public function getDataTable($data)
      {
            return DataTables::of($data)
                  ->editColumn('stok', function ($data) {
                        $result = self::getResultStok($data);
                        return $result;
                  })
                  ->editColumn('harga', function ($data) {
                        return '<div style="text-align:right;">' . cekUangDecimal($data['harga']) . '</div>';
                  })
                  ->editColumn('jumlah', function ($data) {
                        return '<div style="text-align:right;">' . cekUangDecimal($data['jumlah']) . '</div>';
                  })
                  ->rawColumns(['stok', 'harga', 'jumlah'])
                  ->make(true);
      }
}
