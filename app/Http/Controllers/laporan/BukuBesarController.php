<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AccountingService;

class BukuBesarController extends Controller
{
      protected $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }

      public function index(Request $request)
      {
            $data = [
                  'title' => 'Buku Besar'
            ];

            return view('content.pendapatan.main', $data);
      }
}
