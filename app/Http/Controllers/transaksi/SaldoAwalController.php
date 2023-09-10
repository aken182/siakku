<?php

namespace App\Http\Controllers\transaksi;

use DateTime;
use App\Models\Coa;
use App\Models\Satuan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Services\BarangService;
use App\Services\SaldoAwalService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\SaldoAwalRequest;
use App\Http\Requests\SaldoAwalBarangRequest;
use App\Http\Requests\TanggalSaldoAwalRequest;
use App\Services\SaldoAwalBarangService;

class SaldoAwalController extends Controller
{
      protected $transaksiService;
      protected $saldoAwalService;
      protected $saldoBarangService;
      protected $barangService;
      private $active;
      private $unit;
      private $route;
      private $jenis;
      private $title;
      private $coa;
      private $routeMain;
      private $routeImport;

      public function __construct(TransaksiService $transaksi, SaldoAwalService $saldo)
      {
            $this->transaksiService = $transaksi;
            $this->saldoAwalService = $saldo;
            $this->barangService = new BarangService;
            $this->saldoBarangService = new SaldoAwalBarangService;
            $this->route = Route::currentRouteName();
            $this->active = $this->saldoAwalService->getActive($this->route);
            $this->unit = $this->saldoAwalService->getUnit($this->route);
            $this->jenis = $this->saldoAwalService->getJenis($this->route);
            $this->title = 'Saldo Awal ' . $this->jenis;
            $this->coa = Coa::all();
            $this->routeMain = $this->saldoAwalService->getRouteMain($this->jenis, $this->unit);
            $this->routeImport = $this->saldoAwalService->getRouteImport($this->jenis, $this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            if ($this->active === 'form-tanggal') {
                  return $this->createTanggal();
            }
            $data = [
                  'transaksi' => $this->transaksiService->getHistoryTransaction($this->route, $this->unit),
                  'title' => $this->title,
                  'childTitle' => 'History Transaksi',
                  'active' => $this->active,
                  'routeEdit' => $this->saldoAwalService->getRouteEdit($this->route),
                  'unit' => $this->unit,
                  'jenis' => $this->jenis,
                  'routeMain' => $this->routeMain,
                  'routeImport' => $this->routeImport,
            ];

            return view('content.saldo-awal.main', $data);
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
      public function createTanggal()
      {
            $data = [
                  'title' => $this->title,
                  'childTitle' => 'Form Tanggal Mulai',
                  'active' => $this->active,
                  'unit' => $this->unit,
                  'jenis' => $this->jenis,
                  'routeMain' => $this->routeMain,
                  'routeImport' => $this->routeImport,
                  'routeStore' => $this->saldoAwalService->getRouteStoreTanggal($this->route),
            ];

            return view('content.saldo-awal.main', $data);
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
      public function storeTanggal(TanggalSaldoAwalRequest $request)
      {
            $date = DateTime::createFromFormat('d/m/Y', $request->input('tanggal_terakhir'));
            $tglTransaksi = $date->format('Y-m-d');
            $routeCreate = $this->saldoAwalService->getRouteCreateTransaksi($this->route);

            return redirect()->route($routeCreate, ['tgl_transaksi' => $tglTransaksi]);
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
      public function createSaldoAwal(Request $request)
      {
            $data = [
                  'title' => $this->title,
                  'childTitle' => 'Form Input Saldo Awal',
                  'unit' => $this->unit,
                  'active' => $this->active,
                  'jenis' => $this->jenis,
                  'routeMain' => $this->routeMain,
                  'routeImport' => $this->routeImport,
                  'coa' => $this->coa,
                  'satuan' => Satuan::all(),
                  'barang' => $this->barangService->getDataBarang($this->unit, $this->jenis),
                  'unitBarang' => $this->barangService->getDataUnit($this->unit),
                  'routeStore' => $this->saldoAwalService->getRouteStoreTransaksi($this->route),
                  "tgl_transaksi" => $request->input('tgl_transaksi'),
            ];
            return view('content.saldo-awal.main', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function storeCoa(SaldoAwalRequest $request)
      {
            $total = $request->input('total_debet') + $request->input('total_kredit');
            $kode = kode(new Transaksi, 'SLDOC-', 'kode');
            $tanggal = $request->input('tgl_transaksi');
            $this->saldoAwalService->createTransaksiSaldoAwalCoa($total, $tanggal, $kode, $this->unit);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($kode);
            $this->saldoAwalService->createSaldoAwalCoa($request, $id_transaksi, $this->coa);
            alert()->success('Sukses', 'Berhasil menambah data saldo awal COA unit ' . $this->unit . '.');
            return redirect()->route($this->routeMain);
      }

      public function storeBarang(SaldoAwalBarangRequest $request)
      {
            // $data = json_decode($request->input('data_barang'), true);
            $kode = $this->saldoBarangService->getKode(new Transaksi, $this->jenis);
            $this->saldoBarangService->create($request, $kode, $this->unit, $this->jenis);
            alert()->success('Sukses', 'Berhasil menambah data saldo awal ' . $this->jenis . ' unit ' . $this->unit . '.');
            return redirect()->route($this->routeMain);
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function editCoa()
      {
            $detailTransaksi = $this->transaksiService->saldoAwal($this->unit);
            $transaksi = $this->transaksiService->getTransaksiSaldoAwal($this->unit);
            $data = [
                  'title' => $this->title,
                  'childTitle' => 'Form Edit Saldo Awal',
                  'unit' => $this->unit,
                  'active' => $this->active,
                  'jenis' => $this->jenis,
                  'routeMain' => $this->routeMain,
                  'routeImport' => $this->routeImport,
                  'coa' => $this->saldoAwalService->getCoa($this->unit, $this->coa, $transaksi->id_transaksi),
                  'id_transaksi' => $transaksi->id_transaksi,
                  'tgl_transaksi' => $transaksi->tgl_transaksi,
                  'routeStore' => $this->saldoAwalService->getRouteUpdateTransaksi($this->route),
                  "totalDebet" => $detailTransaksi->where('posisi_dr_cr', 'debet')->sum('saldo'),
                  "totalKredit" => $detailTransaksi->where('posisi_dr_cr', 'debet')->sum('saldo'),
            ];
            // dd($data['coa']);
            return view('content.saldo-awal.main', $data);
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function editBarang()
      {
            // $detailTransaksi = $this->transaksiService->saldoAwalBarang($this->unit, $this->jenis);
            $transaksi = $this->transaksiService->getTransaksiSaldoAwal($this->unit, $this->jenis);
            $data = [
                  'title' => $this->title,
                  'childTitle' => 'Form Edit Saldo Awal',
                  'unit' => $this->unit,
                  'active' => $this->active,
                  'jenis' => $this->jenis,
                  'routeMain' => $this->routeMain,
                  'routeImport' => $this->routeImport,
                  'satuan' => Satuan::all(),
                  'barang' => $this->barangService->getDataBarang($this->unit, $this->jenis),
                  'unitBarang' => $this->barangService->getDataUnit($this->unit),
                  'id_transaksi' => $transaksi->id_transaksi,
                  'tgl_transaksi' => $transaksi->tgl_transaksi,
                  'routeStore' => $this->saldoAwalService->getRouteUpdateTransaksi($this->route),
                  'detail' => $this->transaksiService->saldoAwalBarang($this->unit, $this->jenis)
            ];
            return view('content.saldo-awal.main', $data);
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function updateCoa(SaldoAwalRequest $request, $id)
      {
            $this->saldoAwalService->updateTransaksiSaldoAwalCoa($request, $id, $this->coa);
            alert()->success('Sukses', 'Berhasil mengubah data saldo awal COA unit ' . $this->unit . '.');
            return redirect()->route($this->routeMain);
      }

      /**
       * Mengupdate data saldo awal barang.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function updateBarang(SaldoAwalBarangRequest $request, $id)
      {
            $this->saldoBarangService->update($request, $id, $this->jenis, $this->unit);
            alert()->success('Sukses', 'Berhasil mengubah data saldo awal ' . $this->jenis . ' unit ' . $this->unit . '.');
            return redirect()->route($this->routeMain);
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show($id)
      {
            //
      }

      /**
       * Menampikan form import saldo awal
       *
       **/
      public function import()
      {
            $data = [
                  'title' => $this->title,
                  'childTitle' => 'Import Excel',
                  'active' => $this->active,
                  'routeStore' => $this->saldoAwalService->getRouteStoreImport($this->route),
                  'routeTemplate' => $this->saldoAwalService->getRouteTemplateImport($this->route),
                  'unit' => $this->unit,
                  'jenis' => $this->jenis,
                  'routeMain' => $this->routeMain,
                  'routeImport' => $this->routeImport,
            ];

            return view('content.saldo-awal.main', $data);
      }
}
