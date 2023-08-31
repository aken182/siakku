<?php

namespace App\Http\Controllers\master_data;

use App\Models\Jabatan;
use App\Services\CrudService;
use App\Services\ImageService;
use App\Services\AnggotaService;
use App\Services\JabatanService;
use App\Http\Controllers\Controller;
use App\Http\Requests\JabatanRequest;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    protected $jabatanService;
    protected $anggotaService;
    protected $crudService;

    public function __construct()
    {
        $this->jabatanService = new JabatanService;
        $this->anggotaService = new AnggotaService(new ImageService);
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
            'title' => 'Jabatan',
            'routeCreate' => route('mdu-jabatan.create'),
            'routeExcel' => route('mdu-jabatan.export-excel'),
            'routePdf' => route('mdu-jabatan.export-pdf'),
            'jabatan' => Jabatan::all(),
        ];
        $isi = $this->crudService->messageConfirmDelete('Jabatan');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.anggota.main-jabatan', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Jabatan',
            'anggota' => $this->anggotaService->getDataAnggotaToForm()
        ];
        return view('content.anggota.create-jabatan', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JabatanRequest $request)
    {

        $this->crudService->create($request, new Jabatan);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-jabatan');
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
            'title' => 'Form Edit Jabatan',
            'jabatan' => $this->jabatanService->getDataJabatan($id),
            'anggota' => $this->anggotaService->getDataAnggotaToForm()
        ];
        return view('content.anggota.edit-jabatan', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\JabatanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JabatanRequest $request, $id)
    {
        $this->crudService->update($request, 'id_jabatan', $id, new Jabatan);
        Alert::success('Sukses', 'Berhasil mengubah data jabatan.');
        return redirect()->route('mdu-jabatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_jabatan', $id, new Jabatan);
        Alert::success('Sukses', 'Berhasil menghapus data jabatan.');
        return redirect()->back();
    }
}
