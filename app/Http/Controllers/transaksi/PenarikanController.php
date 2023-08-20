<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PenarikanRequest;
use App\Services\PenarikanService;

class PenarikanController extends Controller
{
      protected $transaksiService;
      protected $penarikanService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->penarikanService = new PenarikanService;
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
                  'title' => 'Penarikan Simpanan'
            ];

            return view('content.simpanan.main', $data);
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
      public function store(PenarikanRequest $request)
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
