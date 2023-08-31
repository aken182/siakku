<?php

namespace App\Http\Controllers\master_data;

use App\Models\Satuan;
use App\Services\CrudService;
use App\Services\SatuanService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SatuanRequest;
use RealRashid\SweetAlert\Facades\Alert;

class SatuanController extends Controller
{
    protected $satuanService;
    protected $crudService;

    public function __construct()
    {
        $this->satuanService = new SatuanService;
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
            'title' => 'Satuan',
            'routeCreate' => route('mdu-satuan.create'),
            'routeImport' => route('mdu-satuan.form-import'),
            'routeExcel' => route('mdu-satuan.export-excel'),
            'routePdf' => route('mdu-satuan.export-pdf'),
            'satuan' => Satuan::all(),
        ];
        $isi = $this->crudService->messageConfirmDelete('Satuan');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.satuan.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Satuan',
        ];
        return view('content.satuan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SatuanRequest $request)
    {

        $this->crudService->create($request, new Satuan);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-satuan');
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
            'title' => 'Form Edit Satuan',
            'satuan' => $this->satuanService->getDataSatuan($id),
        ];
        return view('content.satuan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SatuanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SatuanRequest $request, $id)
    {
        $this->crudService->update($request, 'id_satuan', $id, new Satuan);
        Alert::success('Sukses', 'Berhasil mengubah data satuan.');
        return redirect()->route('mdu-satuan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_satuan', $id, new Satuan);
        Alert::success('Sukses', 'Berhasil menghapus data satuan.');
        return redirect()->back();
    }
}
