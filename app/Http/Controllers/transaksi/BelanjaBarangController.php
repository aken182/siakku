<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Satuan;
use App\Models\Penyedia;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Services\BarangService;
use App\Services\BelanjaService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\BelanjaBarangRequest;
use App\Services\dataTable\DataTableMainTransaksiService;

class BelanjaBarangController extends Controller
{
      protected $transaksiService;
      protected $belanjaService;
      protected $barangService;
      protected $dataTableService;
      protected $coaService;
      private $unit;
      private $route;
      private $mainRoute;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->belanjaService = new BelanjaService;
            $this->barangService = new BarangService;
            $this->dataTableService = new DataTableMainTransaksiService;
            $this->coaService = new CoaService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->belanjaService->getUnit($this->route);
            $this->mainRoute = $this->belanjaService->getMainRoute($this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $data = [
                  'title' => 'Pengadaan Barang',
                  'unit' => $this->unit,
                  'routeList' => $this->mainRoute . '.list',
                  'dataButtonGroupPersediaan' => $this->belanjaService->getDataButtonGroupPersediaan($this->mainRoute),
                  'dataButtonGroupInventaris' => $this->belanjaService->getDataButtonGroupInventaris($this->mainRoute),
                  'createTitle' => 'Tambah Pengadaan',
            ];
            // dd($data['dataButtonGroup']);

            return view('content.belanja-barang.main', $data);
      }

      /**
       * Show the list for data table a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function dataTable(Request $request)
      {
            if ($request->ajax()) {
                  $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
                  $routeToTable = [
                        'show' => $this->belanjaService->getRouteShowToTable($this->route),
                        'create' => $this->mainRoute . '.create-pelunasan',
                        'main' => $this->mainRoute
                  ];
                  $dataTables = $this->dataTableService->getDataTableMain($data, $routeToTable, $this->unit);
                  return $dataTables;
            }
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create(Request $request)
      {
            $tpk = $this->belanjaService->getTpk($this->route);
            $prefix = $this->unit === 'Pertokoan' ? 'BNJB-TK-' : 'BNJB-SP-';
            $data = [
                  'title' => 'Pengadaan Barang',
                  'tpk' => $tpk,
                  'unit' => $this->unit,
                  'vendor' => Penyedia::all(),
                  'jenis' => $request->input('jenis'),
                  'pnyBelanja' => $this->belanjaService->getPenyesuaianBelanjaBarang($this->unit, $request->input('jenis')),
                  'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
                  'dataAkunBelanja' => $this->coaService->getAkunBelanja(),
                  'barang' => $this->barangService->getDataBarang($this->unit, $request->input('jenis'), $tpk),
                  'coa' => $this->coaService->getAkunBelanjaBarang(),
                  'satuan' => Satuan::all(),
                  'units' => $this->barangService->getDataUnit($this->unit, $tpk),
                  'route' => $this->mainRoute,
                  'routeDetail' => $this->mainRoute . '.detail',
                  'storeRoute' => $this->mainRoute . '.store'
            ];
            return view('content.belanja-barang.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(BelanjaBarangRequest $request)
      {
            /*Konvert rupiah ke angka*/
            $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
            /*Menentukan id dan invoice transaksi penyesuaian*/
            $id_penyesuaian = $request->input("id_belanja_penyesuaian") ?? null;
            $kodePny = $this->transaksiService->getKodePenyesuaian($request->input('cek_belanja'), $id_penyesuaian);
            /*update barang sebelum transaksi kadaluwarsa*/
            if ($request->input('cek_belanja') === 'penyesuaian') {
                  $this->belanjaService->updateBarangKadaluwarsa($id_penyesuaian);
            }
            /*upload file nota transaksi dan get image*/
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->input('nomor'),
                  'nota-belanja'
            );
            /*Buat transaksi*/
            $this->belanjaService->createTransaksi($request, $kodePny, $imageName, 'detail_belanja_' . $request->input('jenis'));
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
            /*create detail transaksi*/
            $this->belanjaService->createDetailTransaksi($request->all(), $id_transaksi);
            /*create jurnal*/
            $this->belanjaService->createJurnalPengadaanBarang($request->all(), $id_transaksi, $id_penyesuaian);
            alert()->success('Sukses', "Berhasil menambahkan pengadaan " . $request->input('jenis') . " baru.");
            return redirect()->route($this->mainRoute);
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
            $data = $this->belanjaService->getDataShow($id, $this->mainRoute);
            return view('content.belanja-barang.show', $data);
      }

      /**
       * Mengambil detail transaksi dengan id transaksi
       * tertentu berdasarkan request untuk digunakan 
       * sebagai penyesuaian dalam form transaksi.
       *
       */
      public function detail(Request $request)
      {
            $id_transaksi = $request->input('transaksi_id');
            $detail = $this->belanjaService->getDetailBelanja($id_transaksi);
            $details = $detail['details'];
            $jurnals = $detail['jurnals'];
            $transaksi = $detail['transaksi'];
            if (!$details) {
                  return response()->json(['error' => 'Detail belanja tidak ditemukan'], 404);
            }
            return response()->json(compact('details', 'jurnals', 'transaksi'));
      }
}
