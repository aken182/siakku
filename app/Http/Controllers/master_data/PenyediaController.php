<?php

namespace App\Http\Controllers\master_data;

use App\Models\Penyedia;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Services\PenyediaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PenyediaRequest;

class PenyediaController extends Controller
{
    protected $penyediaService;
    protected $crudService;

    public function __construct()
    {
        $this->penyediaService = new PenyediaService;
        $this->crudService = new CrudService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->penyediaService->getRouteIndex();
        $data = [
            'title' => 'Vendor',
            'routeCreate' => $route['routeCreate'],
            'routeEdit' => $route['routeEdit'],
            'routeDelete' => $route['routeDelete'],
            'routeImport' => $route['routeImport'],
            'routeExcel' => $route['routeExportExcel'],
            'routePdf' => $route['routeExportPdf'],
            'vendor' => Penyedia::all()
        ];
        $isi = $this->crudService->messageConfirmDelete('Vendor');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.penyedia.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = $this->penyediaService->getRouteCreate();
        $data = [
            'title' => 'Form Tambah Vendor',
            'routeStore' => $route['store'],
            'routeMain' => $route['main'],
        ];
        return view('content.penyedia.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenyediaRequest $request)
    {
        $route = $this->penyediaService->getRouteStore();
        $this->crudService->create($request, new Penyedia);
        alert()->success('Sukses', 'Data vendor berhasil ditambahkan!');
        return redirect()->route($route);
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
        $route = $this->penyediaService->getRouteEdit($id);
        $data = [
            'title' => 'Form Edit Vendor',
            'routeUpdate' => $route['update'],
            'routeMain' => $route['main'],
            'vendor' => $this->penyediaService->getVendor($id)
        ];
        return view('content.penyedia.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PenyediaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PenyediaRequest $request, $id)
    {
        $route = $this->penyediaService->getRouteUpdate();
        $this->crudService->update($request, 'id_penyedia', $id, new Penyedia);
        alert()->success('Sukses', 'Berhasil mengubah data vendor.');
        return redirect()->route($route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_penyedia', $id, new Penyedia);
        alert()->success('Sukses', 'Berhasil menghapus data vendor.');
        return redirect()->back();
    }
}
