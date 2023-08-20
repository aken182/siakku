<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferSaldoRequest;
use App\Services\TransferSaldoService;

class TransferSaldoController extends Controller
{
      protected $transaksiService;
      protected $transferSaldoService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->transferSaldoService = new TransferSaldoService;
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $data = [
                  'transaksi' => $this->transaksiService->getHistoryTransaction(),
                  'title' => 'Transfer Saldo Kas & Bank'
            ];

            return view('content.transfer-saldo.main', $data);
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
            //
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(TransferSaldoRequest $request)
      {
            //
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show($id)
      {
            //
      }
}
