<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Services\LabaRugiService;
use Illuminate\Support\Facades\Route;

class LabaRugiController extends Controller
{
      protected $transaksiService;
      protected $labaRugiService;
      private $unit;
      private $route;
      private $mainRoute;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->labaRugiService = new LabaRugiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
            $this->mainRoute = $this->transaksiService->getMainRouteLabaRugi($this->unit);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $bulanLalu = ($other['bulan'] > 1) ? $other['bulan'] - 1 : null;
            $data = [
                  'title' => 'Perhitungan Laba Rugi',
                  'unit' => $this->unit,
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => 'Unit ' . $this->unit,
                  "title4" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "bulan" => $other['bulan'],
                  "tahun" => $other['tahun'],
                  "namaBulanIni" => $other['nama_bulan'],
                  "namaBulanLalu" => bulan_indonesia($bulanLalu),
                  'laporan' => $this->labaRugiService->getLaporan($this->unit, $other['bulan'], $other['tahun'])
            ];
            return view('content.laporan.laba-rugi', $data);
      }
}
