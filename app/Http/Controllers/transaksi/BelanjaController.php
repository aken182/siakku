<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Satuan;
use App\Models\Penyedia;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Services\BelanjaService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BelanjaRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Services\dataTable\DataTableMainTransaksiService;

class BelanjaController extends Controller
{

      protected $transaksiService;
      protected $belanjaService;
      protected $dataTableService;
      protected $coaService;
      private $unit;
      private $route;
      private $mainRoute;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->belanjaService = new BelanjaService;
            $this->dataTableService = new DataTableMainTransaksiService;
            $this->coaService = new CoaService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->belanjaService->getUnitBelanja($this->route);
            $this->mainRoute = $this->belanjaService->getMainRouteBelanja($this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $data = [
                  'title' => 'Belanja',
                  'unit' => $this->unit,
                  'routeList' => $this->mainRoute . '.list',
                  'routeCreate' => route($this->mainRoute . '.create'),
                  'createTitle' => 'Tambah Belanja',
            ];
            // dd($data['routeList']);
            return view('content.belanja.main', $data);
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
      public function create()
      {
            $prefix = $this->unit === 'Pertokoan' ? 'BLNJ-TK-' : 'BLNJ-SP-';
            $data = [
                  'title' => 'Belanja',
                  'unit' => $this->unit,
                  'vendor' => Penyedia::all(),
                  'routeDetail' => $this->mainRoute . '.detail',
                  'routeStore' => $this->mainRoute . '.store',
                  'pnyBelanja' => $this->belanjaService->getPenyesuaianBelanja($this->unit),
                  'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
                  'dataAkunBelanja' => $this->coaService->getAkunBelanja(),
                  'coaBelanja' => $this->coaService->getAkunBelanjaOperasionalLainnya(),
                  'coaPenerimaHutang' => $this->coaService->getAkunPenerimaanHutang(),
                  'satuans' => Satuan::all(),
                  'route' => $this->mainRoute
            ];
            return view('content.belanja.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(BelanjaRequest $request)
      {
            /*Konvert rupiah ke angka*/
            $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
            /*Menentukan id dan invoice transaksi penyesuaian*/
            $id_penyesuaian = $request->input("id_belanja_penyesuaian") ?? null;
            $kodePny = $this->transaksiService->getKodePenyesuaian($request->input('cek_belanja'), $id_penyesuaian);
            /*upload file nota transaksi dan get image*/
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->input('nomor'),
                  'nota-belanja'
            );
            /*Buat transaksi*/
            $this->belanjaService->createTransaksi($request, $kodePny, $imageName, 'detail_belanja_operasional');
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
            /*create detail transaksi*/
            $this->belanjaService->createDetailTransaksi($request->all(), $id_transaksi);
            /*create jurnal*/
            $this->belanjaService->createJurnalBelanja($request->all(), $id_transaksi, $id_penyesuaian);
            alert()->success('Sukses', "Berhasil menambahkan transaksi belanja baru.");
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
            return view('content.belanja.show', $data);
      }

      public function detail(Request $request)
      {
            $id_transaksi = $request->input('transaksi_id');
            $detail = $this->belanjaService->getDetailBelanja($id_transaksi);
            $details = $detail['details'];
            $jurnals = $detail['jurnals'];
            $transaksi = $detail['transaksi'];
            return response()->json(compact('details', 'jurnals', 'transaksi'));
      }
}
