<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PelunasanRequest;
use App\Services\PelunasanService;

class PelunasanController extends Controller
{
      protected $transaksiService;
      protected $pelunasanService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->pelunasanService = new PelunasanService;
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
                  'title' => 'Pelunasan'
            ];

            return view('content.pelunasan.main', $data);
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
      public function store(PelunasanRequest $request)
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
