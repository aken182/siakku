<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Main_penjualan;

class PenjualanService
{

      public function getDataPenjualan($unit, $route, $keywords = null)
      {
            $detailPenjualan = self::getDetailPenjualan($unit, $keywords);
            $penjualan = self::getPenjualan($detailPenjualan);
            return $penjualan;
            // $result = paginate($penjualan);
            // $result->withPath($route);
      }

      public function getDetailPenjualan($unit, $keywords = null)
      {
            return Transaksi::where('unit', $unit)
                  ->where(function ($query) {
                        $query->where('detail_tabel', 'detail_penjualan');
                  })
                  ->orWhere(function ($query) use ($unit) {
                        $query->where('unit', $unit)
                              ->where('detail_tabel', 'detail_penjualan_lain');
                  })
                  ->where(function ($query) use ($keywords) {
                        $query->where('kode', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('tgl_transaksi', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('keterangan', 'LIKE', '%' . $keywords . '%')
                              ->orWhere('total', 'LIKE', '%' . $keywords . '%');
                  })->get();
      }

      public function getPenjualan($detailPenjualan)
      {
            $penjualan = [];
            foreach ($detailPenjualan as $p) {
                  $status = Main_penjualan::where('id_transaksi', $p->id_transaksi)->value('status_penjualan');
                  array_push($penjualan, [
                        'id_transaksi' => $p->id_transaksi,
                        'detail_tabel' => $p->detail_tabel,
                        'kode' => $p->kode,
                        'tipe' => $p->tipe,
                        'tgl_transaksi' => $p->tgl_transaksi,
                        'keterangan' => $p->keterangan,
                        'total' => $p->total,
                        'status' => $status
                  ]);
            }
            return $penjualan;
      }
}
