<?php

namespace App\Http\Controllers\master_data;

use App\Models\Berita;
use App\Services\CrudService;
use App\Services\ImageService;
use App\Services\BeritaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use RealRashid\SweetAlert\Facades\Alert;

class BeritaController extends Controller
{
    protected $beritaService;
    protected $crudService;

    public function __construct()
    {
        $this->beritaService = new BeritaService(new ImageService);
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
            'title' => 'Berita',
            'routeCreate' => route('mdu-berita.create'),
            'routeImport' => route('mdu-berita.create'),
            'routeExcel' => route('mdu-berita.create'),
            'routePdf' => route('mdu-berita.create'),
            'berita' => Berita::all(),
        ];
        return view('content.berita.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Berita',
        ];
        return view('content.berita.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BeritaRequest $request)
    {
        $request['slug_berita'] = $this->beritaService->generateSlug($request->input('judul_berita'));
        $this->beritaService->addGambarBerita($request, 'BRTI');
        $this->crudService->create($request, new Berita);
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-berita');
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
            'title' => 'Form Edit Berita',
            'berita' => $this->beritaService->getDataBerita($id)
        ];
        return view('content.berita.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\BeritaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BeritaRequest $request, $id)
    {
        $request['slug_berita'] = $this->beritaService->updateSlug($request->input('judul_berita'), $request->input('slug'), $id);
        $this->beritaService->updateGambarBerita($request, $id, 'BRTI');
        $this->crudService->update($request, 'id_berita', $id, new Berita);
        Alert::success('Sukses', 'Berhasil mengubah data berita.');
        return redirect()->route('mdu-berita');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->beritaService->deleteGambarBerita($id);
        $this->crudService->delete('id_berita', $id, new Berita);
        Alert::success('Sukses', 'Berhasil menghapus data berita.');
        return redirect()->back();
    }
}
