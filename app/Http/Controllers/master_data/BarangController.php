<?php

namespace App\Http\Controllers\master_data;

use App\Models\Barang;
use App\Models\Satuan;
use App\Services\CrudService;
use App\Services\BarangService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarangRequest;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
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
        $route = $this->barangService->getDataIndex();
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
        return view('content.barang.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = $this->barangService->getDataCreate();
        $data = [
            'title' => $route['title'],
            'posisi' => $route['posisi'],
            'routeStore' => $route['routeStore'],
            'routeMain' => $route['routeMain'],
            'satuan' => Satuan::all(),
            'unit' => $route['unit'],
        ];
        return view('content.barang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarangRequest $request)
    {
        $route = $this->barangService->getDataStore();
        $request['harga_barang'] = convertToNumber($request->input('harga_barang'));
        $request['harga_jual'] = convertToNumber($request->input('harga_jual'));
        $request['nilai_saat_ini'] = convertToNumber($request->input('nilai_saat_ini'));
        $request['kode_barang'] = $this->barangService->getKodeBarang($request->input('id_unit'));
        $this->crudService->create($request, new Barang);
        alert()->success('Sukses', 'Berhasil menambah data ' . $request->input('posisi_pi'));
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
        $edit = $this->barangService->getEditData($id);
        $data = [
            'title' => $edit['title'],
            'routeMain' => $edit['routeMain'],
            'routeUpdate' => $edit['routeUpdate'],
            'satuan' => Satuan::all(),
            'unit' => $edit['unit'],
            'barang' => $this->barangService->getBarang($id)
        ];
        return view('content.barang.edit', $data);
    }

    public function update(BarangRequest $request, $id)
    {
        $route = $this->barangService->getDataUpdate();
        $request['harga_barang'] = convertToNumber($request->input('harga_barang'));
        $request['harga_jual'] = convertToNumber($request->input('harga_jual'));
        $request['nilai_saat_ini'] = convertToNumber($request->input('nilai_saat_ini'));
        $request['kode_barang'] = $this->barangService->getKodeBarangUpdate($id);
        $this->crudService->update($request, 'id_barang', $id, new Barang);
        alert()->success('Sukses', 'Berhasil mengubah data ' . $request->input('posisi_pi'));
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
        $posisi = $this->barangService->getDataDelete();
        $this->crudService->delete('id_barang', $id, new Barang);
        Alert::success('Sukses', 'Berhasil menghapus data ' . $posisi . '.');
        return redirect()->back();
    }
}
