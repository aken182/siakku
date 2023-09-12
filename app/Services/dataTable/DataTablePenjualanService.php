<?php

namespace App\Services\dataTable;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class DataTablePenjualanService
{
      /**
       * mengambil value kolom stok
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultKode($data, $route)
      {
            $tipeClass = $data['tipe'] == 'kadaluwarsa' ? 'text-danger' : 'text-primary';
            $tipeTitle = $data['tipe'] == 'kadaluwarsa' ? 'Detail Transaksi Kadaluwarsa' : 'Detail Transaksi';
            $result = '<a class="' . $tipeClass . '" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
          data-bs-html="true" href="' . route($route, ['id' => Crypt::encrypt($data['id_transaksi']), 'detail' => $data['detail_tabel']]) . '"
          title="<i class=\'bx bx-show bx-xs\'></i> <span>' . $tipeTitle . '</span>">' . $data['kode'] . '</a>';
            return $result;
      }

      /**
       * mengambil value kolom status
       *
       * @param mixed $data
       * @param mixed $unit
       * @return string
       **/
      public function getResultStatus($data, $unit)
      {
            if ($data['tipe'] == 'kadaluwarsa') {
                  $result = '<span class="text-danger">Kadaluwarsa</span>';
            } else {
                  if ($data['status'] != 'lunas') {
                        $result = '<a class="text-warning text-capitalize" data-bs-toggle="tooltip"
                          data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                          href="' . route('ptk-penjualan.create-pelunasan', ['detail_tabel' => $data['detail_tabel'], 'unit' => $unit]) . '"
                          title="<i class=\'bx bx-show bx-xs\' ></i> <span>Lunasi Piutang !</span>">' . $data['status'] . '</a>';
                  } else {
                        $result = '<a class="text-success text-capitalize" data-bs-toggle="tooltip"
                          data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                          href="' . route('ptk-penjualan.show', ['id' => Crypt::encrypt($data['id_transaksi']), 'detail' => $data['detail_tabel']]) . '"
                          title="<i class=\'bx bx-show bx-xs\' ></i> <span>Detail Transaksi</span>">' . $data['status'] . '</a>';
                  }
            }
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
      public function getDataTablePenjualan($data, $route, $unit)
      {
            return DataTables::of($data)
                  ->editColumn('kode', function ($data) use ($route) {
                        $result = self::getResultKode($data, $route);
                        return $result;
                  })
                  ->editColumn('tgl_transaksi', function ($data) {
                        return date('d-m-Y', strtotime($data['tgl_transaksi']));
                  })
                  ->editColumn('status', function ($data) use ($unit) {
                        $result = self::getResultStatus($data, $unit);
                        return $result;
                  })
                  ->editColumn('total', function ($data) {
                        return buatrp($data['total']);
                  })
                  ->rawColumns(['kode', 'tgl_transaksi', 'status', 'total'])
                  ->make(true);
      }
}
