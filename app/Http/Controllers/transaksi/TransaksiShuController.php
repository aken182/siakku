<?php

namespace App\Http\Controllers\transaksi;

use App\Services\ShuService;
use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\TransaksiShuRequest;
use App\Models\Jurnal;
use App\Models\Transaksi;
use App\Services\dataTable\DataTableTransaksiService;
use Illuminate\Support\Facades\Crypt;

class TransaksiShuController extends Controller
{
      protected $transaksiService;
      protected $shuService;
      protected $dataTableService;
      private $route;
      private $unit;
      private $mainRoute;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->dataTableService = new DataTableTransaksiService;
            $this->shuService = new ShuService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->shuService->getUnit($this->route);
            $this->mainRoute = $this->shuService->getMainRouteTransaksi($this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $index = $this->shuService->getDataIndex();
            $data = [
                  'title' => 'Sisa Hasil Usaha',
                  'unit' => $this->unit,
                  'tipe' => $index['tipe'],
                  'routeMaster' => $index['routeMaster'],
                  'routeTransaksi' => $index['routeTransaksi'],
                  'routeList' => $index['routeList'],
                  'routeCreate' => $index['routeCreate'],
                  'routeGrafik' => $this->mainRoute . '-chart',
                  'modal' => 'Lihat Estimasi SHU',
                  'estimasi' => $this->shuService->getEstimasi($this->unit),
                  'createTitle' => 'Transaksi Pembagian SHU',
            ];
            return view('content.shu.main', $data);
      }

      /**
       * Show the form for list a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function list(Request $request)
      {
            if ($request->ajax()) {
                  $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
                  $route = $this->shuService->getRouteToTable($this->route);
                  $dataTables = $this->dataTableService->getDataTable($data, $route);
                  return $dataTables;
            }
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function chart(Request $request)
      {
            $estimasiShu = $this->shuService->getEstimasi($this->unit);
            $estimasi = $estimasiShu['dana'];
            return response()->json(compact('estimasi'));
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function getJurnalTransaksi(Request $request)
      {
            $id = $request->input('id_penyesuaian') ?? null;
            $tahun = $request->input('tahun');
            $data = $this->shuService->getJurnalToCreate($this->unit, $tahun, $id);
            $jenis = $id !== null ? 'penyesuaian' : '';
            $jurnals = $data['jurnal'];
            $total = $data['total'];
            return response()->json(compact('jurnals', 'total', 'jenis'));
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
            $prefix = $this->unit === 'Pertokoan' ? 'TSHU-TK-' : 'TSHU-SP-';
            $data = [
                  'title' => 'Pembagian SHU',
                  'routeStore' => $this->mainRoute . '-store',
                  'routeGrafik' => $this->mainRoute . '-chart',
                  'routeJurnal' => $this->mainRoute . '-jurnal',
                  'routeDetailPenyesuaian' => $this->mainRoute . '-detail',
                  'routeMain' => $this->mainRoute,
                  'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
                  'penyesuaian' => $this->shuService->getTransaksiPenyesuaian($this->unit),
                  'unit' => $this->unit,
            ];
            return view('content.shu.transaksi.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(TransaksiShuRequest $request)
      {
            // dd($request->all());
            if ($request->input("total_transaksi")) {
                  $request['total_transaksi'] = convertToNumber($request->input("total_transaksi"));
            }
            $request['total_transaksi'] = $request['total_transaksi'] ?? $this->shuService->getTotalTransaksi($request->input('tahun_shu'), $this->unit);
            $id_penyesuaian = $request->input("id_penyesuaian") ?? null;
            $kodePenyesuaian = $this->transaksiService->getKodePenyesuaian($request->input('cek_penyesuaian'), $id_penyesuaian);
            /*Buat transaksi */
            $this->shuService->createTransaksi($request->all(), $kodePenyesuaian, $this->unit);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
            $this->shuService->createDetailTransaksi($id_transaksi, $request->all(), $this->unit);
            $this->shuService->createJurnal($id_transaksi, $request->all(), $id_penyesuaian, $this->unit);
            alert()->success('Sukses', "Berhasil menambahkan transaksi pemindahan saldo.");
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
            $id_transaksi = Crypt::decrypt($id);
            $detail = $this->getDetail($id_transaksi);
            $data = [
                  'title' => 'Pembagian SHU',
                  'unit' => $this->unit,
                  'mainRoute' => $this->mainRoute,
                  'details' => $detail['details'],
                  'jenis' => $detail['details']->tipe === 'penyesuaian' ? ' Penyesuaian' : '',
                  'jurnals' => $detail['jurnals'],
                  'id_transaksi' => $id_transaksi
            ];
            return view('content.shu.transaksi.show', $data);
      }

      private function getDetail($id_transaksi)
      {
            $data = [
                  'details' => Transaksi::where('id_transaksi', $id_transaksi)->first(),
                  'jurnals' => Jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id_transaksi)->get(),
            ];
            return $data;
      }

      public function detail(Request $request)
      {
            $id_transaksi = $request->input('transaksi_id');
            $detail = $this->getDetail($id_transaksi);
            $details = $detail['details'];
            $jurnals = $detail['jurnals'];
            return response()->json(compact('details', 'jurnals'));
      }
}
