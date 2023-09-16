<?php

namespace App\Services\dataTable;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class DataTableTransaksiService
{
      /**
       * mengambil value kolom stok
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultKode($data, $route)
      {
            $tipeClass = $data->tipe == 'kadaluwarsa' ? 'text-danger' : 'text-primary';
            $result = '<a class="' . $tipeClass . '" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
             data-bs-html="true" href="' . route($route, Crypt::encrypt($data->id_transaksi)) . '
             " title="Klik disini untuk melihat detail !">' . $data->kode . '</a>';
            return $result;
      }

      /**
       * Merender dan mengambil data tabel
       * penjualan dalam bentuk json
       *
       * @param mixed $data
       * @param mixed $route
       * @return \Illuminate\Http\JsonResponse
       *
       **/
      public function getDataTable($data, $route)
      {
            return DataTables::of($data)
                  ->editColumn('kode', function ($data) use ($route) {
                        $result = self::getResultKode($data, $route);
                        return $result;
                  })
                  ->editColumn('tgl_transaksi', function ($data) {
                        return date('d-m-Y', strtotime($data->tgl_transaksi));
                  })
                  ->editColumn('total', function ($data) {
                        return '<div style="text-align:right;">' . buatrp($data->total) . '</div>';
                  })
                  ->rawColumns(['kode', 'tgl_transaksi', 'total'])
                  ->make(true);
      }
}
