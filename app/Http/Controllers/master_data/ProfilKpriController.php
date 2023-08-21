<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Services\ProfilKpriService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilKpriController extends Controller
{
    protected $profilKpriService;

    public function __construct()
    {
        $this->profilKpriService = new ProfilKpriService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->getData();
        return view('content.profil-kpri.main', $data);
    }

    public function getData()
    {
        $data = [
            'title' => 'Profil Koperasi',
            'profil' => $this->profilKpriService->getAllData(1)
        ];
        return $data;
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Koperasi',
            'profil' => $this->profilKpriService->getAllData($id)
        ];
        return view('content.profil-kpri.edit', $data);
        //
    }

    public function update(Request $request, $id)
    {
        $this->profilKpriService->update($id, $request);
        Alert::success('Sukses', 'Berhasil menyimpan perubahan data!');
        return redirect()->route('profil-koperasi');
    }
}
