<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Models\Satuan;
use App\Models\Transaksi;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Models\Detail_pendapatan;
use App\Services\TransaksiService;
use App\Services\PendapatanService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PendapatanRequest;
use App\Services\dataTable\DataTableTransaksiService;

class PendapatanController extends Controller
{
    protected $transaksiService;
    protected $pendapatanService;
    protected $dataTableService;
    protected $coaService;
    private $route;
    private $unit;
    private $mainRoute;

    public function __construct()
    {
        $this->transaksiService = new TransaksiService;
        $this->pendapatanService = new PendapatanService;
        $this->dataTableService = new DataTableTransaksiService;
        $this->coaService = new CoaService;
        $this->route = Route::currentRouteName();
        $this->unit = $this->pendapatanService->getUnit($this->route);
        $this->mainRoute = $this->pendapatanService->getMainRoute($this->unit);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => $this->unit === 'Pertokoan' ? 'Pendapatan Lainnya' : 'Pendapatan',
            'unit' => $this->unit,
            'routeList' => $this->mainRoute . '.list',
            'routeCreate' => route($this->mainRoute . '.create'),
            'createTitle' => 'Tambah Pendapatan',
        ];
        return view('content.pendapatan.main', $data);
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
            $route = $this->pendapatanService->getRouteToTable($this->route);
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
        $prefix = $this->unit === 'Pertokoan' ? 'PNDP-TK-' : 'PDNP-SP-';
        $data = [
            'title' => $this->unit === 'Pertokoan' ? 'Pendapatan Lainnya' : 'Pendapatan',
            'unit' => $this->unit,
            'routeDetail' => $this->mainRoute . '.detail',
            'routeStore' => $this->mainRoute . '.store',
            'pnyPendapatan' => $this->pendapatanService->getPenyesuaianPendapatan($this->unit),
            'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
            'dataKasBank' => $this->coaService->getKasBank(),
            'coa' => $this->coaService->getAkunPendapatan(),
            'satuans' => Satuan::all(),
            'route' => $this->mainRoute
        ];
        return view('content.pendapatan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PendapatanRequest $request)
    {
        /*Konvert rupiah ke angka*/
        $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
        /*Menentukan id dan invoice transaksi penyesuaian*/
        $detailPenyesuaian = $this->pendapatanService->getDetailPenyesuaian($request);
        $idTransPeny = $detailPenyesuaian['idTransPeny'];
        $invoicepny = $detailPenyesuaian['invoicepny'];
        /*upload file nota transaksi dan get image*/
        $imageName = $this->transaksiService->addNotaTransaksi(
            $request->file('nota_transaksi'),
            $request->input('nomor'),
            'nota-pendapatan'
        );
        /*Buat transaksi*/
        $this->pendapatanService->createTransaksi($request, $invoicepny, $imageName, 'detail_pendapatan');
        $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
        $this->pendapatanService->createDetailTransaksi($request->all(), $id_transaksi);
        /*Buat jurnal*/
        $this->pendapatanService->createJurnal($request->all(), $id_transaksi, $idTransPeny);
        alert()->success('Sukses', "Berhasil menambahkan pendapatan baru.");
        return redirect()->route($this->mainRoute);
    }

    /**
     * Menampilkan detail transaksi.
     *
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        $data = $this->getDataShow($id, $transaksi);
        return view('content.pendapatan.show', $data);
    }

    /**
     * Mengambil data detail transaksi
     *
     **/
    public function getDataShow($id, $transaksi)
    {
        $data = [
            'title' => "Pendapatan",
            'unit' => $transaksi->unit,
            'id_transaksi' => $transaksi->id_transaksi,
            'invoice' => $transaksi->kode,
            'no_bukti' => $transaksi->no_bukti,
            'invoicePny' => $transaksi->kode_pny,
            'tanggal' => $transaksi->tgl_transaksi,
            'metode' => $transaksi->metode_transaksi,
            'jenis_transaksi' => $transaksi->jenis_transaksi,
            'total' => $transaksi->total,
            'nota' => $transaksi->nota_transaksi,
            'tipe' => $transaksi->tipe,
            'keterangan' => $transaksi->keterangan,
            'transaksis' => Detail_pendapatan::with('satuan', 'transaksi')->where('id_transaksi', $id)->get(),
            'routeMain' => $this->mainRoute
        ];
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $id_pembayaran = $request->input('transaksi_id');
        $details = Detail_pendapatan::with(['satuan', 'transaksi'])->where('id_transaksi', $id_pembayaran)->get();
        if (!$details) {
            return response()->json(['error' => 'Detail pendapatan tidak ditemukan'], 404);
        }
        $transaksi = Transaksi::where('id_transaksi', $id_pembayaran)->first();
        $jurnals = Jurnal::with(['transaksi', 'coa'])
            ->where('id_transaksi', $id_pembayaran)->get();
        return response()->json(compact('details', 'jurnals', 'transaksi'));
    }
}
