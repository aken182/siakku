<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BarangService;

class LaporanGudangController extends Controller
{
      protected $gudangService;

      public function __construct()
      {
            $this->gudangService = new BarangService;
      }

      public function index(Request $request)
      {
            //
      }
}
