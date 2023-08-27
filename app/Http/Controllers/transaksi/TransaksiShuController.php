<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiShuRequest;
use App\Services\ShuService;

class TransaksiShuController extends Controller
{
      protected $transaksiService;
      protected $shuService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->shuService = new ShuService;
      }

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
            $index = $this->shuService->getDataIndex();
            $data = [
                  'title' => 'Sisa Hasil Usaha',
                  'unit' => $index['unit'],
                  'tipe' => $index['tipe'],
                  'routeMaster' => $index['routeMaster'],
                  'routeTransaksi' => $index['routeTransaksi'],
                  'transaksi' => $this->transaksiService->getHistoryTransaction()
            ];
            return view('content.shu.main', $data);
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
      public function store(TransaksiShuRequest $request)
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
