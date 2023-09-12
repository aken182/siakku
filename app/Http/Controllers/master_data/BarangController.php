<?php

namespace App\Http\Controllers\master_data;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Services\BarangService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarangRequest;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\dataTable\DataTableBarangService;

class BarangController extends Controller
{
    protected $barangService;
    protected $crudService;
    protected $dataTableService;
    private $route;

    public function __construct()
    {
        $this->barangService = new BarangService;
        $this->crudService = new CrudService;
        $this->dataTableService = new DataTableBarangService;
        $this->route = Route::currentRouteName();
    }

    public function index()
    {
        $route = $this->barangService->getDataIndex();
        $data = [
            'title' => $route['title'],
            'posisi' => $route['posisi'],
            'routeCreate' => $route['routeCreate'],
            'routeList' => $route['routeList'],
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
     * Mengambil datatable barang berdasarkan
     * request ajax
     *
     * @param \Illuminate\Http\Request $request
     **/
    public function dataTableBarang(Request $request)
    {
        if ($request->ajax()) {
            $route = $this->dataTableService->getRouteDataTable($this->route);
            $data = $this->barangService->getDataBarang($route['unit'], $route['posisi']);
            if ($route['posisi'] === 'persediaan') {
                $dataTables = $this->dataTableService->getDataTablePersediaan($data, $this->route);
            } else {
                $dataTables = $this->dataTableService->getDataTableInventaris($data, $this->route);
            }

            return $dataTables;
        }
    }

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

    public function store(BarangRequest $request)
    {
        $route = $this->barangService->getDataStore();
        if ($request->input('posisi_pi') === 'inventaris') {
            $request['nilai_saat_ini'] = convertToNumber($request->input('nilai_saat_ini'));
        }
        $request['harga_barang'] = convertToNumber($request->input('harga_barang'));
        $request['harga_jual'] = convertToNumber($request->input('harga_jual'));
        $request['kode_barang'] = $this->barangService->getKodeBarang($request->input('id_unit'));
        $this->crudService->create($request, new Barang);
        alert()->success('Sukses', 'Berhasil menambah data ' . $request->input('posisi_pi'));
        return redirect()->route($route);
    }

    public function show($id)
    {
        //
    }

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
        if ($request->input('posisi_pi') === 'inventaris') {
            $request['nilai_saat_ini'] = convertToNumber($request->input('nilai_saat_ini'));
        }
        $request['harga_barang'] = convertToNumber($request->input('harga_barang'));
        $request['harga_jual'] = convertToNumber($request->input('harga_jual'));
        $request['kode_barang'] = $this->barangService->getKodeBarangUpdate($id);
        $this->crudService->update($request, 'id_barang', $id, new Barang);
        alert()->success('Sukses', 'Berhasil mengubah data ' . $request->input('posisi_pi'));
        return redirect()->route($route);
    }

    public function destroy($id)
    {
        $posisi = $this->barangService->getDataDelete();
        $this->crudService->delete('id_barang', $id, new Barang);
        Alert::success('Sukses', 'Berhasil menghapus data ' . $posisi . '.');
        return redirect()->back();
    }
}
