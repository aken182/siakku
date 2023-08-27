<?php

namespace App\Http\Controllers\master_data;

use App\Models\Unit;
use App\Services\CrudService;
use App\Services\UnitService;
use App\Http\Requests\UnitRequest;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class UnitController extends Controller
{
    protected $unitService;
    protected $crudService;

    public function __construct()
    {
        $this->unitService = new UnitService;
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
            'title' => 'Unit',
            'routeCreate' => route('mdu-unit.create'),
            'routeImport' => route('mdu-unit.create'),
            'routeExcel' => route('mdu-unit.create'),
            'routePdf' => route('mdu-unit.create'),
            'unit' => Unit::all(),
        ];
        $isi = $this->crudService->messageConfirmDelete('Unit');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.unit.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Unit',
        ];
        return view('content.unit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $this->crudService->create($request, new Unit);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-unit');
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
            'title' => 'Form Edit Unit',
            'unit' => $this->unitService->getDataUnit($id),
        ];
        return view('content.unit.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UnitRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        $this->crudService->update($request, 'id_unit', $id, new Unit);
        Alert::success('Sukses', 'Berhasil mengubah data unit.');
        return redirect()->route('mdu-unit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_unit', $id, new Unit);
        Alert::success('Sukses', 'Berhasil menghapus data unit.');
        return redirect()->back();
    }
}
