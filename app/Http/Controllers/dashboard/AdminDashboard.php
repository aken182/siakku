<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Http\Controllers\Controller;
use App\Services\AccountingService;
use App\Services\LabaRugiService;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Controller
{
      protected $user;
      protected $dashboardList;
      protected $accountingService;
      protected $labaRugiService;
      protected static $mainDashboard = 'main-dashboard';
      protected static $pertokoanDashboard = 'pertokoan-dashboard';
      protected static $simpanPinjamDashboard = 'simpan-pinjam-dashboard';

      public function __construct()
      {
            $this->middleware(function ($request, $next) {
                  $this->user = Auth::user();
                  return $next($request);
            });
            $this->accountingService = new AccountingService;
            $this->labaRugiService = new LabaRugiService;
      }

      public function index()
      {
            // cek permission untuk dashboard main-dashboard
            if (Auth::check() && Auth::user()->hasPermissionTo('main-dashboard')) {
                  $user = $this->user;
                  return $this->mainDashboard(new DashboardService);
            } else {
                  //cek permission untuk dashboard dengan permission bukan main-dashboard
                  if (Auth::check()) {
                        $user = $this->user;
                        $permissions = $user->getPermissionsViaRoles()->pluck('name');
                        // dd($permissions);
                        foreach ($permissions as $permission) {
                              if (str_contains($permission, 'dashboard')) {
                                    $dashboards = $this->getDashboard();
                                    if (array_key_exists($permission, $dashboards)) {
                                          $dashboardFunction = $dashboards[$permission];
                                          return $dashboardFunction(); //panggil function dashboard yang sesuai
                                    }
                              }
                        }
                  } else {
                        return redirect()->route('login');
                  }
            }
      }

      public function mainDashboard(DashboardService $dashboardService)
      {
            $bulan = date('m');
            $tahun = date('Y');
            $rekapToko = $this->labaRugiService->getRekapPertokoan($bulan, $tahun, 'Pertokoan');
            $grafikLabaRugiToko = $dashboardService->getGrafikLabaRugi('Pertokoan', $bulan, $tahun);
            $rekapSp = $this->labaRugiService->getRekapSimpanPinjam('Simpan Pinjam', $bulan, $tahun);
            $grafikLabaRugiSp = $dashboardService->getGrafikLabaRugi('Simpan Pinjam', $bulan, $tahun);
            $persediaan = $dashboardService->grafikPersediaan('Pertokoan', $bulan, $tahun);
            $grafikSimpananSp = $dashboardService->getSeparatedGrafikSimpananSp($bulan, $tahun);
            $data = [
                  'title' => 'Dashboard',
                  'kasBankToko' => $this->accountingService->getSaldo($bulan, $tahun, 1, 'Pertokoan', true, 'subkategori', "%Kas & Bank%"),
                  'kasBankSp' => $this->accountingService->getSaldo($bulan, $tahun, 1, 'Simpan Pinjam', true, 'subkategori', "%Kas & Bank%"),
                  'simpananToko' => $this->accountingService->getSaldo($bulan, $tahun, 2, 'Pertokoan', true, 'nama', "%Simpanan Khusus Pertokoan%"),
                  'simpananSp' => $this->accountingService->getSaldo($bulan, $tahun, 2, 'Simpan Pinjam', true, 'subkategori', "%Simpanan%"),
                  'piutangBarangToko' => $this->accountingService->getSaldo($bulan, $tahun, 1, 'Pertokoan', true, 'nama', "%Piutang Barang%"),
                  'piutangPinjamanSp' => $this->accountingService->getSaldo($bulan, $tahun, 1, 'Simpan Pinjam', true, 'nama', "%Piutang Simpan Pinjam%"),
                  'pendapatanToko' => $rekapToko['totalPendapatan'],
                  'belanjaToko' => $rekapToko['totalBiaya'],
                  'pendapatanSp' => $rekapSp['totalPendapatan'],
                  'belanjaSp' => $rekapSp['totalBiaya'],
                  'shuToko' => $rekapToko['shu'],
                  'shuSp' => $rekapSp['shu'],
                  'lrToko' => $grafikLabaRugiToko['saldo'],
                  'lrSp' => $grafikLabaRugiSp['saldo'],
                  'bulanLrToko' => $grafikLabaRugiToko['bulan'],
                  'bulanLrSp' => $grafikLabaRugiSp['bulan'],
                  'anggota' => $dashboardService->getAnggotaToDashboard(),
                  'persediaanSaldo' => $persediaan['saldo'],
                  'persediaanNama' => $persediaan['nama'],
                  'keysSimpananSp' => $grafikSimpananSp['keys'],
                  'valuesSimpananSp' => $grafikSimpananSp['values'],
            ];
            return view('content.dashboard.admin-dashboard', $data);
      }

      public function getDashboard()
      {
            $dashboards = [
                  self::$pertokoanDashboard => function () {
                        return $this->mainDashboard(new DashboardService);
                  },
                  self::$simpanPinjamDashboard => function () {
                        return $this->mainDashboard(new DashboardService);
                  },
            ];
            return $dashboards;
      }
}
