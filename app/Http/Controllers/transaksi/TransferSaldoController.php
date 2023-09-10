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

class TransferSaldoController extends Controller
{
      protected $transaksiService;
      protected $transferSaldoService;
      protected $unit;
      protected $route;
      protected $routeMain;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->transferSaldoService = new TransferSaldoService;
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
                  'routeShow' => $route['show'],
                  'unit' => $this->unit,
                  'transaksi' => $this->transaksiService->getHistoryTransaction($this->route, $this->unit),
            ];
            return view('content.transfer-saldo.main', $data);
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
            /*konvert rupiah ke angka*/
            $request["jumlah"] = convertToNumber($request->input("jumlah"));

            /*upload file nota transaksi dan get image*/
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->file('nomor'),
                  'nota-transfer-saldo'
            );

            /*Menentukan id dan kode transaksi penyesuaian*/
            $detailPenyesuaian = $this->transferSaldoService->getDetailPenyesuaian($request);
            $idTransPeny = $detailPenyesuaian['idTransPeny'];
            $invoicepny = $detailPenyesuaian['invoicepny'];

            /*Buat transaksi */
            $this->transferSaldoService->createTransaksi($request, $invoicepny, $imageName, $this->unit);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
            $this->transferSaldoService->createDetailTransaksi($request, $id_transaksi);

            /*Buat jurnal*/
            $this->transferSaldoService->createJurnal($request, $id_transaksi, $idTransPeny);
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
