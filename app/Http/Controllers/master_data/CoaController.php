<?php

namespace App\Http\Controllers\master_data;

use App\Models\Coa;
use App\Services\CoaService;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Http\Requests\CoaRequest;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CoaController extends Controller
{
    protected $coaService;
    protected $crudService;

    public function __construct()
    {
        $this->coaService = new CoaService;
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
            'title' => 'Chart Of Account',
            'routeCreate' => route('mdu-coa.create'),
            'routeImport' => route('mdu-coa.form-import'),
            'routeExcel' => route('mdu-coa.export-excel'),
            'routePdf' => route('mdu-coa.export-pdf'),
            'coa' => Coa::all()
        ];
        $isi = $this->crudService->messageConfirmDelete('akun COA');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.coa.main', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah COA',
        ];
        return view('content.coa.create', $data);
    }

    public function store(CoaRequest $request)
    {
        $this->crudService->create($request, new Coa);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-coa');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit COA',
            'coa' => $this->coaService->getDataCoa($id)
        ];
        return view('content.coa.edit', $data);
    }

    public function update(CoaRequest $request, $id)
    {
        $this->crudService->update($request, 'id_coa', $id, new Coa);
        Alert::success('Sukses', 'Berhasil mengubah data COA.');
        return redirect()->route('mdu-coa');
    }

    public function destroy($id)
    {
        $this->crudService->delete('id_coa', $id, new Coa);
        Alert::success('Sukses', 'Berhasil menghapus data COA.');
        return redirect()->back();
    }
}
