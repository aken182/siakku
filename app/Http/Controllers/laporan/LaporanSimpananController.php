<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SimpananService;

class LaporanSimpananController extends Controller
{
      protected $simpananService;

      public function __construct()
      {
            $this->simpananService = new SimpananService;
      }

      public function index(Request $request)
      {
            //
      }
}
