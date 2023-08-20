<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TransaksiService;

class LaporanTransaksiController extends Controller
{
      protected $transaksiService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
      }

      public function index(Request $request)
      {
            $data = [
                  'title' => 'Laporan Transaksi'
            ];

            return view('content.pendapatan.main', $data);
      }
}
