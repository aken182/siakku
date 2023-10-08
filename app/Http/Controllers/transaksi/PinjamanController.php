<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Models\Main_pinjaman;
use App\Services\PinjamanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PinjamanRequest;
use App\Models\Detail_pelunasan_pinjaman;
use App\Services\dataTable\DataTableMainTransaksiService;

class PinjamanController extends Controller
{
    protected $transaksiService;
    protected $pinjamanService;
    protected $coaService;
    protected $dataTableService;
    private $route;
    private $unit;
    private $mainRoute;

    public function __construct()
    {
        $this->transaksiService = new TransaksiService;
        $this->pinjamanService = new PinjamanService;
        $this->coaService = new CoaService;
        $this->dataTableService = new DataTableMainTransaksiService;
        $this->route = Route::currentRouteName();
        $this->unit = 'Simpan Pinjam';
        $this->mainRoute = 'pp-pinjaman';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Pinjaman Anggota',
            'unit' => $this->unit,
            'routeList' => $this->mainRoute . '.list',
            'createBaru' => route($this->mainRoute . '.create-baru'),
            // 'createMasaLalu' => route($this->mainRoute . '.create-masa-lalu'),
            'createPinjamTindis' => route($this->mainRoute . '.create-pinjam-tindis'),
        ];

        return view('content.pinjaman.transaksi-pinjaman.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->transaksiService->getHistoryTransaction($this->route, $this->unit);
            $routeToTable = [
                'show' => $this->mainRoute . '.show',
                'create' => 'pp-angsuran.create',
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
        $data = [
            'title' => 'Pinjaman Anggota',
            'unit' => $this->unit,
            'jenis' => $this->pinjamanService->getJenisPinjaman($this->route),
            'routeStore' => $this->pinjamanService->getRouteStore($this->route),
            'routeMain' => $this->mainRoute,
            'routeDetail' => $this->mainRoute . '.detail-pengajuan',
            'routePinjaman' => $this->mainRoute . '.detail-pinjaman',
            'routePenyesuaian' => $this->mainRoute . '.detail',
            'pinjaman' => $this->pinjamanService->getDataPinjamanAnggota(),
            'pengajuan' => $this->pinjamanService->getDataPengajuan(),
            'dataKas' => $this->coaService->getCoaKas(),
            'dataBank' => $this->coaService->getCoaBank(),
            'nomor' => $this->transaksiService->getNomorTransaksi('PNJA-SP-'),
            'penyesuaian' => $this->pinjamanService->getPenyesuaian($this->unit),
            'pnyPinjamTindis' => $this->pinjamanService->getPnyPinjamanTindis($this->unit),
        ];

        return view('content.pinjaman.transaksi-pinjaman.create', $data);
    }

    /**
     * Mengambil data pengajuan pinjaman
     * berdasarkan id_pengajuan
     *
     **/
    public function getDataPengajuanAnggota(Request $request)
    {
        $id = $request->input('id_pengajuan');
        $detail = $this->pinjamanService->getPengajuan($id);
        return response()->json(compact('detail'));
    }

    /**
     * Mengambil data pinjaman berdasarkan 
     * id_pinjaman
     *
     **/
    public function getDataPinjamanAnggota(Request $request)
    {
        $id = $request->input('id_pinjaman');
        $id_penyesuaian = $request->input('id_penyesuaian') ?? null;
        $detail = Main_pinjaman::with(['transaksi', 'anggota'])->where('id_pinjaman', $id)->first();
        if ($id_penyesuaian) {
            $pny = Detail_pelunasan_pinjaman::where('id_transaksi', $id_penyesuaian)
                ->where('id_pinjaman', $id)->first();
            if ($pny) {
                $detail->saldo_pokok = $detail->saldo_pokok - $pny->besar_pinjaman;
            }
        }
        return response()->json(compact('detail'));
    }

    /**
     * Mengambil data pinjaman
     * berdasarkan id_penyesuaian
     *
     **/
    public function detail(Request $request)
    {
        $id = $request->input('id_penyesuaian');
        $jenis = $request->input('jenis');
        if ($jenis === 'pinjam tindis') {
            $pnj = $this->pinjamanService->getDetailPinjamanTindis($id);
        } else {
            $pnj = $this->pinjamanService->getDetailPinjamanAnggota($id);
        }
        $detail = [
            'kode' => $pnj->transaksi->kode,
            'no_bukti' => $pnj->transaksi->no_bukti,
            'nama' => $pnj->anggota->nama ?? $pnj->main_pinjaman->anggota->nama,
            'tempat_tugas' => $pnj->anggota->tempat_tugas ?? $pnj->main_pinjaman->anggota->tempat_tugas,
            'tgl_transaksi' => date('d/m/Y', strtotime($pnj->transaksi->tgl_transaksi)),
            'jumlah_pinjaman' => $pnj->total_pinjaman ?? $pnj->main_pinjaman->total_pinjaman,
            'pinjam_tindis' => $pnj->main_pinjaman->pinjam_tindis ?? 0,
            'saldo_pokok' => $pnj->saldo_pokok ?? $pnj->main_pinjaman->saldo_pokok,
            'saldo_bunga' => $pnj->saldo_bunga ?? $pnj->main_pinjaman->saldo_bunga,
            'status' => $pnj->status ?? $pnj->main_pinjaman->status,
            'keterangan' => $pnj->transaksi->keterangan
        ];

        // dd($detail);
        $jurnals = Jurnal::with(['transaksi', 'coa'])
            ->where('id_transaksi', $id)->get();
        return response()->json(compact('detail', 'jurnals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PinjamanRequest $request)
    {
        /*Konvert rupiah ke angka*/
        $jenis = $this->pinjamanService->getJenisPinjaman($this->route);
        $request["total_transaksi"] = $this->pinjamanService->getTotalTransaksi($request->all(), $jenis);
        /*Menentukan id dan invoice transaksi penyesuaian*/
        $idTransPeny = $request->input("id_penyesuaian") ?? null;
        $invoicepny = $this->transaksiService->getKodePenyesuaian($request->input('cek_penyesuaian'), $idTransPeny);
        /*upload file nota transaksi dan get image*/
        $imageName = $this->transaksiService->addNotaTransaksi(
            $request->file('nota_transaksi'),
            $request->input('nomor'),
            'nota-pinjaman'
        );
        /*Buat transaksi*/
        $this->pinjamanService->createTransaksi($request->all(), $invoicepny, $imageName, $jenis, $this->unit);
        $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
        $this->pinjamanService->createDetailTransaksi($request->all(), $id_transaksi, $jenis, $idTransPeny);
        /*Buat jurnal*/
        $this->pinjamanService->createJurnal($request->all(), $id_transaksi, $idTransPeny, $jenis);
        alert()->success('Sukses', "Berhasil menambahkan pendapatan baru.");
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
        $data = $this->getDataShow($id);
        return view('content.pinjaman.transaksi-pinjaman.show', $data);
    }

    /**
     * undocumented function summary
     *
     **/
    public function getDataShow($id)
    {
        $data = [
            'title' => 'Pinjaman Anggota',
            'unit' => $this->unit,
            'routeMain' => $this->mainRoute,
            'd' => $this->pinjamanService->getDetailPinjamanAnggota($id),
            'pembayaran' => $this->pinjamanService->getDataAngsuran($id),
            'pinjamtindis' => $this->pinjamanService->getDataPinjamanTindis($id),
            'jurnal' => Jurnal::with(['transaksi', 'coa'])
                ->where('id_transaksi', $id)->get(),
        ];
        return $data;
    }
}
