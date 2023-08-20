<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PinjamanService;

class LaporanPinjamanController extends Controller
{
      protected $pinjamanService;

      public function __construct()
      {
            $this->pinjamanService = new PinjamanService;
      }

      public function index(Request $request)
      {
            $data = [
                  'title' => 'Laporan Pinjaman'
            ];

            return view('content.pendapatan.main', $data);
      }
}
