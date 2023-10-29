<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\BarangService;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Services\dataTable\GudangTableService;
use Illuminate\Support\Facades\Route;

class LaporanGudangController extends Controller
{
      protected $gudangService;
      protected $gudangTableService;
      protected $transaksiService;
      private $unit;
      private $route;

      public function __construct()
      {
            $this->gudangService = new BarangService;
            $this->gudangTableService = new GudangTableService;
            $this->transaksiService = new TransaksiService;
            $this->route = Route::currentRouteName();
            $this->unit = $this->transaksiService->getUnit($this->route);
      }

      public function index(Request $request)
      {
            $other = $this->transaksiService->getDataTanggalTransaksi($request->all());
            $data = [
                  'unit' => $this->unit,
                  'title' => 'Laporan Gudang Unit ' . $this->unit,
                  "title2" => "KPRI \"Usaha Jaya\" Larantuka",
                  "title3" => "Per " . $other['hari'] . " " . $other['nama_bulan'] . ' ' . $other['tahun'],
                  "bulan" => $other['bulan'],
                  "tahun" => $other['tahun'],
                  'routeList' => 'lut-gudang.list',
                  'gdg' => $this->getSaldoGudang()
            ];
            return view('content.laporan.gudang', $data);
      }

      public function list(Request $request)
      {
            if ($request->ajax()) {

                  $tpk = $request->input('tpk');
                  $data = $this->getLaporanGudang();

                  switch ($tpk) {
                        case 'lrtk':
                              $gudang = $data['Larantuka'];
                              break;
                        case 'psr':
                              $gudang = $data['PasarBaru'];
                              break;
                        case 'wrg':
                              $gudang = $data['Waiwerang'];
                              break;
                  }

                  $dataTables = $this->gudangTableService->getDataTable($gudang);
                  return $dataTables;
            }
      }

      private function getLaporanGudang()
      {
            $grosirLrtk = $this->gudangService->getDataBarang($this->unit, 'persediaan', 'Larantuka');
            $eceranLrtk = $this->gudangService->getDataBarangEceran($this->unit, 'persediaan', 'Larantuka');
            $gudangLarantuka = [];
            $gudangLarantuka[] = $this->getGudang($grosirLrtk, $eceranLrtk);

            $grosirPsr = $this->gudangService->getDataBarang($this->unit, 'persediaan', 'Pasar Baru');
            $eceranPsr = $this->gudangService->getDataBarangEceran($this->unit, 'persediaan', 'Pasar Baru');
            $gudangPasarBaru = [];
            $gudangPasarBaru[] = $this->getGudang($grosirPsr, $eceranPsr);

            $grosirWrg = $this->gudangService->getDataBarang($this->unit, 'persediaan', 'Waiwerang');
            $eceranWrg = $this->gudangService->getDataBarangEceran($this->unit, 'persediaan', 'Waiwerang');
            $gudangWaiwerang = [];
            $gudangWaiwerang[] = $this->getGudang($grosirWrg, $eceranWrg);

            return [
                  'Larantuka' => $gudangLarantuka[0],
                  'PasarBaru' => $gudangPasarBaru[0],
                  'Waiwerang' => $gudangWaiwerang[0]
            ];
      }

      private function getGudang($data, $data2)
      {
            $gudang = [];

            $allData = array_merge($data->toArray(), $data2->toArray());

            foreach ($allData as $v) {
                  $stokText = ($v['stok'] === null || $v['stok'] == 0) ? 'stok kosong!' : $v['stok'] . ' ' . $v['satuan']['nama_satuan'];

                  $gudang[] = [
                        'nama' => $v['nama_barang'] ?? $v['barang']['nama_barang'],
                        'jenis' => $v['jenis_barang'] ?? $v['barang']['jenis_barang'],
                        'stok' => $stokText,
                        'harga' => $v['harga_barang'],
                        'jumlah' => ($v['harga_barang'] ?? 0) * $v['stok'],
                  ];
            }

            return $gudang;
      }

      private function getSaldoGudang()
      {
            $gudang = $this->getLaporanGudang();
            $dataLrtk = $this->getSaldo($gudang['Larantuka']);
            $dataPsr = $this->getSaldo($gudang['PasarBaru']);
            $dataWrg = $this->getSaldo($gudang['Waiwerang']);

            return [
                  'saldoLrtk' => $dataLrtk['total'],
                  'saldoPsr' => $dataPsr['total'],
                  'saldoWrg' => $dataWrg['total'],
                  'konsumsiLrtk' => $dataLrtk['konsumsi'],
                  'sandangLrtk' => $dataLrtk['sandang'],
                  'kosmetikLrtk' => $dataLrtk['kosmetik'],
                  'atmLrtk' => $dataLrtk['atm'],
                  'elektronikLrtk' => $dataLrtk['elektronik'],
                  'bangunanLrtk' => $dataLrtk['bangunan'],
                  'konsumsiPsr' => $dataPsr['konsumsi'],
                  'sandangPsr' => $dataPsr['sandang'],
                  'kosmetikPsr' => $dataPsr['kosmetik'],
                  'atmPsr' => $dataPsr['atm'],
                  'elektronikPsr' => $dataPsr['elektronik'],
                  'bangunanPsr' => $dataPsr['bangunan'],
                  'konsumsiWrg' => $dataWrg['konsumsi'],
                  'sandangWrg' => $dataWrg['sandang'],
                  'kosmetikWrg' => $dataWrg['kosmetik'],
                  'atmWrg' => $dataWrg['atm'],
                  'elektronikWrg' => $dataWrg['elektronik'],
                  'bangunanWrg' => $dataWrg['bangunan'],
            ];
      }

      private function getSaldo($data)
      {
            $total = [
                  'konsumsi' => 0,
                  'sandang' => 0,
                  'kosmetik' => 0,
                  'atm' => 0,
                  'elektronik' => 0,
                  'bangunan' => 0,
                  'total' => 0
            ];
            foreach ($data as $d) {
                  $dataJenis = str_replace(['Barang '], '', $d['jenis']);
                  $jenis = strtolower($dataJenis);
                  $total[$jenis] += $d['jumlah'];
                  $total['total'] += $d['jumlah'];
            }
            return $total;
      }
}
