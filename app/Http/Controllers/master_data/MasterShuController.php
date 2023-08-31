<?php

namespace App\Http\Controllers\master_data;

use App\Services\ShuService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterShuRequest;
use App\Models\Shu;
use App\Services\CrudService;

class MasterShuController extends Controller
{
    protected $shuService;
    protected $crudService;

    public function __construct()
    {
        $this->shuService = new ShuService;
        $this->crudService = new CrudService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->shuService->getDataIndex();
        $data = [
            'title' => 'Sisa Hasil Usaha',
            'unit' => $route['unit'],
            'tipe' => $route['tipe'],
            'routeCreate' => $route['routeCreate'],
            'routeImport' => $route['routeImport'],
            'routeEdit' => $route['routeEdit'],
            'routeDelete' => $route['routeDelete'],
            'routeMaster' => $route['routeMaster'],
            'routeTransaksi' => $route['routeTransaksi'],
            'shu' => Shu::where('unit', $route['unit'])->get()
        ];
        $isi = $this->crudService->messageConfirmDelete('SHU');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.shu.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = $this->shuService->getDataIndex();
        $data = [
            'title' => 'Tambah SHU ' . $route['unit'],
            'unit' => $route['unit'],
            'routeStore' => $route['routeStore'],
            'routeMaster' => $route['routeMaster'],
        ];

        return view('content.shu.master.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterShuRequest $request)
    {
        // dd($request->all());
        $route = $this->shuService->getDataIndex();
        $this->crudService->create($request, new Shu);
        alert()->success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route($route['routeMaster']);
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

        $route = $this->shuService->getDataIndex();
        $data = [
            'title' => 'Edit SHU ' . $route['unit'],
            'unit' => $route['unit'],
            'routeUpdate' => $route['routeUpdate'],
            'routeMaster' => $route['routeMaster'],
            'shu' => Shu::where('id_shu', $id)->first()
        ];

        return view('content.shu.master.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MasterShuRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterShuRequest $request, $id)
    {
        $route = $this->shuService->getDataIndex();
        $this->crudService->update($request, 'id_shu', $id, new Shu);
        alert()->success('Sukses', 'Berhasil mengubah data SHU !');
        return redirect()->route($route['routeMaster']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_shu', $id, new Shu);
        alert()->success('Sukses', 'Berhasil menghapus data shu!');
        return redirect()->back();
    }
}
