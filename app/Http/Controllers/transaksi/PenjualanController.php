<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Models\Satuan;
use App\Models\Transaksi;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Models\Main_penjualan;
use App\Services\ImageService;
use App\Services\AnggotaService;
use App\Services\PelunasanService;
use App\Services\PenjualanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PenjualanRequest;
use App\Http\Requests\PenjualanBarangRequest;
use App\Services\dataTable\DataTableMainTransaksiService;
use App\Services\PendapatanService;

class PenjualanController extends Controller
{
    protected $transaksiService;
    protected $penjualanService;
    protected $pendapatanService;
    protected $pelunasanService;
    protected $dataTableService;
    protected $coaService;
    protected $anggotaService;
    private $route;
    private $unit;
    private $mainRoute;

    public function __construct()
    {
        $this->transaksiService = new TransaksiService;
        $this->penjualanService = new PenjualanService;
        $this->pendapatanService = new PendapatanService;
        $this->pelunasanService = new PelunasanService;
        $this->dataTableService = new DataTableMainTransaksiService;
        $this->anggotaService = new AnggotaService(new ImageService);
        $this->coaService = new CoaService;
        $this->route = Route::currentRouteName();
        $this->unit = 'Pertokoan';
        $this->mainRoute = 'ptk-penjualan';
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
            'createLrtk' => route('ptk-penjualan.create-barang-lrtk'),
            'createWrg' => route('ptk-penjualan.create-barang-wrg'),
            'createPsr' => route('ptk-penjualan.create-barang-psr'),
            'routeList' => 'ptk-penjualan.list',
            'createLrtk2' => route('ptk-penjualan.create-lainnya-lrtk'),
            'createWrg2' => route('ptk-penjualan.create-lainnya-wrg'),
            'createPsr2' => route('ptk-penjualan.create-lainnya-psr'),
            'title' => 'Penjualan',
        ];

        return view('content.penjualan.main', $data);
    }

    /**
     * Mengambil datatable barang berdasarkan
     * request ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|void
     **/
    public function dataTablePenjualan(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
            $routeToTable = [
                'show' => 'ptk-penjualan.show',
                'create' => 'ptk-penjualan.create-pelunasan',
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
    public function createBarang()
    {
        $tpk = $this->penjualanService->getTpk($this->route);
        $data = [
            'title' => 'Penjualan Barang',
            'tpk' => $tpk,
            'unit' => $this->unit,
            'pegawai' => $this->anggotaService->getDataAnggotaToForm(),
            'pnypenjualan' => $this->penjualanService->getPenyesuaianPenjualanBarang($this->unit),
            'nomor' => $this->transaksiService->getNomorTransaksi('PNJ-TK-'),
            'dataKasBank' => $this->coaService->getKasBank(),
            'barangGrosir' => $this->penjualanService->getBarang($this->unit, $tpk),
            'barangEceran' => $this->penjualanService->getBarangEceran($this->unit, $tpk),
            'coa' => $this->coaService->getAkunPenjualanBarang(),
            'satuans' => Satuan::all(),
            'route' => $this->mainRoute
        ];
        return view('content.penjualan.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLainnya()
    {
        $tpk = $this->penjualanService->getTpk($this->route);
        $data = [
            'title' => 'Penjualan Lainnya',
            'tpk' => $tpk,
            'unit' => $this->unit,
            'pegawai' => $this->anggotaService->getDataAnggotaToForm(),
            'pnypenjualan' => $this->penjualanService->getPenyesuaianPenjualanLainnya($this->unit),
            'nomor' => $this->transaksiService->getNomorTransaksi('PNJ-TK-'),
            'dataKasBank' => $this->coaService->getKasBank(),
            'coa' => $this->coaService->getAkunPendapatan(),
            'satuans' => Satuan::all(),
            'route' => $this->mainRoute
        ];
        return view('content.penjualan.create-lainnya', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenjualanBarangRequest $request)
    {
        /*Konvert rupiah ke angka*/
        $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
        /*Menentukan id dan invoice transaksi penyesuaian*/
        $id_penyesuaian = $request->input("id_penjualan_penyesuaian") ?? null;
        $kodePenyesuaian = $this->transaksiService->getKodePenyesuaian($request->input('cek_penjualan'), $id_penyesuaian);
        /*Update barang sebelum transaksi kadaluwarsa*/
        if ($request->input('cek_penjualan') === 'penyesuaian') {
            /*validasi stok barang*/
            $stokTakCukup = $this->penjualanService->validasiStokBarang($request->input('data_barang'), $id_penyesuaian);
            if ($stokTakCukup > 0) {
                alert()->error('Error', "Terdapat $stokTakCukup barang yang stoknya tidak cukup !");
                return redirect()->back()->withInput();
            }
            $this->penjualanService->updateBarangJualKadaluwarsa($id_penyesuaian);
        }
        /*upload file nota transaksi dan get image*/
        $imageName = $this->transaksiService->addNotaTransaksi(
            $request->file('nota_transaksi'),
            $request->input('nomor'),
            'nota-penjualan'
        );
        /*Buat transaksi*/
        $this->pendapatanService->createTransaksi($request, $kodePenyesuaian, $imageName, 'detail_penjualan');
        $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
        $this->penjualanService->createDetailTransaksi($request->all(), $id_transaksi);
        /*Buat jurnal*/
        $this->penjualanService->createJurnalBarang($request->all(), $id_transaksi, $id_penyesuaian);
        alert()->success('Sukses', "Berhasil menambahkan penjualan baru.");
        return redirect()->route($this->mainRoute);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLainnya(PenjualanRequest $request)
    {
        /*Konvert rupiah ke angka*/
        $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
        /*Menentukan id dan invoice transaksi penyesuaian*/
        $idTransPeny = $request->input("id_penjualan_penyesuaian") ?? null;
        $invoicepny = $this->transaksiService->getKodePenyesuaian($request->input('cek_penjualan'), $idTransPeny);
        /*upload file nota transaksi dan get image*/
        $imageName = $this->transaksiService->addNotaTransaksi(
            $request->file('nota_transaksi'),
            $request->input('nomor'),
            'nota-penjualan'
        );
        /*Buat transaksi*/
        $this->pendapatanService->createTransaksi($request, $invoicepny, $imageName, 'detail_penjualan_lain');
        $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
        $this->penjualanService->createDetailTransaksi($request->all(), $id_transaksi);
        /*Buat jurnal*/
        $this->pendapatanService->createJurnal($request->all(), $id_transaksi, $idTransPeny);
        alert()->success('Sukses', "Berhasil menambahkan penjualan baru.");
        return redirect()->route($this->mainRoute);
    }


    /**
     * Mengambil detail transaksi penjualan 
     * yang akan disesuaikan
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     **/
    public function detail(Request $request)
    {
        $id_pembayaran = $request->input('transaksi_id');
        $jenis = Transaksi::where('id_transaksi', $id_pembayaran)->value('jenis_transaksi');
        if ($jenis == 'Penjualan Barang') {
            $details = $this->penjualanService->getDetailPenjualanBarang($id_pembayaran);
        } else {
            $details = $this->penjualanService->getDetailPenjualanLainnya($id_pembayaran);
        }
        if (!$details) {
            return response()->json(['error' => 'Detail penjualan tidak ditemukan'], 404);
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
    public function show(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        if ($request->input('detail') === 'Penjualan Barang') {
            $penjualan = $this->penjualanService->getDetailPenjualanBarang($id);
        } else {
            $penjualan = $this->penjualanService->getDetailPenjualanLainnya($id);
        }
        $data = $this->getDataShow($id, $penjualan);
        return view('content.penjualan.show', $data);
    }

    public function getDataShow($id, $penjualan)
    {
        $transaksi = Main_penjualan::with('transaksi')->where('id_transaksi', $id)->first();
        return [
            'title' => $transaksi->transaksi->jenis_transaksi,
            'unit' => $transaksi->transaksi->unit,
            'id_transaksi' => $transaksi->id_transaksi,
            'invoice' => $transaksi->transaksi->kode,
            'no_bukti' => $transaksi->transaksi->no_bukti,
            'tanggal' => $transaksi->transaksi->tgl_transaksi,
            'metode' => $transaksi->transaksi->metode_transaksi,
            'total' => $transaksi->transaksi->total,
            'nota' => $transaksi->transaksi->nota_transaksi,
            'tipe' => $transaksi->transaksi->tipe,
            'status' => $transaksi->status_penjualan,
            'saldo_piutang' => $transaksi->saldo_piutang,
            'invoicePny' => $transaksi->transaksi->kode_pny,
            'keterangan' => $transaksi->transaksi->keterangan,
            'jenis' => $transaksi->jenis_penjualan,
            'routeMain' => $this->mainRoute,
            'pembayaran' => $this->pelunasanService->getInvoicePembayaran($transaksi->id_penjualan, 'main_penjualan'),
            'totalPembayaran' => $this->pelunasanService->getTotalPembayaran($transaksi->id_penjualan, 'main_penjualan'),
            'transaksis' => $penjualan
        ];
    }
}
