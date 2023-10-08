<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Detail_penyusutan;
use App\Services\TransaksiService;
use App\Services\PenyusutanService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PenyusutanRequest;
use App\Services\dataTable\DataTableTransaksiService;

class PenyusutanController extends Controller
{
      protected $transaksiService;
      protected $penyusutanService;
      protected $dataTableService;
      private $route;
      private $unit;
      private $mainRoute;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->penyusutanService = new PenyusutanService;
            $this->dataTableService = new DataTableTransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->penyusutanService->getUnit($this->route);
            $this->mainRoute = $this->penyusutanService->getMainRoute($this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $data = [
                  'routeList' => $this->mainRoute . '.list',
                  'routeCreate' => route($this->mainRoute . '.step-satu'),
                  'createTitle' => 'Tambah Penyusutan',
                  'title' => 'Penyusutan Inventaris',
                  'unit' => $this->unit
            ];
            return view('content.penyusutan.main', $data);
      }


      /**
       * Show the list for data table a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function list(Request $request)
      {
            if ($request->ajax()) {
                  $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
                  $route = $this->penyusutanService->getRouteToTable($this->route);
                  $dataTables = $this->dataTableService->getDataTable($data, $route);
                  return $dataTables;
            }
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function stepSatu()
      {
            $barang = $this->penyusutanService->getInventaris($this->unit);
            $data = [
                  "title" => "Penyusutan Inventaris",
                  "title2" => "Form Penyusutan",
                  "units" => $this->penyusutanService->getUnitInventaris($barang),
                  "pnyPenyusutan" => $this->penyusutanService->getPenyesuaianInvoice($this->unit),
                  "barangs" => $barang,
                  "step" => 'satu',
                  "routePny" => $this->mainRoute . '.detail',
                  "mainRoute" => $this->mainRoute
            ];
            return view('content.penyusutan.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function storeSatu(PenyusutanRequest $request)
      {
            $penyesuaian = $this->penyusutanService->getDataPenyesuaian($request);
            $data = [
                  "title" => "Penyusutan Inventaris",
                  "title2" => "Form Penyusutan",
                  "penyesuaian" => json_encode($penyesuaian),
                  "barangs" => $this->penyusutanService->getDetail($request->input('inventaris'), $penyesuaian['id_transaksi_penyesuaian'], $penyesuaian['tipe']),
                  "step" => 'dua',
                  "mainRoute" => $this->mainRoute
            ];
            return view('content.penyusutan.create', $data);
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function stepDua(Request $request)
      {
            $id = json_decode($request->input('id_inventaris'), true);
            $penyesuaian = json_decode($request->input('penyesuaian'), true);
            $data = [
                  "title" => "Penyusutan Inventaris",
                  "title2" => "Form Penyusutan",
                  "penyesuaian" => $request->input('penyesuaian'),
                  "barangs" => $this->penyusutanService->getDetail($id, $penyesuaian['id_transaksi_penyesuaian'], $penyesuaian['tipe']),
                  "step" => 'dua',
                  'mainRoute' => $this->mainRoute
            ];
            return view('content.penyusutan.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function storeDua(Request $request)
      {
            $validator = $this->penyusutanService->validasiStepDua($request);
            if ($validator->fails()) {
                  alert()->error('Error', 'Anda belum memasukkan tanggal transaksi!');
                  return redirect()->route($this->mainRoute . '.step-dua', [
                        'id_inventaris' => json_encode($request->input('id_inventaris')),
                        'penyesuaian' => $request->input('penyesuaian')
                  ]);
            } else {
                  $data = $this->penyusutanService->getDataStoreDua($request);
                  $data['mainRoute'] = $this->mainRoute;
                  return view('content.penyusutan.create', $data);
            }
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function stepTiga(Request $request)
      {

            $dataprev = $this->penyusutanService->getKonvertDataPrev($request->input('data'));
            $data = $this->penyusutanService->getDataStepTiga($dataprev);
            $data['mainRoute'] = $this->mainRoute;
            return view('content.penyusutan.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function storeTiga(Request $request)
      {
            $dataprev = $this->penyusutanService->getKonvertDataPrev($request->input('data_prev'));
            $detailTransaksi = $this->penyusutanService->getDetailTransaksi($dataprev['detailPenyusutan']);
            $penyesuaian = $dataprev['requestPenyesuaian'];

            if ($detailTransaksi == null) {
                  alert()->warning('Warning', 'Inventaris yang dipilih belum bisa disusutkan!');
                  return redirect()->route($this->mainRoute . '.step-satu');
            } else {
                  $data = $this->penyusutanService->getDataStoreTiga($request, $detailTransaksi, $penyesuaian);
                  $data['mainRoute'] = $this->mainRoute;
                  $data['routePny'] = $this->mainRoute . '.detail';
                  return view('content.penyusutan.create', $data);
            }
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function storeEmpat(Request $request)
      {
            $details = json_decode($request->input('detail'), true);
            $jurnal = json_decode($request->input('jurnal'), true);
            $jurnalpny = json_decode($request->input('jurnalpny'), true);

            $nomor = $this->penyusutanService->getInvoice($this->unit);
            $penyesuaian = $this->penyusutanService->getDataPenyesuaian($request);
            /*buat transaksi baru*/
            $this->penyusutanService->createTransaksi($nomor, $details, $request->input('tgl_transaksi'), $penyesuaian, $this->unit);

            /*ambil id_transaksi tabel transaksi*/
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($nomor);
            /*buat detail transaksi*/
            $this->penyusutanService->createDetailTransaksi($details, $id_transaksi);

            /*buat jurnal*/
            $this->penyusutanService->createJurnal($jurnal, $jurnalpny, $id_transaksi, $penyesuaian['id_transaksi_penyesuaian'], $penyesuaian['tipe']);
            alert()->success('Sukses', "Berhasil menambahkan Penyusutan Inventaris.");
            return redirect()->route($this->mainRoute);
      }

      public function getDetailPenyesuaian(Request $request)
      {
            $id_pembayaran = $request->input('transaksi_id');
            $details = Detail_penyusutan::with(['barang', 'barang_eceran', 'satuan', 'transaksi'])->where('id_transaksi', $id_pembayaran)->get();
            if (!$details) {
                  return response()->json(['error' => 'Detail penyusutan inventaris tidak ditemukan'], 404);
            }
            $transaksi = Transaksi::where('id_transaksi', $id_pembayaran)->first();
            $jurnals = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $id_pembayaran)->get();
            return response()->json(compact('details', 'jurnals', 'transaksi'));
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show($id)
      {
            $id = Crypt::decrypt($id);
            $data = $this->getDataShow($id);
            return view('content.penyusutan.show', $data);
      }

      public function getDataShow($id)
      {
            $detailPenyusutan = Detail_penyusutan::with(['transaksi', 'barang', 'barang_eceran', 'satuan'])->where('id_transaksi', $id)->get();
            $transaksi = Transaksi::where('id_transaksi', $id)->first();
            $jurnals = Jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id)->get();
            return [
                  'title' => 'Penyusutan Inventaris',
                  'tipe' => $this->penyusutanService->getTitleTipe($transaksi->tipe),
                  'idPenyusutan' => $id,
                  'unit' => $this->unit,
                  'invoice' => $transaksi->kode,
                  'no_bukti' => $transaksi->no_bukti,
                  'invoice_penyesuaian' => $transaksi->kode_pny,
                  'tglTransaksi' => $transaksi->tgl_transaksi,
                  'jenisTransaksi' => $transaksi->jenis_transaksi,
                  'detailPenyusutan' => $detailPenyusutan,
                  'totalTransaksi' => $detailPenyusutan->sum('subtotal'),
                  'deskripsi' => $transaksi->keterangan,
                  'total' => $transaksi->total,
                  'jurnals' => $jurnals,
                  'mainRoute' => $this->mainRoute
            ];
      }
}
