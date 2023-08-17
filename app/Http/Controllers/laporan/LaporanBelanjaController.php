<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BelanjaBarangService;

class LaporanBelanjaController extends Controller
{
      protected $belanjaService;

      public function __construct()
      {
            $this->belanjaService = new BelanjaBarangService;
      }

      public function index(Request $request)
      {
            //
      }
}
