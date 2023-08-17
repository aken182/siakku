<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PdfExcelService;

class PdfExcelController extends Controller
{
      protected $laporanService;

      public function __construct()
      {
            $this->laporanService = new PdfExcelService;
      }

      public function index(Request $request)
      {
            //
      }
}
