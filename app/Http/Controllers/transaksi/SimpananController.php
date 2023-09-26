<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Models\Simpanan;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Models\Main_simpanan;
use App\Services\ImageService;
use App\Models\Detail_simpanan;
use App\Services\AnggotaService;
use App\Services\SimpananService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\SimpananRequest;
use App\Services\dataTable\DataTableTransaksiService;
use App\Services\PenarikanService;

class SimpananController extends Controller
{
    protected $transaksiService;
    protected $simpananService;
    protected $penarikanService;
    protected $dataTableService;
    protected $anggotaService;
    protected $coaService;
    private $route;
    private $mainRoute;
    private $unit;

    public function __construct()
    {
        $this->transaksiService = new TransaksiService;
        $this->simpananService = new SimpananService;
        $this->penarikanService = new PenarikanService;
        $this->dataTableService = new DataTableTransaksiService;
        $this->anggotaService = new AnggotaService(new ImageService);
        $this->coaService = new CoaService;
        $this->route = Route::currentRouteName();
        $this->unit = $this->simpananService->getUnit($this->route);
        $this->mainRoute = $this->simpananService->getRouteMain($this->unit);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Simpanan',
            'unit' => $this->unit,
            'routeList' => $this->mainRoute . '.list',
            'routeCreate' => route($this->mainRoute . '.create'),
            'createTitle' => 'Tambah Simpanan',
            'routeCreateSukarela' => $this->mainRoute . '.create-srb',
            'titleSukarela' => 'Tambah Simpanan Sukarela Berbunga',
        ];

        return view('content.simpanan.transaksi-simpanan.main', $data);
    }

    /**
     * Merender data transaksi simpanan ke dalam
     * bentuk dataTable
     *
     **/
    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
            $route = $this->simpananService->getRouteToTable($this->route);
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
        $jenis = $this->simpananService->getJenisSimpanan($this->route);
        $prefix = $this->simpananService->getPrefixSimpanan($jenis, $this->unit);
        $data = [
            'title' => 'Simpanan',
            'unit' => $this->unit,
            'routeMain' => $this->mainRoute,
            'routeDetail' => $this->mainRoute . '.detail',
            'anggota' => $this->anggotaService->getDataAnggotaToForm(),
            'masterSimpanan' => Simpanan::all(),
            'jenis' => $jenis,
            'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
            'dataKasBank' => $this->coaService->getKasBank(),
            'pnySimpanan' => $this->simpananService->getPenyesuaian($this->unit, $jenis),
            'routeStore' => route($this->mainRoute . '.store'),
        ];

        if ($jenis === 'umum') {
            return view('content.simpanan.transaksi-simpanan.create', $data);
        } else {
            return view('content.simpanan.transaksi-simpanan.create-sukarela-berbunga', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SimpananRequest $request)
    {
        /*Konvert rupiah ke angka*/
        $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
        /*Menentukan id dan invoice transaksi penyesuaian*/
        $idTransPeny = $request->input("id_penyesuaian") ?? null;
        $invoicepny = $this->transaksiService->getKodePenyesuaian($request->input('cek_simpanan'), $idTransPeny);
        /*upload file nota transaksi dan get image*/
        $imageName = $this->transaksiService->addNotaTransaksi(
            $request->file('nota_transaksi'),
            $request->input('nomor'),
            'nota-simpanan'
        );
        /*Buat transaksi*/
        $this->simpananService->createTransaksi($request->all(), $invoicepny, $imageName);
        $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
        $this->simpananService->createDetailTransaksi($request->all(), $id_transaksi);
        /*Buat jurnal*/
        $this->simpananService->createJurnal($request->all(), $id_transaksi, $idTransPeny);
        alert()->success('Sukses', "Berhasil menambahkan simpanan baru.");
        return redirect()->route($this->mainRoute);
    }

    public function detail(Request $request)
    {
        $id_transaksi = $request->input('transaksi_id');
        $id_main = Main_simpanan::where('id_transaksi', $id_transaksi)->value('id_main');
        $transaksi = Main_simpanan::with(['anggota', 'transaksi'])
            ->where('id_main', $id_main)->first();
        $details = Detail_simpanan::with(['main_simpanan', 'simpanan'])->where('id_main', $id_main)->get();
        $jurnals = Jurnal::with(['transaksi', 'coa'])
            ->where('id_transaksi', $id_transaksi)->get();
        return response()->json(compact('details', 'jurnals', 'transaksi'));
    }

    /**
     * Mengambil data simpanan sukarela berbunga
     *
     **/
    public function getDataSrb(Request $request)
    {
        $idAnggota = $request->input('id_anggota');
        $persenBunga = $request->input('persen_bunga');
        $jumlahSimpanan = convertToNumber($request->input('jumlah_simpanan'));
        $id_penyesuaian = $request->input('id_penyesuaian') ?? null;
        $totalPny = $this->simpananService->getTotalPnySbr($id_penyesuaian, $idAnggota);
        $penerimaan = $this->simpananService->getTotalSimpananAnggota($idAnggota, 'Simpanan Sukarela Berbunga', $this->unit);
        $penarikan = $this->penarikanService->getTotalPenarikanAnggota($idAnggota, 'Simpanan Sukarela Berbunga', $this->unit, 'sukarela berbunga');
        $total = $penerimaan - $penarikan;
        $totalSimpanan = ($jumlahSimpanan + $total) - $totalPny;
        $bunga = $totalSimpanan * ($persenBunga / 100);
        return response()->json(compact('bunga', 'totalSimpanan'));
    }

    /**
     * Menampilkan detail transaksi.
     *
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $id_main = Main_simpanan::where('id_transaksi', $id)->value('id_main');
        $transaksi = Main_simpanan::where('id_main', $id_main)->first();
        $data = $this->getDataShow($transaksi);
        return view('content.simpanan.transaksi-simpanan.show', $data);
    }

    /**
     * Mengambil data detail transaksi
     *
     **/
    public function getDataShow($main)
    {
        $data = [
            'title' => "Simpanan",
            'unit' => $main->transaksi->unit,
            'nama' => $main->anggota->nama,
            'alamat' => $main->anggota->tempat_tugas,
            'id_transaksi' => $main->id_transaksi,
            'invoice' => $main->transaksi->kode,
            'no_bukti' => $main->transaksi->no_bukti,
            'invoicePny' => $main->transaksi->kode_pny,
            'tanggal' => $main->transaksi->tgl_transaksi,
            'metode' => $main->transaksi->metode_transaksi,
            'jenis_transaksi' => $main->transaksi->jenis_transaksi,
            'jenis' => $main->jenis_simpanan,
            'total' => $main->transaksi->total,
            'nota' => $main->transaksi->nota_transaksi,
            'tipe' => $main->transaksi->tipe,
            'keterangan' => $main->transaksi->keterangan,
            'transaksis' => Detail_simpanan::with('simpanan', 'main_simpanan', 'main_simpanan.transaksi')->where('id_main', $main->id_main)->get(),
            'routeMain' => $this->mainRoute
        ];
        return $data;
    }
}
