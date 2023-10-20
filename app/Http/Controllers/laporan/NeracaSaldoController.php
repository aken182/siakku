<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Services\AccountingService;
use App\Services\NeracaService;
use Illuminate\Support\Facades\Route;

class NeracaSaldoController extends Controller
{
      protected $transaksiService;
      protected $neracaService;
      protected $accountingService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->accountingService = new AccountingService;
            $this->neracaService = new NeracaService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $bulanLalu = ($other['bulan'] > 1) ? $other['bulan'] - 1 : null;
            $data = [
                  'unit' => $this->unit,
                  'title' => 'Neraca Unit ' . $this->unit,
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "bulan" => $other['bulan'],
                  "tahun" => $other['tahun'],
                  "namaBulanIni" => $other['nama_bulan'],
                  "namaBulanLalu" => bulan_indonesia($bulanLalu),
                  'lap' => $this->neracaService->getRekap($this->unit, $other['bulan'], $other['tahun'])
            ];
            return view('content.laporan.neraca', $data);
      }

      /**
       * undocumented function summary
       *
       **/
      public function neracaSaldo(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $getneraca = $this->accountingService->getNeracaSaldo($other['bulan'], $other['tahun'], $this->unit);
            usort($getneraca['kategori'], function ($a, $b) {
                  return strnatcmp($a['header'], $b['header']);
            });
            $post = [
                  'bulan' => $other['bulan'],
                  'tahun' => $other['tahun']
            ];
            $data = [
                  'unit' => $this->unit,
                  'title' => 'Neraca Saldo Unit ' . $this->unit,
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "neracas" => $getneraca['neraca'],
                  "kategories" => $getneraca['kategori'],
                  "routeBukuBesar" => ($this->unit === 'Pertokoan') ? 'lut-buku-besar' : 'lus-buku-besar',
                  "post" => $post
            ];
            return view('content.laporan.neraca-saldo', $data);
      }
}
