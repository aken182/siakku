<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class ShuService
{
      public function getDataIndex()
      {
            $routeName = Route::currentRouteName();
            $data = [];
            switch ($routeName) {
                  case 'shu-unit-pertokoan':
                        $data['unit'] = 'Pertokoan';
                        $data['tipe'] = 'master';
                        $data['routeCreate'] = route('shu-unit-pertokoan.create');
                        $data['routeEdit'] = 'shu-unit-pertokoan.edit';
                        $data['routeDelete'] = 'shu-unit-pertokoan.destroy';
                        $data['routeMaster'] = route('shu-unit-pertokoan');
                        $data['routeTransaksi'] = route('shu-unit-pertokoan.transaksi');
                        break;
                  case 'shu-unit-sp':
                        $data['unit'] = 'Simpan Pinjam';
                        $data['tipe'] = 'master';
                        $data['routeCreate'] = route('shu-unit-sp.create');
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
                        $data['unit'] = 'Pertokoan';
                        $data['tipe'] = 'transaksi';
                        $data['routeMaster'] = route('shu-unit-pertokoan');
                        $data['routeTransaksi'] = route('shu-unit-pertokoan.transaksi');
                        break;
                  case 'shu-unit-sp.transaksi':
                        $data['unit'] = 'Simpan Pinjam';
                        $data['tipe'] = 'transaksi';
                        $data['routeMaster'] = route('shu-unit-sp');
                        $data['routeTransaksi'] = route('shu-unit-sp.transaksi');
                        break;
            }
            return $data;
      }
}
