<?php

namespace App\Http\Controllers\laporan;

use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ImportExportService;

class ExportController extends Controller
{
      protected $laporanService;

      public function __construct()
      {
            $this->laporanService = new ImportExportService;
      }

      public function excel(Request $request)
      {
            $route = $request->route()->getName();
            $title = $this->laporanService->getDataExport($route);
            return Excel::download(new LaporanExport($request), $title['jenisTabel'] . '.xlsx');
      }

      public function pdf()
      {
      }
}
