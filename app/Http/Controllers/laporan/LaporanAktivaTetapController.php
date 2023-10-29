<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Models\Detail_penyusutan;
use App\Services\BarangService;
use App\Services\dataTable\AktivaTetapTableService;
use Illuminate\Support\Facades\Route;

class LaporanAktivaTetapController extends Controller
{
      protected $transaksiService;
      protected $barangService;
      protected $dataTableService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->barangService = new BarangService;
            $this->dataTableService = new AktivaTetapTableService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $data = [
                  'title' => 'Laporan Aktiva Tetap',
                  'title2' => "Unit " . $this->unit,
                  'title3' => "KPRI Usaha Jaya - Larantuka",
                  'unit' => $this->unit,
                  'routeList' => $this->transaksiService->getRouteListAktivaTetap($this->unit),
                  'tahun' => $other['tahun']
            ];

            return view('content.laporan.aktiva-tetap', $data);
      }

      public function list(Request $request)
      {
            if ($request->ajax()) {
                  $data = $this->getLaporan();
                  $dataTables = $this->dataTableService->getDataTable($data);
                  return $dataTables;
            }
      }

      private function getLaporan()
      {
            $grosir = $this->getGrosirData();
            $eceran = $this->getEceranData();
            $data = array_merge($grosir, $eceran);

            usort($data, function ($a, $b) {
                  return $a['nama'] <=> $b['nama'];
            });
            $no = 0;
            foreach ($data as &$key) {
                  $no += 1;
                  $key['no'] = $no;
            }
            return $data;
      }

      private function getGrosirData()
      {
            $data = [];
            $tahunBerjalan = date('Y');
            $grosirData = $this->barangService->getDataBarang($this->unit, 'inventaris');

            foreach ($grosirData as $grosir) {
                  $tahun = $grosir->tgl_beli !== null ? date('Y', strtotime($grosir->tgl_beli)) : '';
                  $harga_perolehan = $grosir->harga_barang * $grosir->stok;
                  $nilai_buku = $grosir->nilai_saat_ini * $grosir->stok;
                  $penyusutan = $harga_perolehan - $nilai_buku;

                  $hrgSbm = ($tahun != $tahunBerjalan) ? $harga_perolehan : 0;
                  $hrgBjln = ($tahun == $tahunBerjalan) ? $harga_perolehan : 0;

                  $data[] = [
                        'nama' => $grosir->nama_barang,
                        'jenis' => $grosir->jenis_barang,
                        'qty' => ($grosir->stok <= 0) ? 'barang kosong !' : $grosir->stok . ' ' . $grosir->satuan->nama_satuan,
                        'tahun_beli' => $tahun,
                        'harga_sblm' => $hrgSbm,
                        'harga_bjln' => $hrgBjln,
                        'harga_perolehan' => $harga_perolehan,
                        'pny_sblm' => $this->getTotalPenyusutan($grosir->id_barang, 'grosir', $tahunBerjalan, false),
                        'pny_bjln' => $this->getTotalPenyusutan($grosir->id_barang, 'grosir', $tahunBerjalan, true),
                        'penyusutan' => $penyusutan,
                        'nilai_buku' => $nilai_buku,
                        'masa_manfaat' => $grosir->umur_ekonomis . ' tahun',
                  ];
            }

            return $data;
      }

      private function getEceranData()
      {
            $data = [];
            $tahunBerjalan = date('Y');
            $eceranData = $this->barangService->getDataBarangEceran($this->unit, 'inventaris');

            foreach ($eceranData as $eceran) {
                  $tahun = $eceran->barang->tgl_beli !== null ? date('Y', strtotime($eceran->barang->tgl_beli)) : '';
                  $harga_perolehan = $eceran->harga_barang * $eceran->stok;
                  $nilai_buku = $eceran->nilai_saat_ini * $eceran->stok;
                  $penyusutan = $harga_perolehan - $nilai_buku;

                  $hrgSbm = ($tahun != $tahunBerjalan) ? $harga_perolehan : 0;
                  $hrgBjln = ($tahun == $tahunBerjalan) ? $harga_perolehan : 0;

                  $data[] = [
                        'nama' => $eceran->barang->nama_barang,
                        'jenis' => $eceran->barang->jenis_barang,
                        'qty' => ($eceran->stok <= 0) ? 'barang kosong !' : $eceran->stok . ' ' . $eceran->satuan->nama_satuan,
                        'tahun_beli' => $tahun,
                        'harga_sblm' => $hrgSbm,
                        'harga_bjln' => $hrgBjln,
                        'harga_perolehan' => $harga_perolehan,
                        'pny_sblm' => $this->getTotalPenyusutan($eceran->id_eceran, 'eceran', $tahunBerjalan, false),
                        'pny_bjln' => $this->getTotalPenyusutan($eceran->id_eceran, 'eceran', $tahunBerjalan, true),
                        'penyusutan' => $penyusutan,
                        'nilai_buku' => $nilai_buku,
                        'masa_manfaat' => $eceran->barang->umur_ekonomis . ' tahun',
                  ];
            }

            return $data;
      }


      private function getTotalPenyusutan($id, $jenis, $tahun, $sekarang = true)
      {
            $transaksi = $this->getTransaksi($sekarang, $tahun);
            $id_colum = $jenis === 'grosir' ? 'id_barang' : 'id_eceran';
            $detail = Detail_penyusutan::with(['transaksi', 'barang_eceran', 'barang', 'satuan'])
                  ->where($id_colum, $id)
                  ->whereHas('transaksi', $transaksi)->get();
            $total = $detail->sum('subtotal');
            return $total;
      }

      private function getTransaksi($sekarang, $tahun)
      {
            $unit = $this->unit;
            if ($sekarang === true) {
                  $transaksi = function ($query) use ($tahun, $unit) {
                        $query->whereYear('tgl_transaksi', $tahun)
                              ->where('unit', $unit)
                              ->whereNot('tipe', 'kadaluwarsa');
                  };
            } else {
                  $transaksi = function ($query) use ($tahun, $unit) {
                        $query->whereDate('tgl_transaksi', '<', "$tahun-01-01")
                              ->where('unit', $unit)
                              ->whereNot('tipe', 'kadaluwarsa');
                  };
            }
            return $transaksi;
      }
}
