<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Services\AccountingService;
use App\Http\Controllers\Controller;

class LabaRugiController extends Controller
{

      protected $accountingService;

      public function __construct()
      {
            $this->accountingService = new AccountingService;
      }

      public function index(Request $request)
      {
            //
      }
}