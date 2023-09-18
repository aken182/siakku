<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Models\Detail_transfer_saldo;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Services\TransferSaldoService;
use App\Http\Requests\TransferSaldoRequest;
use App\Services\dataTable\DataTableTransaksiService;

class TransferSaldoController extends Controller
{
      protected $transaksiService;
      protected $transferSaldoService;
      protected $dataTableService;
      protected $unit;
      protected $route;
      protected $routeMain;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->transferSaldoService = new TransferSaldoService;
            $this->dataTableService = new DataTableTransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transferSaldoService->getUnitTransaksi($this->route);
            $this->routeMain = $this->transferSaldoService->getRouteMain($this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index(Request $request)
      {
            $route = $this->transferSaldoService->getRouteToIndex($this->route);
            $data = [
                  'title' => 'Transfer Saldo Kas & Bank',
                  'routeCreate' => $route['create'],
                  'routeList' => $route['list'],
                  'routeShow' => $route['show'],
                  'unit' => $this->unit,
            ];
            return view('content.transfer-saldo.main', $data);
      }

      /**
       * Mengambil data tabel transfer saldo 
       * berdasarkan request ajax
       *
       * @param \Illuminate\Http\Request $request
       * @return \Illuminate\Http\JsonResponse|void
       **/
      public function dataTable(Request $request)
      {
            if ($request->ajax()) {
                  $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
                  $route = $this->transferSaldoService->getRouteToTable($this->route);
                  $dataTables = $this->dataTableService->getDataTable($data, $route);
                  return $dataTables;
            }
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
            $prefix = $this->unit === 'Pertokoan' ? 'TRF-TK-' : 'TRF-SP-';
            $data = [
                  'title' => 'Transfer Saldo Kas & Bank',
                  'routeStore' => $this->transferSaldoService->getRouteStoreToCreate($this->route),
                  'routeMain' => $this->routeMain,
                  'coa' => $this->transferSaldoService->getCoa(),
                  'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
                  'saldoAkun' => $this->transferSaldoService->getSaldoAkun($this->unit),
                  'penyesuaian' => $this->transferSaldoService->getTransaksiPenyesuaian($this->unit),
                  'unit' => $this->unit,
            ];
            return view('content.transfer-saldo.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(TransferSaldoRequest $request)
      {
            $request["jumlah"] = convertToNumber($request->input("jumlah"));
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->input('nomor'),
                  'nota-transfer-saldo'
            );
            $id_penyesuaian = $request->input("id_penyesuaian") ?? null;
            $kodePenyesuaian = $this->transaksiService->getKodePenyesuaian($request->input('cek_penyesuaian'), $id_penyesuaian);
            /*Buat transaksi */
            $this->transferSaldoService->createTransaksi($request, $kodePenyesuaian, $imageName, $this->unit);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
            $this->transferSaldoService->createDetailTransaksi($request, $id_transaksi);
            /*Buat jurnal*/
            $this->transferSaldoService->createJurnal($request, $id_transaksi, $id_penyesuaian);
            alert()->success('Sukses', "Berhasil menambahkan transaksi pemindahan saldo.");
            return redirect()->route($this->routeMain);
      }

      public function detail(Request $request)
      {
            $id_transaksi = $request->input('transaksi_id');
            $details = Detail_transfer_saldo::with(['penerima', 'pengirim', 'transaksi'])->where('id_transaksi', $id_transaksi)->first();
            if (!$details) {
                  return response()->json(['error' => 'Detail transfer saldo tidak ditemukan'], 404);
            }
            $jurnals = Jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id_transaksi)->get();
            return response()->json(compact('details', 'jurnals'));
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show($id)
      {
            $id_transaksi = Crypt::decrypt($id);
            $title = 'Transfer Saldo Kas & Bank';
            $routeMain = $this->routeMain;
            $unit = $this->unit;
            $details = Detail_transfer_saldo::with(['penerima', 'pengirim', 'transaksi'])->where('id_transaksi', $id_transaksi)->first();
            $jurnals = Jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id_transaksi)->get();
            return view('content.transfer-saldo.show', compact('title', 'details', 'jurnals', 'routeMain', 'unit'));
      }
}
