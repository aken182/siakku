<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\AccountingService;
use App\Http\Controllers\Controller;

class JurnalController extends Controller
{
      protected $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }
      public function index(Request $request)
      {
            $data = [
                  'title' => 'Jurnal Umum'
            ];

            return view('content.pendapatan.main', $data);
      }
}
