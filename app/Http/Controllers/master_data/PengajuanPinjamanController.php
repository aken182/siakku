<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Services\PinjamanService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanPinjamanRequest;

class PengajuanPinjamanController extends Controller
{
    protected $pinjamanService;

    public function __construct()
    {
        $this->pinjamanService = new PinjamanService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = ['title' => 'Pengajuan Pinjaman'];
        return view('content.barang-eceran.main', $data);
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
    public function store(PengajuanPinjamanRequest $request)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PengajuanPinjamanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PengajuanPinjamanRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
