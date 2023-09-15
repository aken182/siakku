<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Services\PelunasanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\PelunasanRequest;
use App\Models\Detail_pelunasan_penjualan;

class PelunasanController extends Controller
{
      protected $transaksiService;
      protected $coaService;
      protected $pelunasanService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->pelunasanService = new PelunasanService;
            $this->coaService = new CoaService;
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {

            $data = [
                  'transaksi' => $this->transaksiService->getHistoryTransaction(),
                  'title' => 'Pelunasan'
            ];

            return view('content.pelunasan.main', $data);
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create(Request $request)
      {
            $jenis = $request->input('detail');
            $unit = $request->input('unit');
            $route = $request->input('route');
            $storeRoute = route('ptk-penjualan.store-pelunasan');
            $data = [
                  'title' => $jenis,
                  'unit' => $unit,
                  'jenis' => $jenis,
                  'pnyPembayaran' => $this->pelunasanService->getPenyesuaianPembayaranPiutang($unit, 'Pembayaran Piutang Penjualan'),
                  'tagihan' => $this->pelunasanService->getTagihanPenjualan($unit, $jenis),
                  'nopembayaran' => $this->transaksiService->getNomorTransaksi('PLNP-TK-'),
                  'coas' => $this->coaService->getCoaKas(),
                  'coass' => $this->coaService->getCoaBank(),
                  'route' => $route,
                  'storeRoute' => $storeRoute,

            ];
            return view('content.pelunasan.create', $data);
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(PelunasanRequest $request)
      {
            $this->pelunasanService->validateCustomField($request);

            if ($request->input('saldo_piutang') < 0) {
                  alert()->error('Error', "Jumlah pembayaran lebih besar dari total tagihan!");
                  return redirect()->back()->withInput();
            }
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->input('no_pembayaran'),
                  'nota-pelunasan'
            );
            $this->pelunasanService->createTransaksi($request, $imageName, 'detail_pelunasan_penjualan');
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('no_pembayaran'));
            $this->pelunasanService->createDetailTransaksi($id_transaksi, $request);
            $this->pelunasanService->createJurnal($request->all(), $id_transaksi);
            alert()->success('Sukses', 'Berhasil menambahkan pembayaran tagihan penjualan.');
            $route = $request->input('routemain');
            return redirect()->route($route);
      }

      /**
       * Mengambil detail transaksi pembayaran 
       * yang akan disesuaikan
       * 
       * @param \Illuminate\Http\Request $request
       * @return \Illuminate\Http\JsonResponse
       **/
      public function detail(Request $request)
      {

            $id_pembayaran = $request->input('pembayaran_id');
            $detail = $this->pelunasanService->getDetailPembayaranPiutang($id_pembayaran);
            if (!$detail) {
                  return response()->json(['error' => 'Detail pembayaran tagihan tidak ditemukan'], 404);
            }
            $jurnals = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $detail['id_transaksi'])->get();
            return response()->json(compact('detail', 'jurnals'));
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
            $data = $this->getDataShowPembayaran($id);
            return view('content.pelunasan.show', $data);
      }

      public function getDataShowPembayaran($id)
      {
            $transaksi = Detail_pelunasan_penjualan::with(['transaksi', 'main_penjualan'])->where('id_transaksi', $id)->first();
            $dataPembeli = $this->pelunasanService->getDetailPembayaranPiutang($transaksi->id_detail);
            $jurnal = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $id)->get();
            return [
                  'title' => "Pembayaran Tagihan Penjualan",
                  'unit' => $transaksi->transaksi->unit,
                  'id_transaksi' => $transaksi->id_transaksi,
                  'invoice' => $transaksi->transaksi->kode,
                  'no_bukti' => $transaksi->transaksi->no_bukti,
                  'namaPembeli' => $dataPembeli['nama'],
                  'invoiceTagihan' => $dataPembeli['invoice_tagihan'],
                  'tanggal' => $transaksi->transaksi->tgl_transaksi,
                  'metode_transaksi' => $transaksi->transaksi->metode_transaksi,
                  'total' => $transaksi->transaksi->total,
                  'nota' => $transaksi->transaksi->nota_transaksi,
                  'tipe' => $transaksi->transaksi->tipe,
                  'status' => $transaksi->main_penjualan->status_penjualan,
                  'saldo_piutang' => $transaksi->main_penjualan->saldo_piutang,
                  'total_tagihan' => $transaksi->main_penjualan->jumlah_penjualan,
                  'invoicePny' => $transaksi->transaksi->kode_pny,
                  'keterangan' => $transaksi->transaksi->keterangan,
                  'routeMain' => 'ptk-penjualan',
                  'jurnal' => $jurnal
            ];
      }
}
