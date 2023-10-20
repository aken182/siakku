<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\PinjamanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LaporanPinjamanController extends Controller
{
      protected $pinjamanService;
      protected $transaksiService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->pinjamanService = new PinjamanService;
            $this->transaksiService = new TransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $bulanLalu = ($other['bulan'] > 1) ? $other['bulan'] - 1 : null;
            $data = [
                  'unit' => $this->unit,
                  'title' => 'Laporan Pinjaman',
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "bulan" => $other['bulan'],
                  "tahun" => $other['tahun'],
                  "namaBulanIni" => $other['nama_bulan'],
                  "namaBulanLalu" => bulan_indonesia($bulanLalu),
                  // 'lap' => $this->neracaService->getRekap($this->unit, $other['bulan'], $other['tahun'])
            ];

            return view('content.laporan.pinjaman', $data);
      }
}
