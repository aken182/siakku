<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Models\Simpanan;
use App\Models\Transaksi;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\Detail_penarikan;
use App\Services\AnggotaService;
use App\Services\SimpananService;
use App\Services\PenarikanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PenarikanRequest;
use App\Services\dataTable\DataTableTransaksiService;

class PenarikanController extends Controller
{
      protected $transaksiService;
      protected $penarikanService;
      protected $simpananService;
      protected $dataTableService;
      protected $anggotaService;
      protected $coaService;
      private $route;
      private $unit;
      private $mainRoute;
      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->penarikanService = new PenarikanService;
            $this->simpananService = new SimpananService;
            $this->dataTableService = new DataTableTransaksiService;
            $this->anggotaService = new AnggotaService(new ImageService);
            $this->coaService = new CoaService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->penarikanService->getUnit($this->route);
            $this->mainRoute = $this->penarikanService->getRouteMain($this->unit);
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $data = [
                  'title' => 'Penarikan Simpanan',
                  'unit' => $this->unit,
                  'routeList' => $this->mainRoute . '.list',
                  'routeCreate' => route($this->mainRoute . '.create'),
                  'createTitle' => 'Penarikan Simpanan',
                  'routeCreateSukarela' => $this->mainRoute . '.create-srb',
                  'titleSukarela' => 'Penarikan Simpanan Sukarela Berbunga',
            ];

            return view('content.simpanan.transaksi-penarikan.main', $data);
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
                  $route = $this->penarikanService->getRouteToTable($this->route);
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
            $jenis = $this->penarikanService->getJenisSimpanan($this->route);
            $prefix = $this->penarikanService->getPrefixSimpanan($jenis, $this->unit);
            $data = [
                  'title' => 'Penarikan Simpanan',
                  'unit' => $this->unit,
                  'jenis' => $jenis,
                  'routeMain' => $this->mainRoute,
                  'routeDetail' => $this->mainRoute . '.detail',
                  'routeSaldo' => $this->mainRoute . '.saldo',
                  'anggota' => $this->anggotaService->getDataAnggotaToForm(),
                  'nomor' => $this->transaksiService->getNomorTransaksi($prefix),
                  'akunKas' => $this->coaService->getCoaKas(),
                  'simpanan' => Simpanan::all(),
                  'akunBank' => $this->coaService->getCoaBank(),
                  'pnyPenarikan' => $this->penarikanService->getPenyesuaian($this->unit, $jenis),
                  'routeStore' => route($this->mainRoute . '.store'),
            ];
            return view('content.simpanan.transaksi-penarikan.create', $data);
      }

      public function detail(Request $request)
      {
            $id_transaksi = $request->input('transaksi_id');
            $detail = Detail_penarikan::with(['transaksi', 'anggota'])->where('id_transaksi', $id_transaksi)->first();
            $jurnals = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $id_transaksi)->get();
            return response()->json(compact('detail', 'jurnals'));
      }

      /**
       * Mengambil saldo simpanan umum
       *
       **/
      public function getSaldo(Request $request)
      {
            $jenis = $request->input('nama');
            $id_anggota = $request->input('id_anggota');
            $id_penyesuaian = $request->input('id_penyesuaian') ?? null;
            if ($id_penyesuaian != null) {
                  $jumlah_penarikan = Detail_penarikan::where('id_transaksi', $id_penyesuaian)
                        ->where('id_anggota', $id_anggota)
                        ->where('nama_penarikan', $jenis)
                        ->value('jumlah_penarikan');
                  $total_pny = $jumlah_penarikan === null ? 0 : $jumlah_penarikan;
            } else {
                  $total_pny = 0;
            }

            $penerimaan = $this->simpananService->getTotalSimpananAnggota($id_anggota, $jenis, $this->unit);
            $penarikan = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, $jenis, $this->unit);
            $saldo = ($penerimaan - $penarikan) + $total_pny;
            return response()->json(compact('saldo'));
      }

      /**
       * Mengambil saldo simpanan sukarela
       * berbunga
       *
       **/
      public function getSaldoSrb(Request $request)
      {
            $persenBunga = $request->input('persen_bunga');
            $id_anggota = $request->input('id_anggota');
            $id_penyesuaian = $request->input('id_penyesuaian') ?? null;
            if ($id_penyesuaian != null) {
                  $jumlah_penarikan = Detail_penarikan::where('id_transaksi', $id_penyesuaian)
                        ->where('id_anggota', $id_anggota)
                        ->where('jenis_penarikan', 'sukarela berbunga')
                        ->value('jumlah_penarikan');
                  $total_pny = $jumlah_penarikan === null ? 0 : $jumlah_penarikan;
            } else {
                  $total_pny = 0;
            }

            $penerimaan = $this->simpananService->getTotalSimpananAnggota($id_anggota, 'Simpanan Sukarela Berbunga', $this->unit);
            $penarikan = $this->penarikanService->getTotalPenarikanAnggota($id_anggota, 'Simpanan Sukarela Berbunga', $this->unit, 'sukarela berbunga');
            $saldo = ($penerimaan - $penarikan) + $total_pny;
            $bunga = $saldo * ($persenBunga / 100);
            return response()->json(compact('saldo', 'bunga'));
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(PenarikanRequest $request)
      {
            // dd($request->all());
            /*Konvert rupiah ke angka*/
            $request["total_transaksi"] = convertToNumber($request->input("total_transaksi"));
            /*Menentukan id dan invoice transaksi penyesuaian*/
            $idTransPeny = $request->input("id_penyesuaian") ?? null;
            $invoicepny = $this->transaksiService->getKodePenyesuaian($request->input('cek_penarikan'), $idTransPeny);
            /*upload file nota transaksi dan get image*/
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->input('nomor'),
                  'nota-penarikan'
            );
            /*Buat transaksi*/
            $this->penarikanService->createTransaksi($request->all(), $invoicepny, $imageName);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('nomor'));
            $this->penarikanService->createDetailTransaksi($request->all(), $id_transaksi);
            /*Buat jurnal*/
            $this->penarikanService->createJurnal($request->all(), $id_transaksi, $idTransPeny);
            alert()->success('Sukses', "Berhasil menambahkan simpanan baru.");
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
            return view('content.simpanan.transaksi-penarikan.show', $data);
      }

      /**
       * Mengambil detail untuk fungsi show
       *
       **/
      public function getDataShow($id)
      {
            $detail = Detail_penarikan::with(['anggota', 'transaksi'])
                  ->where('id_transaksi', $id)->first();
            $data = [
                  'title' => "Penarikan Simpanan",
                  'unit' => $detail->transaksi->unit,
                  'nama' => $detail->anggota->nama,
                  'alamat' => $detail->anggota->tempat_tugas,
                  'id_transaksi' => $detail->id_transaksi,
                  'invoice' => $detail->transaksi->kode,
                  'no_bukti' => $detail->transaksi->no_bukti,
                  'invoicePny' => $detail->transaksi->kode_pny,
                  'tanggal' => $detail->transaksi->tgl_transaksi,
                  'metode' => $detail->transaksi->metode_transaksi,
                  'jenis_transaksi' => $detail->transaksi->jenis_transaksi,
                  'jenis' => $detail->jenis_simpanan,
                  'nota' => $detail->transaksi->nota_transaksi,
                  'tipe' => $detail->transaksi->tipe,
                  'keterangan' => $detail->transaksi->keterangan,
                  'jumlah_penarikan' => $detail->jumlah_penarikan,
                  'jenis_penarikan' => $detail->jenis_penarikan,
                  'nama_penarikan' => $detail->nama_penarikan,
                  'bunga' => $detail->bunga,
                  'ppn' => $detail->pajak,
                  'jurnal' => Jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id)->get(),
                  'routeMain' => $this->mainRoute
            ];
            return $data;
      }
}
