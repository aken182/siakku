<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\AccountingService;
use App\Http\Controllers\Controller;

class JurnalController extends Controller
{
      protected $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }

      /**
       * Menampilkan data jurnal umum.
       *
       * @param \Illuminate\Http\Request $request
       * @return \Illuminate\Http\Response
       */
      public function index(Request $request)
      {
            $route = $this->accountingService->getDataToJurnal();
            $tgl = $this->accountingService->getTanggal($request);
            $jurnal = $this->accountingService->getJurnal($tgl['bulan'], $tgl['tahun'], $route['unit']);
            $nama_bulan = bulan_indonesia($tgl['bulan']);
            $data = [
                  "title" => $route['title'],
                  "title2" => "KPRI Usaha Jaya - Larantuka",
                  "title3" => "Periode $nama_bulan -" . $tgl['tahun'],
                  "jurnals" => $jurnal->sortBy('transaksi.tgl_transaksi'),
                  "debet_seluruh" => $jurnal->where('posisi_dr_cr', 'debet')->sum('nominal'),
                  "kredit_seluruh" => $jurnal->where('posisi_dr_cr', 'kredit')->sum('nominal'),
                  "route_post" => $route['route_post'],
                  "route_detail" => $route['route_detail'],
                  "route_pdf" => $route['route_pdf'],
                  "post" => $tgl
            ];
            return view('content.laporan.jurnal', $data);
      }

      /**
       * undocumented function summary
       *
       * Undocumented function long description
       *
       * @param Type $var Description
       * @return type
       * @throws conditon
       **/
      public function pdf($bulan, $tahun)
      {
            # code...
      }
}
