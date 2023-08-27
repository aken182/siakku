<?php

namespace App\Http\Controllers\master_data;

use App\Models\Simpanan;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Services\SimpananService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\MasterSimpananRequest;

class MasterSimpananController extends Controller
{
    protected $simpananService;
    protected $crudService;

    public function __construct()
    {
        $this->simpananService = new SimpananService;
        $this->crudService = new CrudService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Master Simpanan',
            'routeCreate' => route('mds-simpanan.create'),
            'routeImport' => route('mds-simpanan.create'),
            'routeExcel' => route('mds-simpanan.create'),
            'routePdf' => route('mds-simpanan.create'),
            'simpanan' => Simpanan::all(),
        ];
        $isi = $this->crudService->messageConfirmDelete('simpanan');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.simpanan.master.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Jenis Simpanan'
        ];
        return view('content.simpanan.master.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterSimpananRequest $request)
    {
        $request['jumlah'] = convertToNumber($request->input('jumlah'));
        $this->crudService->create($request, new Simpanan);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mds-simpanan');
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
        $data = [
            'title' => 'Form Edit Jenis Simpanan',
            'simpanan' => $this->simpananService->getSimpanan($id),
        ];
        return view('content.simpanan.master.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MasterSimpananRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterSimpananRequest $request, $id)
    {
        $request['jumlah'] = convertToNumber($request->input('jumlah'));
        $this->crudService->update($request, 'id_simpanan', $id, new Simpanan);
        Alert::success('Sukses', 'Berhasil mengubah data simpanan.');
        return redirect()->route('mds-simpanan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_simpanan', $id, new Simpanan);
        Alert::success('Sukses', 'Berhasil menghapus data simpanan.');
        return redirect()->back();
    }
}
