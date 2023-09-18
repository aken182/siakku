<?php

namespace App\Services\dataTable;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class DataTableMainTransaksiService
{
      /**
       * mengambil value kolom stok
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultKode($data, $route)
      {
            $tipeClass = $data['tipe'] != 'kadaluwarsa' ? 'text-primary' : 'text-danger';
            $result = '<a class="' . $tipeClass . '" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
             data-bs-html="true" href="' . route($route, ['id' => Crypt::encrypt($data['id_transaksi']), 'detail' => $data['jenis_transaksi']]) . '
             " title="Klik disini untuk melihat detail !">' . $data['kode'] . '</a>';
            return $result;
      }

      /**
       * mengambil value kolom status
       *
       * @param mixed $data
       * @param mixed $unit
       * @return string
       **/
      public function getResultStatus($data, $unit, $route, $routeShow, $routeBayar)
      {
            if ($data['tipe'] != 'kadaluwarsa') {
                  if ($data['status'] != 'lunas') {
                        $result = '<a class="text-warning text-capitalize" data-bs-toggle="tooltip"
                          data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                          href="' . route($routeBayar, ['detail' => $data['jenis_transaksi'], 'unit' => $unit, 'route' => $route]) . '"
                          title="Klik disini untuk lunasi tagihan !"><span class="badge bg-warning">' . $data['status'] . '</span></a>';
                  } else {
                        $result = '<a class="text-success text-capitalize" data-bs-toggle="tooltip"
                          data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                          href="' . route($routeShow, ['id' => Crypt::encrypt($data['id_transaksi']), 'detail' => $data['jenis_transaksi']]) . '"
                          title="Klik disini untuk melihat detail !"><span class="badge bg-success">' . $data['status'] . '</span></a>';
                  }
            } else {
                  $result = '<span class="badge bg-danger">Kadaluwarsa</span>';
            }
            return $result;
      }

      /**
       * Merender dan mengambil data tabel
       * transaksi dalam bentuk json
       *
       * @param mixed $data
       * @param mixed $route
       * @return \Illuminate\Http\JsonResponse
       *
       **/
      public function getDataTableMain($data, $routeTable, $unit)
      {
            $route = $routeTable['show'];
            $routeBayar = $routeTable['create'];
            $mainRoute = $routeTable['main'];
            return DataTables::of($data)
                  ->editColumn('kode', function ($data) use ($route) {
                        $result = self::getResultKode($data, $route);
                        return $result;
                  })
                  ->editColumn('tgl_transaksi', function ($data) {
                        return date('d-m-Y', strtotime($data['tgl_transaksi']));
                  })
                  ->editColumn('status', function ($data) use ($unit, $mainRoute, $route, $routeBayar) {
                        $result = self::getResultStatus($data, $unit, $mainRoute, $route, $routeBayar);
                        return $result;
                  })
                  ->editColumn('total', function ($data) {
                        return '<div style="text-align:right;">' . buatrp($data['total']) . '</div>';
                  })
                  ->rawColumns(['kode', 'tgl_transaksi', 'status', 'total'])
                  ->make(true);
      }
}
