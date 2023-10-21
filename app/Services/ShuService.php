<?php

namespace App\Services;

use App\Models\Detail_transaksi_shu;
use App\Models\Jurnal;
use App\Models\Shu;
use App\Models\Transaksi;
use App\Services\LabaRugiService;
use Illuminate\Support\Facades\Route;

class ShuService
{
      private $labaRugiService;
      private $coaService;

      public function __construct()
      {
            $this->labaRugiService = new LabaRugiService;
            $this->coaService = new CoaService;
      }

      public function getDataIndex()
      {
            $routeName = Route::currentRouteName();
            $data = [
                  'unit' => '',
                  'tipe' => '',
                  'routeCreate' => '',
                  'routeImport' => '',
                  'routeEdit' => '',
                  'routeDelete' => '',
                  'routeMaster' => '',
                  'routeList' => '',
                  'routeTransaksi' => '',
            ];

            switch ($routeName) {
                  case 'shu-unit-pertokoan':
                        $data['unit'] = 'Pertokoan';
                        $data['tipe'] = 'master';
                        $data['routeCreate'] = route('shu-unit-pertokoan.create');
                        $data['routeImport'] = route('shu-unit-pertokoan.form-import');
                        $data['routeEdit'] = 'shu-unit-pertokoan.edit';
                        $data['routeDelete'] = 'shu-unit-pertokoan.destroy';
                        $data['routeMaster'] = route('shu-unit-pertokoan');
                        $data['routeTransaksi'] = route('shu-unit-pertokoan.transaksi');
                        break;

                  case 'shu-unit-sp':
                        $data['unit'] = 'Simpan Pinjam';
                        $data['tipe'] = 'master';
                        $data['routeCreate'] = route('shu-unit-sp.create');
                        $data['routeImport'] = route('shu-unit-sp.form-import');
                        $data['routeEdit'] = 'shu-unit-sp.edit';
                        $data['routeDelete'] = 'shu-unit-sp.destroy';
                        $data['routeMaster'] = route('shu-unit-sp');
                        $data['routeTransaksi'] = route('shu-unit-sp.transaksi');
                        break;

                  case 'shu-unit-pertokoan.create':
                        $data['unit'] = 'Pertokoan';
                        $data['routeStore'] = route('shu-unit-pertokoan.store');
                        $data['routeMaster'] = route('shu-unit-pertokoan');
                        break;

                  case 'shu-unit-sp.create':
                        $data['unit'] = 'Simpan Pinjam';
                        $data['routeStore'] = route('shu-unit-sp.store');
                        $data['routeMaster'] = route('shu-unit-sp');
                        break;

                  case 'shu-unit-pertokoan.edit':
                        $data['unit'] = 'Pertokoan';
                        $data['routeUpdate'] = 'shu-unit-pertokoan.update';
                        $data['routeMaster'] = route('shu-unit-pertokoan');
                        break;

                  case 'shu-unit-sp.edit':
                        $data['unit'] = 'Simpan Pinjam';
                        $data['routeUpdate'] = 'shu-unit-sp.update';
                        $data['routeMaster'] = route('shu-unit-sp');
                        break;

                  case 'shu-unit-pertokoan.store':
                  case 'shu-unit-pertokoan.update':
                        $data['routeMaster'] = 'shu-unit-pertokoan';
                        break;

                  case 'shu-unit-sp.store':
                  case 'shu-unit-sp.upate':
                        $data['routeMaster'] = 'shu-unit-sp';
                        break;

                  case 'shu-unit-pertokoan.transaksi':
                        $data['tipe'] = 'transaksi';
                        $data['routeCreate'] = route('shu-unit-pertokoan.transaksi-create');
                        $data['routeMaster'] = route('shu-unit-pertokoan');
                        $data['routeList'] = 'shu-unit-pertokoan.transaksi-list';
                        $data['routeTransaksi'] = route('shu-unit-pertokoan.transaksi');
                        break;

                  case 'shu-unit-sp.transaksi':
                        $data['tipe'] = 'transaksi';
                        $data['routeCreate'] = route('shu-unit-sp.transaksi-create');
                        $data['routeMaster'] = route('shu-unit-sp');
                        $data['routeList'] = 'shu-unit-sp.transaksi-list';
                        $data['routeTransaksi'] = route('shu-unit-sp.transaksi');
                        break;
            }

            return $data;
      }

      public function getRouteToTable($route)
      {
            $data = [
                  'shu-unit-pertokoan.transaksi-list' => 'shu-unit-pertokoan.transaksi-show',
                  'shu-unit-sp.transaksi-list' => 'shu-unit-sp.transaksi-show'
            ];
            return $data[$route];
      }

      /**
       * Mengambil unit transaksi berdasarkan
       * routeName
       *
       **/
      public function getUnit($route)
      {
            $unit = [
                  'shu-unit-pertokoan.transaksi' => 'Pertokoan',
                  'shu-unit-sp.transaksi' => 'Simpan Pinjam',
            ];
            $route = str_replace(['-create', '-chart', '-jurnal', '-list', '-store', '-show', '-detail'], '', $route);
            return $unit[$route];
      }

      /**
       * Mengambil route utama transaksi berdasarkan
       * unit
       *
       **/
      public function getMainRouteTransaksi($unit)
      {
            $route = [
                  'Simpan Pinjam' => 'shu-unit-sp.transaksi',
                  'Pertokoan' => 'shu-unit-pertokoan.transaksi',
            ];
            return $route[$unit];
      }

      public function getEstimasi($unit, $tahun = null, $bulan = null)
      {
            $bulan = $bulan ?? date('m');
            $tahun = $tahun ?? date('Y');

            $getShu = $unit === 'Pertokoan'
                  ? $this->labaRugiService->getRekapPertokoan($bulan, $tahun, $unit)
                  : $this->labaRugiService->getRekapSimpanPinjam($unit, $bulan, $tahun);

            $shu = $getShu['shu'];
            $masterShu = Shu::where('unit', $unit)->get();

            $estimasiDana = collect($masterShu)->map(function ($key) use ($shu) {
                  $jumlah_alokasi = ($key->persen / 100) * $shu;
                  $alokasi = (round($jumlah_alokasi));
                  return [
                        'id_shu' => $key->id_shu,
                        'nama' => $key->nama,
                        'series' => $key->persen,
                        'persentase' => $key->persen . '%',
                        'jumlah_alokasi' => $jumlah_alokasi,
                        'alokasi' => $alokasi,
                  ];
            });

            return [
                  'shu' => $shu,
                  'dana' => $estimasiDana->all(),
            ];
      }

      public function getTransaksiPenyesuaian($unit)
      {
            $penyesuaian = Transaksi::whereNot('tipe', 'kadaluwarsa')
                  ->where('unit', $unit)
                  ->where('jenis_transaksi', 'Pembagian SHU')
                  ->get();
            return $penyesuaian;
      }

      public function getTanggalConvert($tglInput)
      {
            return [
                  'tahun' => date('Y', strtotime($tglInput)),
                  'bulan' => date('Y', strtotime($tglInput))
            ];
      }

      public function getJurnalToCreate($unit, $tahun, $cek, $id_pny = null)
      {
            if ($tahun === date('Y')) {
                  $bulan = date('m');
            } else {
                  $bulan = 12;
            }

            $jurnal = [];
            $no = 0;
            if ($id_pny) {
                  $jurnalPembalik = Jurnal::with(['transaksi', 'coa'])
                        ->where('id_transaksi', $id_pny)
                        ->orderBy('id_jurnal', 'desc')->get();
                  if ($jurnalPembalik) {
                        foreach ($jurnalPembalik as $value) {
                              $no += 1;
                              $posisi = $value->posisi_dr_cr === 'kredit' ? 'debet' : 'kredit';
                              $jurnal[] = [
                                    'id' => $no,
                                    'nama' => $value->coa->nama,
                                    'kode' => $value->coa->kode,
                                    'posisi_dr_cr' => $posisi,
                                    'nominal' => $value->nominal,
                              ];
                        }
                  }
            }

            $estimasi = $this->getEstimasi($unit, $tahun, $bulan);

            if ($cek === 'off') {
                  $id_shu = $this->coaService->getIdCoa('nama', 'SHU', 'subkategori', 'Dana SHU');
                  $coaShu = $this->coaService->getDataCoa($id_shu);
                  $no += 1;
                  $jurnal[] = [
                        'id' => $no,
                        'nama' => $coaShu->nama,
                        'kode' => $coaShu->kode,
                        'posisi_dr_cr' => 'debet',
                        'nominal' => $cek === 'off' ? $estimasi['shu'] : 0,
                  ];
                  foreach ($estimasi['dana'] as $key) {
                        $id_coa = $this->coaService->getIdCoa('nama', $key['nama'], 'subkategori', 'Dana SHU');
                        $coa = $this->coaService->getDataCoa($id_coa);
                        $no += 1;
                        $jurnal[] = [
                              'id' => $no,
                              'nama' => $coa->nama,
                              'kode' => $coa->kode,
                              'posisi_dr_cr' => 'kredit',
                              'nominal' => $cek === 'off' ? $key['jumlah_alokasi'] : 0,
                        ];
                  }
            }

            return [
                  'jurnal' => $jurnal,
                  'total' => $cek === 'off' ? $estimasi['shu'] : 0
            ];
      }

      public function getTotalTransaksi($tahun, $unit, $cek)
      {
            if ($tahun === date('Y')) {
                  $bulan = date('m');
            } else {
                  $bulan = 12;
            }
            $estimasi = $this->getEstimasi($unit, $tahun, $bulan);
            $total = $cek === 'off' ? $estimasi['shu'] : 0;
            return $total;
      }

      public function createTransaksi($request, $kodePenyesuaian, $unit)
      {
            Transaksi::create([
                  'kode' => $request['nomor'],
                  'kode_pny' => $kodePenyesuaian,
                  'tipe' => $request['cek_penyesuaian'],
                  'tgl_transaksi' => $request['tahun_shu'] . '-12-31',
                  'jenis_transaksi' => 'Pembagian SHU',
                  'detail_tabel' => 'detail_transaksi_shu',
                  'metode_transaksi' => 'Pembagian SHU',
                  'total' => $request['total_transaksi'],
                  'keterangan' => $request['keterangan'],
                  'unit' => $unit,
                  'tahun_buku' => $request['tahun_shu'],
            ]);
      }

      public function createDetailTransaksi($id_transaksi, $request, $unit, $cek)
      {
            if ($request['tahun_shu'] === date('Y')) {
                  $bulan = date('m');
            } else {
                  $bulan = 12;
            }

            $estimasi = $this->getEstimasi($unit, $request['tahun_shu'], $bulan);
            $detail = new Detail_transaksi_shu;
            foreach ($estimasi['dana'] as $key) {
                  $detail::create([
                        'id_transaksi' => $id_transaksi,
                        'id_shu' => $key['id_shu'],
                        'jenis_pembagian' => 'Pembagian SHU tahun ' . $request['tahun_shu'],
                        'total' => $cek === 'off' ? $key['jumlah_alokasi'] : 0,
                  ]);
            }
      }

      public function createJurnal($id_transaksi, $request, $id_penyesuaian, $unit, $cek)
      {
            if ($request['tahun_shu'] === date('Y')) {
                  $bulan = date('m');
            } else {
                  $bulan = 12;
            }

            /*deklarasi variabel lain untuk fungsi input jurnal*/
            $model = new Jurnal;
            $estimasi = $this->getEstimasi($unit, $request['tahun_shu'], $bulan);

            /*Input Jurnal*/

            /*jurnal pembalik*/
            if ($request['cek_penyesuaian'] === 'penyesuaian') {
                  jurnalPembalik($model, $id_transaksi, $id_penyesuaian);
            }

            /*jurnal baru*/
            $id_debet = $this->coaService->getIdCoa('nama', 'SHU', 'subkategori', 'Dana SHU');
            if ($id_debet) {
                  jurnal($model, $id_debet, $id_transaksi, 'debet', $request['total_transaksi']);
            }

            foreach ($estimasi['dana'] as $key) {
                  $id_kredit = $this->coaService->getIdCoa('nama', $key['nama'], 'subkategori', 'Dana SHU');
                  if ($id_kredit) {
                        $total = $cek === 'off' ? $key['jumlah_alokasi'] : 0;
                        jurnal($model, $id_kredit, $id_transaksi, 'kredit', $total);
                  }
            }
      }
}
