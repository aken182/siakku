<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PenjualanService;

class LaporanPenjualanController extends Controller
{
      protected $penjualanService;

      public function __construct()
      {
            $this->penjualanService = new PenjualanService;
      }

      public function index(Request $request)
      {
            $data = [
                  'title' => 'Laporan Penjualan'
            ];

            return view('content.pendapatan.main', $data);
      }
}
