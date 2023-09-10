<?php

namespace App\Http\Controllers\laporan;

use Carbon\Carbon;
use App\Models\Coa;
use Illuminate\Http\Request;
use App\Services\AccountingService;
use App\Http\Controllers\Controller;

class BukuBesarController extends Controller
{
      protected $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }

      public function index(Request $request)
      {
            $d = $this->accountingService->getDataToBukuBesar();
            $r = $this->accountingService->getTanggalIdCoa($request);
            $c = $this->accountingService->getCoaToBukuBesar($r['id_coa'], $d['unit']);
            $buku_besar = $this->accountingService->getBukuBesar($r['id_coa'], $r['bulan'], $r['tahun'], $d['unit']);
            $date = Carbon::createFromFormat('Y-m-d', $r['tahun'] . '-' . $r['bulan'] . '-01');
            $nama_bulan = bulan_indonesia($r['bulan']);
            $data = [
                  "title" => $d['title'],
                  "title2" => "KPRI Usaha Jaya Larantuka",
                  "title3" => "Periode $nama_bulan - " . $r['tahun'],
                  "coas" => $c['coa'],
                  "unit" => $d['unit'],
                  "buku_besar" => $buku_besar->sortBy('transaksi.tgl_transaksi'),
                  "saldo_awal" => $this->accountingService->getSaldoAwal($r['id_coa'], $date, $d['unit']),
                  "route_post" => $d['route_post'],
                  "route_detail" => $d['route_detail'],
                  "route_pdf" => $d['route_pdf'],
                  "nama" => $c['nama'],
                  "kode" => $c['kode'],
                  "kategori" => $c['kategori'],
                  "post" => $r
            ];
            return view('content.laporan.buku-besar', $data);
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
      public function pdf($bulan, $tahun, $id_coa)
      {
            # code...
      }
}
