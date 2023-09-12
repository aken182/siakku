<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\PenjualanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PenjualanRequest;
use App\Services\dataTable\DataTablePenjualanService;

class PenjualanController extends Controller
{
    protected $transaksiService;
    protected $penjualanService;
    protected $dataTableService;
    private $route;
    private $unit;

    public function __construct()
    {
        $this->transaksiService = new TransaksiService;
        $this->penjualanService = new PenjualanService;
        $this->dataTableService = new DataTablePenjualanService;
        $this->route = Route::currentRouteName();
        $this->unit = 'Pertokoan';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'unit' => $this->unit,
            'routeCreate' => route('ptk-penjualan.create-barang'),
            'routeList' => 'ptk-penjualan.list',
            'routeCreate2' => route('ptk-penjualan.create-lainnya'),
            'createTitle' => 'Tambah Penjualan',
            'createTitle2' => 'Tambah Penjualan Lainnya',
            'title' => 'Penjualan',
        ];

        return view('content.penjualan.main', $data);
    }

    /**
     * Mengambil datatable barang berdasarkan
     * request ajax
     *
     * @param \Illuminate\Http\Request $request
     **/
    public function dataTablePenjualan(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
            $dataTables = $this->dataTableService->getDataTablePenjualan($data, 'ptk-penjualan.show', $this->unit);
            return $dataTables;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBarang()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLainnya()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenjualanRequest $request)
    {
        //
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
}
