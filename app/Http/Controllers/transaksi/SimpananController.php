<?php

namespace App\Http\Controllers\transaksi;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SimpananRequest;
use App\Services\SimpananService;

class SimpananController extends Controller
{
    protected $transaksiService;
    protected $simpananService;

    public function __construct()
    {
        $this->transaksiService = new TransaksiService;
        $this->simpananService = new SimpananService;
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
            'title' => 'Simpanan'
        ];

        return view('content.simpanan.transaksi-simpanan.main', $data);
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
    public function store(SimpananRequest $request)
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
