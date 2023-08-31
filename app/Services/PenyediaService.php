<?php

namespace App\Services;

use App\Models\Penyedia;
use Illuminate\Support\Facades\Route;

class PenyediaService
{
      public function getRouteIndex()
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-vendor':
                        $data = [
                              'routeCreate' => route('mdt-vendor.create'),
                              'routeImport' => route('mdt-vendor.form-import'),
                              'routeExportExcel' => route('mdt-vendor.export-excel'),
                              'routeExportPdf' => route('mdt-vendor.export-pdf'),
                              'routeEdit' => 'mdt-vendor.edit',
                              'routeDelete' => 'mdt-vendor.destroy',
                        ];
                        break;
                  case 'mds-vendor':
                        $data = [
                              'routeCreate' => route('mds-vendor.create'),
                              'routeImport' => route('mds-vendor.form-import'),
                              'routeExportExcel' => route('mds-vendor.export-excel'),
                              'routeExportPdf' => route('mds-vendor.export-pdf'),
                              'routeEdit' => 'mds-vendor.edit',
                              'routeDelete' => 'mds-vendor.destroy',
                        ];
                        break;
            }
            return $data;
      }

      public function getRouteCreate()
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-vendor.create':
                        $data = [
                              'store' => route('mdt-vendor.store'),
                              'main' => route('mdt-vendor')
                        ];
                        break;
                  case 'mds-vendor.create':
                        $data = [
                              'store' => route('mds-vendor.store'),
                              'main' => route('mds-vendor')
                        ];
                        break;
            }
            return $data;
      }

      public function getRouteEdit($id)
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-vendor.edit':
                        $data = [
                              'update' => route('mdt-vendor.update', $id),
                              'main' => route('mdt-vendor')
                        ];
                        break;
                  case 'mds-vendor.edit':
                        $data = [
                              'update' => route('mds-vendor.update', $id),
                              'main' => route('mds-vendor')
                        ];
                        break;
            }
            return $data;
      }

      public function getVendor($id)
      {
            return Penyedia::where('id_penyedia', $id)->first();
      }

      public function getRouteStore()
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-vendor.store':
                        $data = 'mdt-vendor';
                        break;
                  case 'mds-vendor.store':
                        $data = 'mds-vendor';
                        break;
            }
            return $data;
      }

      public function getRouteUpdate()
      {
            $route = Route::currentRouteName();
            switch ($route) {
                  case 'mdt-vendor.update':
                        $data = 'mdt-vendor';
                        break;
                  case 'mds-vendor.update':
                        $data = 'mds-vendor';
                        break;
            }
            return $data;
      }
}
