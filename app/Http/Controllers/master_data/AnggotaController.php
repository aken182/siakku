<?php

namespace App\Http\Controllers\master_data;

use App\DataTables\AnggotaDataTable;
use App\Services\AnggotaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnggotaRequest;
use App\Models\Anggota;
use App\Services\CrudService;
use App\Services\ImageService;
use RealRashid\SweetAlert\Facades\Alert;

class AnggotaController extends Controller
{
    protected $anggotaService;
    protected $crudService;

    public function __construct()
    {
        $this->anggotaService = new AnggotaService(new ImageService);
        $this->crudService = new CrudService;
    }

    /**
     * Menampilkan data anggota menggunakan
     * yajra datatable
     *
     * @param \App\DataTables\AnggotaDataTable $dataTable
     * @return mixed
     **/
    public function index(AnggotaDataTable $dataTable)
    {
        $isi = $this->crudService->messageConfirmDelete('Anggota');
        confirmDelete($isi['title'], $isi['text']);
        return $dataTable->render('content.anggota.main');
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Anggota',
        ];
        return view('content.anggota.create', $data);
    }

    public function store(AnggotaRequest $request)
    {
        $request['kode'] = $this->anggotaService->getKode();
        $this->anggotaService->addPasFoto($request);
        $this->crudService->create($request, new Anggota);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-anggota');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Edit Anggota',
            'anggota' => $this->anggotaService->getDataAnggota($id)
        ];
        return view('content.anggota.edit', $data);
    }

    public function update(AnggotaRequest $request, $id)
    {
        $this->anggotaService->updatePasFoto($request, $id);
        $this->crudService->update($request, 'id_anggota', $id, new Anggota);
        Alert::success('Sukses', 'Berhasil mengubah data anggota.');
        return redirect()->route('mdu-anggota');
    }

    public function destroy($id)
    {
        $this->anggotaService->deletePasFoto($id);
        $this->crudService->delete('id_anggota', $id, new Anggota);
        Alert::success('Sukses', 'Berhasil menghapus data anggota.');
        return redirect()->back();
    }
}
