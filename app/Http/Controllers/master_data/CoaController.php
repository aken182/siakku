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
            'routeCreate' => route('coa-master.create'),
            'routeImport' => route('coa-master.create'),
            'routeExcel' => route('coa-master.create'),
            'routePdf' => route('coa-master.create'),
            'coa' => Coa::all()
        ];
        $isi = $this->crudService->messageConfirmDelete('akun COA');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.coa.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah COA',
        ];
        return view('content.coa.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoaRequest $request)
    {
        $this->crudService->create($request, new Coa);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('coa-master');
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
            'title' => 'Form Edit COA',
            'coa' => $this->coaService->getDataCoa($id)
        ];
        return view('content.coa.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CoaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoaRequest $request, $id)
    {
        $this->crudService->update($request, 'id_coa', $id, new Coa);
        Alert::success('Sukses', 'Berhasil mengubah data COA.');
        return redirect()->route('coa-master');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_coa', $id, new Coa);
        Alert::success('Sukses', 'Berhasil menghapus data COA.');
        return redirect()->back();
    }
}
