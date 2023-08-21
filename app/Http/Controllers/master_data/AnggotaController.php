<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnggotaRequest;
use App\Services\AnggotaService;
use App\Services\ImageService;
use RealRashid\SweetAlert\Facades\Alert;

class AnggotaController extends Controller
{
    protected $anggotaService;
    protected $imageService;

    public function __construct()
    {
        $this->anggotaService = new AnggotaService;
        $this->imageService = new ImageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'title' => 'Anggota',
            'routeCreate' => route('mdu-anggota.create'),
            'routeImport' => route('mdu-anggota.create'),
            'routeExcel' => route('mdu-anggota.create'),
            'routePdf' => route('mdu-anggota.create'),
            'anggota' => $this->anggotaService->getDataAnggotaView(),
        ];
        return view('content.anggota.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Anggota',
            'kode' => $this->anggotaService->getKode()
        ];
        return view('content.anggota.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnggotaRequest $request)
    {
        $this->anggotaService->create($request);
        if ($request->file('pas_foto') != null) {
            $imageName = $this->imageService->getImageName('Foto', $request->input('kode'), $request->file('pas_foto'));
            $this->imageService->uploadImage($request->file('pas_foto'), $imageName, 'foto-anggota');
        }
        Alert::success('Sukses', 'Data berhasil ditambahkan!');
        return redirect()->route('mdu-anggota');
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
        //
    }

    public function update(AnggotaRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
