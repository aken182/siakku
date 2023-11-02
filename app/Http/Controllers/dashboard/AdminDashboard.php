<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Controller
{
      protected $user;
      protected $dashboardList;
      protected static $mainDashboard = 'main-dashboard';
      protected static $pertokoanDashboard = 'pertokoan-dashboard';
      protected static $simpanPinjamDashboard = 'simpan-pinjam-dashboard';

      public function __construct()
      {
            $this->middleware(function ($request, $next) {
                  $this->user = Auth::user();
                  return $next($request);
            });
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
            $data = ['title' => 'Dashboard'];
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
