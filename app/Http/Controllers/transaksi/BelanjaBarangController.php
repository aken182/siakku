<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BelanjaBarangRequest;
use App\Services\BelanjaBarangService;
use App\Services\TransaksiService;

class BelanjaBarangController extends Controller
{
      protected $transaksiService;
      protected $belanjaBarangService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->belanjaBarangService = new BelanjaBarangService;
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
      public function store(BelanjaBarangRequest $request)
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
