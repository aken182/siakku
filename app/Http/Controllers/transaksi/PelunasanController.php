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
use App\Models\Detail_pelunasan_pinjaman;
use App\Models\Main_pinjaman;
use App\Services\dataTable\DataTableTransaksiService;
use App\Services\PinjamanService;

class PelunasanController extends Controller
{
      protected $transaksiService;
      protected $coaService;
      protected $pelunasanService;
      protected $pinjamanService;
      protected $dataTableService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->pelunasanService = new PelunasanService;
            $this->dataTableService = new DataTableTransaksiService;
            $this->pinjamanService = new PinjamanService;
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
                  'title' => 'Angsuran Pinjaman Anggota',
                  'routeList' => 'pp-angsuran.list',
                  'routeCreate' => route('pp-angsuran.create', ['detail' => 'Pinjaman Anggota', 'unit' => 'Simpan Pinjam', 'route' => 'pp-angsuran']),
                  'createTitle' => 'Tambah Pembayaran',
            ];

            return view('content.pelunasan.main', $data);
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function dataTable(Request $request)
      {
            if ($request->ajax()) {
                  $data = $this->transaksiService->getHistoryTransaction('pp-angsuran.list', 'Simpan Pinjam');
                  $routeToTable = 'pp-angsuran.show-pelunasan';
                  $dataTables = $this->dataTableService->getDataTable($data, $routeToTable);
                  return $dataTables;
            }
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create(Request $request)
      {
            $dataRoute = $this->pelunasanService->getRouteStoreDetail($request);
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
                  'storeRoute' => $dataRoute['storeRoute'],
                  'routeDetail' => $dataRoute['detailRoute'],

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
                  case 'Pinjaman Anggota':
                        $data = $this->pelunasanService->getPenyesuaianPembayaran(new Detail_pelunasan_pinjaman, 'main_pinjaman', $unit, 'Pembayaran Pinjaman Anggota');
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
                  case 'Pinjaman Anggota':
                        $data = $this->pelunasanService->getTagihanPinjaman($unit, $jenis);
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
                  'pp-pinjaman' => 'PLNPNJ-SP-',
                  'pp-angsuran' => 'PLNPNJ-SP-',
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
            // dd($request->all());
            if ($request->input('jenis_transaksi') === 'Pembayaran Pinjaman Anggota') {
                  $imageName = $this->transaksiService->addNotaTransaksi(
                        $request->file('nota_transaksi'),
                        $request->input('no_pembayaran'),
                        'nota-pelunasan'
                  );
                  $this->createAngsuran($request->all(), $imageName);
            } else {
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
                  $this->pelunasanService->createTransaksi($request->all(), $imageName, $detail);
                  $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request->input('no_pembayaran'));
                  $this->pelunasanService->createDetailTransaksi($id_transaksi, $request);
                  $this->pelunasanService->createJurnal($request->all(), $id_transaksi);
            }

            alert()->success('Sukses', 'Berhasil menambahkan pembayaran tagihan penjualan.');
            $route = $request->input('routemain');
            return redirect()->route($route);
      }

      /**
       * Menginput angsuran pinjaman ke dalam database.
       *
       **/
      public function createAngsuran($request, $imageName)
      {
            $request['total_transaksi'] = convertToNumber($request['total_transaksi']);
            $id_penyesuaian = $request['id_pny_pembayaran'] ?? null;
            $id_trans_pny = null;
            if ($request['cek_pembayaran'] === 'penyesuaian') {
                  $id_trans_pny = Detail_pelunasan_pinjaman::where('id_detail', $id_penyesuaian)->value('id_transaksi');
            }
            $request['invoicepny'] = $this->transaksiService->getKodePenyesuaian($request['cek_pembayaran'], $id_trans_pny);
            $this->pelunasanService->createTransaksi($request, $imageName, 'detail_pelunasan_pinjaman');
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($request['no_pembayaran']);
            $this->pelunasanService->createDetailAngsuran($id_transaksi, $request, $id_penyesuaian);
            $this->pelunasanService->createJurnalAngsuranPinjaman($request, $id_transaksi, $id_trans_pny);
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
            switch ($jenis) {
                  case 'Pembayaran Piutang Penjualan':
                        $detail = $this->pelunasanService->getDetailPembayaranPiutang($id_pembayaran);
                        break;
                  case 'Pembayaran Hutang Belanja':
                        $detail = $this->pelunasanService->getDetailPembayaranHutang($id_pembayaran);
                        break;
                  case 'Pembayaran Pinjaman Anggota':
                        $detail = $this->pelunasanService->getDetailPembayaranPinjaman($id_pembayaran);
                        break;
            }
            $jurnals = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $detail['id_transaksi'])->get();
            return response()->json(compact('detail', 'jurnals'));
      }

      /**
       * Mengambil data pinjaman anggota
       *
       **/
      public function pinjaman(Request $request)
      {
            $id_pinjaman = $request->input('id_pinjaman');
            $id_penyesuaian = $request->input('id_penyesuaian') ?? null;
            $id = Main_pinjaman::where('id_pinjaman', $id_pinjaman)->value('id_transaksi');
            $detail = $this->pinjamanService->getDetailPinjamanAnggota($id);

            if ($id_penyesuaian === null) {
                  $saldo_pokok = $detail->saldo_pokok;
                  $saldo_bunga = $detail->saldo_bunga;
            } else {
                  $penyesuaian = Detail_pelunasan_pinjaman::where('id_detail', $id_penyesuaian)
                        ->where('id_pinjaman', $id_pinjaman)->first();
                  $angsuranBungaPny = $penyesuaian->angsuran_bunga ?? 0;
                  $angsuranPokokPny = $penyesuaian->angsuran_pokok ?? 0;
                  $saldo_pokok = $detail->saldo_pokok + $angsuranPokokPny;
                  $saldo_bunga = $detail->saldo_bunga + $angsuranBungaPny;
            }

            $data = [
                  'kode' => $detail->transaksi->kode,
                  'no_bukti' => $detail->transaksi->no_bukti,
                  'tgl_transaksi' => date('d-m-Y', strtotime($detail->transaksi->tgl_transaksi)),
                  'nama' => $detail->anggota->nama,
                  'status' => $detail->status,
                  'saldo_pokok' => $saldo_pokok,
                  'saldo_bunga' => $saldo_bunga,
                  'total_pinjaman' => $detail->total_pinjaman
            ];

            return response()->json(compact('data'));
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
            $data['title'] = $data['jenis'] === 'pinjam tindis' ? 'Pinjaman Anggota' : $data['title'];
            return view('content.pelunasan.show', $data);
      }

      public function getDataShowPembayaran($id, $route)
      {
            $jenis = $this->pelunasanService->getJenisDetail($route);
            switch ($jenis) {
                  case 'Pembayaran Piutang Penjualan':
                        $transaksi = Detail_pelunasan_penjualan::with(['transaksi', 'main_penjualan'])->where('id_transaksi', $id)->first();
                        $dataPembeli = $this->pelunasanService->getDetailPembayaranPiutang($transaksi->id_detail);
                        $status = $transaksi->main_penjualan->status_penjualan;
                        break;
                  case 'Pembayaran Hutang Belanja':
                        $transaksi = Detail_pelunasan_belanja::with(['transaksi', 'main_belanja', 'main_belanja.penyedia'])->where('id_transaksi', $id)->first();
                        $status = $transaksi->main_belanja->status_belanja;
                        break;
                  case 'Pembayaran Pinjaman Anggota':
                        $transaksi = Detail_pelunasan_pinjaman::with(['transaksi', 'main_pinjaman', 'main_pinjaman.anggota'])->where('id_transaksi', $id)->first();
                        $status = $transaksi->main_pinjaman->status;
                        break;
            }

            $jurnal = Jurnal::with(['transaksi', 'coa'])
                  ->where('id_transaksi', $id)->get();
            return [
                  'title' => $jenis,
                  'unit' => $transaksi->transaksi->unit,
                  'id_transaksi' => $transaksi->id_transaksi,
                  'invoice' => $transaksi->transaksi->kode,
                  'no_bukti' => $transaksi->transaksi->no_bukti,
                  'namaPembeli' => $dataPembeli['nama'] ?? $transaksi->main_belanja->penyedia->nama ?? null,
                  'namaAnggota' => $transaksi->main_pinjaman->anggota->nama ?? null,
                  'jumlahPinjaman' => $transaksi->main_pinjaman->total_pinjaman ?? null,
                  'jenis' => $transaksi->jenis_angsuran ?? null,
                  'besarPenambahan' => $transaksi->besar_pinjaman ?? null,
                  'invoiceTagihan' => $dataPembeli['invoice_tagihan'] ?? $transaksi->main_belanja->transaksi->kode ?? null,
                  'kodePinjaman' => $transaksi->main_pinjaman->transaksi->kode ?? null,
                  'tanggal' => $transaksi->transaksi->tgl_transaksi,
                  'metode_transaksi' => $transaksi->transaksi->metode_transaksi,
                  'total' => $transaksi->transaksi->total,
                  'jumlah_bayar' => $transaksi->jumlah_pelunasan ?? null,
                  'pot_bendahara' => $transaksi->pot_bendahara ?? null,
                  'angsuran_pokok' => $transaksi->angsuran_pokok ?? null,
                  'angsuran_bunga' => $transaksi->angsuran_bunga ?? null,
                  'bunga' => $transaksi->bunga ?? null,
                  'nota' => $transaksi->transaksi->nota_transaksi,
                  'tipe' => $transaksi->transaksi->tipe,
                  'status' =>  $status,
                  'saldo_tagihan' => $transaksi->main_penjualan->saldo_piutang ?? $transaksi->main_belanja->saldo_hutang ?? null,
                  'total_tagihan' => $transaksi->main_penjualan->jumlah_penjualan ?? $transaksi->main_belanja->jumlah_belanja ?? null,
                  'saldo_pokok' => $transaksi->main_pinjaman->saldo_pokok ?? null,
                  'saldo_bunga' => $transaksi->main_pinjaman->saldo_bunga ?? null,
                  'invoicePny' => $transaksi->transaksi->kode_pny,
                  'keterangan' => $transaksi->transaksi->keterangan,
                  'routeMain' => str_replace(['.show-pelunasan'], '', $route),
                  'jurnal' => $jurnal
            ];
      }
}
