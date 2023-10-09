<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LaporanTransaksiController extends Controller
{
      protected $transaksiService;
      private $unit;
      private $route;
      private $mainRoute;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
            $this->mainRoute = $this->transaksiService->getMainRouteLapTransaksi($this->unit);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataLapTransaksi($request->all(), $this->unit);
            $data = [
                  'title' => 'Laporan Transaksi Unit ' . $this->unit,
                  'unit' => $this->unit,
                  "title2" => "KPRI Usaha Jaya - Larantuka",
                  "title3" => "Periode " . $other['nama_bulan'] . ' - ' . $other['tahun'],
                  "transaksis" => $other['transaksi'],
                  "route_detail" => $this->mainRoute . '.detail',
                  "bulan" => $other['bulan'],
                  "tahun" => $other['tahun'],
            ];

            return view('content.laporan.transaksi', $data);
      }
}
