<?php

namespace App\Http\Controllers\transaksi;

use App\Models\Jurnal;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Services\PelunasanService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PelunasanRequest;
use App\Models\Detail_pelunasan_belanja;
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
            $data = [
                  'title' => $request->input('detail'),
                  'unit' => $request->input('unit'),
                  'jenis' => $this->pelunasanService->getJenisPembayaran($request->input('detail')),
                  'pnyPembayaran' => $this->getPenyesuaianPembayaran($request->input('unit'), $request->input('detail')),
                  'tagihan' => $this->getTagihan($request->input('unit'), $request->input('detail')),
                  'noPembayaran' => $this->getNoPembayaran($request->input('route')),
                  'coas' => $this->coaService->getCoaKas(),
                  'coass' => $this->coaService->getCoaBank(),
                  'route' => $request->input('route'),
                  'storeRoute' => route($request->input('route') . '.store-pelunasan'),
                  'routeDetail' => $request->input('route') . '.detail-pelunasan',

            ];
            return view('content.pelunasan.create', $data);
      }

      public function getPenyesuaianPembayaran($unit, $jenis)
      {
            switch ($jenis) {
                  case 'Penjualan Barang':
                  case 'Penjualan Lainnya':
                        $data = $this->pelunasanService->getPenyesuaianPembayaran(new Detail_pelunasan_penjualan, 'main_penjualan', $unit, 'Pembayaran Piutang Penjualan');
                        break;
                  case 'Pengadaan Barang':
                  case 'Belanja':
                        $data = $this->pelunasanService->getPenyesuaianPembayaran(new Detail_pelunasan_belanja, 'main_belanja', $unit, 'Pembayaran Hutang Belanja');
                        break;
            }
            return $data;
      }

      public function getTagihan($unit, $jenis)
      {
            switch ($jenis) {
                  case 'Penjualan Barang':
                  case 'Penjualan Lainnya':
                        $data = $this->pelunasanService->getTagihanPenjualan($unit, $jenis);
                        break;
                  case 'Pengadaan Barang':
                  case 'Belanja':
                        $data = $this->pelunasanService->getTagihanBelanja($unit, $jenis);
                        break;
            }
            return $data;
      }

      public function getNoPembayaran($route)
      {
            $kode = [
                  'ptk-penjualan' => 'PLNP-TK-',
                  'btk-belanja-barang' => 'PLNBB-TK-',
                  'btk-belanja-lain' => 'PLNBO-TK-',
                  'bsp-belanja-barang' => 'PLNBB-SP-',
                  'bsp-belanja-lain' => 'PLNBO-SP-',
            ];

            return $this->transaksiService->getNomorTransaksi($kode[$route]);
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

            if ($request->input('saldo_tagihan') < 0) {
                  alert()->error('Error', "Jumlah pembayaran lebih besar dari total tagihan!");
                  return redirect()->back()->withInput();
            }
            $imageName = $this->transaksiService->addNotaTransaksi(
                  $request->file('nota_transaksi'),
                  $request->input('no_pembayaran'),
                  'nota-pelunasan'
            );
            $detail = $request->input('jenis_transaksi') === 'Pembayaran Piutang Penjualan' ? 'detail_pelunasan_penjualan' : 'detail_pelunasan_belanja';
            $this->pelunasanService->createTransaksi($request, $imageName, $detail);
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
            $route = Route::currentRouteName();
            $jenis = $this->pelunasanService->getJenisDetail($route);
            if ($jenis === 'Pembayaran Piutang Penjualan') {
                  $detail = $this->pelunasanService->getDetailPembayaranPiutang($id_pembayaran);
            } else {
                  $detail = $this->pelunasanService->getDetailPembayaranHutang($id_pembayaran);
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
            $route = Route::currentRouteName();
            $data = $this->getDataShowPembayaran($id, $route);
            return view('content.pelunasan.show', $data);
      }

      public function getDataShowPembayaran($id, $route)
      {
            $jenis = $this->pelunasanService->getJenisDetail($route);
            if ($jenis === 'Pembayaran Piutang Penjualan') {
                  $transaksi = Detail_pelunasan_penjualan::with(['transaksi', 'main_penjualan'])->where('id_transaksi', $id)->first();
                  $dataPembeli = $this->pelunasanService->getDetailPembayaranPiutang($transaksi->id_detail);
            } else {
                  $transaksi = Detail_pelunasan_belanja::with(['transaksi', 'main_belanja', 'main_belanja.penyedia'])->where('id_transaksi', $id)->first();
            }

            $jurnal = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $id)->get();
            return [
                  'title' => $jenis,
                  'unit' => $transaksi->transaksi->unit,
                  'id_transaksi' => $transaksi->id_transaksi,
                  'invoice' => $transaksi->transaksi->kode,
                  'no_bukti' => $transaksi->transaksi->no_bukti,
                  'namaPembeli' => $dataPembeli['nama'] ?? $transaksi->main_belanja->penyedia->nama,
                  'invoiceTagihan' => $dataPembeli['invoice_tagihan'] ?? $transaksi->main_belanja->transaksi->kode,
                  'tanggal' => $transaksi->transaksi->tgl_transaksi,
                  'metode_transaksi' => $transaksi->transaksi->metode_transaksi,
                  'total' => $transaksi->transaksi->total,
                  'nota' => $transaksi->transaksi->nota_transaksi,
                  'tipe' => $transaksi->transaksi->tipe,
                  'status' => $transaksi->main_penjualan->status_penjualan ?? $transaksi->main_belanja->status_belanja,
                  'saldo_tagihan' => $transaksi->main_penjualan->saldo_piutang ?? $transaksi->main_belanja->saldo_hutang,
                  'total_tagihan' => $transaksi->main_penjualan->jumlah_penjualan ?? $transaksi->main_belanja->jumlah_belanja,
                  'invoicePny' => $transaksi->transaksi->kode_pny,
                  'keterangan' => $transaksi->transaksi->keterangan,
                  'routeMain' => str_replace(['.show-pelunasan'], '', $route),
                  'jurnal' => $jurnal
            ];
      }
}
