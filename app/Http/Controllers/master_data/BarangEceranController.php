<?php

namespace App\Http\Controllers\master_data;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Services\BarangService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarangEceranRequest;
use App\Http\Requests\BarangEceranUpdateRequest;

class BarangEceranController extends Controller
{
    protected $barangService;
    protected $crudService;

    public function __construct()
    {
        $this->barangService = new BarangService;
        $this->crudService = new CrudService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->barangService->getDataIndexEceran();
        $data = [
            'title' => $route['title'],
            'posisi' => $route['posisi'],
            'routeCreate' => $route['routeCreate'],
            'routeEdit' => $route['routeEdit'],
            'routeDelete' => $route['routeDelete'],
            'routeImport' => $route['routeImport'],
            'routeExcel' => $route['routeExportExcel'],
            'routePdf' => $route['routeExportPdf'],
            'barang' => $route['barang']
        ];
        $isi = $this->crudService->messageConfirmDelete($route['posisi']);
        confirmDelete($isi['title'], $isi['text']);
        return view('content.barang-eceran.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = $this->barangService->getDataCreateEceran();
        $data = [
            'title' => $route['title'],
            'posisi' => $route['posisi'],
            'routeStore' => $route['routeStore'],
            'routeMain' => $route['routeMain'],
            'satuan' => Satuan::all(),
            'barang' => $this->barangService->getDataBarangToConvert($route['posisi']),
        ];
        return view('content.barang-eceran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarangEceranRequest $request)
    {
        $data = $this->barangService->getDataStoreEceran();
        $this->barangService->updateBarang($request->input('id_barang'), $request->input('sisa_stok'));
        $this->barangService->storeEceran($request);
        alert()->success('Sukses', 'Berhasil menambah data ' . $data['posisi']);
        return redirect()->route($data['route']);
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
        $edit = $this->barangService->getEditDataEceran($id);
        $data = [
            'title' => $edit['title'],
            'routeMain' => $edit['routeMain'],
            'routeUpdate' => $edit['routeUpdate'],
            'barang' => $this->barangService->getBarangEceran($id)
        ];
        return view('content.barang-eceran.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\BarangEceranRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BarangEceranUpdateRequest $request, $id)
    {
        $data = $this->barangService->getDataUpdateEceran();
        $this->barangService->updateBarangEceran($request, $id);
        alert()->success('Sukses', 'Berhasil mengubah data ' . $data['posisi']);
        return redirect()->route($data['route']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posisi = $this->barangService->getDataDeleteEceran();
        $this->barangService->deleteEceran($id);
        alert()->success('Sukses', 'Berhasil menghapus data ' . $posisi . '.');
        return redirect()->back();
    }
}
