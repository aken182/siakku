<?php

namespace App\Services\dataTable;

use Yajra\DataTables\DataTables;

class AktivaTetapTableService
{
      /**
       * mengambil value kolom stok
       *
       * @param mixed $barang
       * @return string
       **/
      public function getResultStok($data)
      {
            $tipeClass = $data['qty'] === 'barang kosong !' ? 'text-danger' : '';
            $result = '<div class="' . $tipeClass . ' text-capitalize" style="text-align:right;">' . $data['qty'] . '</div>';
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
                  ->editColumn('no', function ($data) {
                        return '<div style="text-align:center;">' . ($data['no']) . '.</div>';
                  })
                  ->editColumn('qty', function ($data) {
                        $result = self::getResultStok($data);
                        return $result;
                  })
                  ->editColumn('harga_sblm', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['harga_sblm']) . '</div>';
                  })
                  ->editColumn('harga_bjln', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['harga_bjln']) . '</div>';
                  })
                  ->editColumn('harga_perolehan', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['harga_perolehan']) . '</div>';
                  })
                  ->editColumn('pny_sblm', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['pny_sblm']) . '</div>';
                  })
                  ->editColumn('pny_bjln', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['pny_bjln']) . '</div>';
                  })
                  ->editColumn('penyusutan', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['penyusutan']) . '</div>';
                  })
                  ->editColumn('nilai_buku', function ($data) {
                        return '<div style="text-align:right;">' . cekAccountingDecimal($data['nilai_buku']) . '</div>';
                  })
                  ->rawColumns(['no', 'qty', 'harga_sblm', 'harga_bjln', 'harga_perolehan', 'pny_sblm', 'pny_bjln', 'penyusutan', 'nilai_buku'])
                  ->make(true);
      }
}
