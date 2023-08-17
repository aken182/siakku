<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BelanjaRequest;
use App\Services\BelanjaService;

class BelanjaController extends Controller
{
      protected $transaksiService;
      protected $belanjaService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->belanjaService = new BelanjaService;
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $data = [
                  'transaksi' => $this->transaksiService->getHistoryTransaction()
            ];
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
      public function store(BelanjaRequest $request)
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
