<?php

namespace App\Http\Controllers\master_data;

use DateTime;
use Illuminate\Http\Request;
use App\Services\CrudService;
use App\Services\ImageService;
use App\Services\AnggotaService;
use App\Services\PinjamanService;
use App\Models\Pengajuan_pinjaman;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanPinjamanRequest;

class PengajuanPinjamanController extends Controller
{
    protected $pinjamanService;
    protected $crudService;
    protected $anggotaService;

    public function __construct()
    {
        $this->pinjamanService = new PinjamanService;
        $this->crudService = new CrudService;
        $this->anggotaService = new AnggotaService(new ImageService);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'title' => 'Pengajuan Pinjaman',
            'routeCreate' => route('pp-pengajuan.create'),
            'routeImport' => route('pp-pengajuan.form-import'),
            'routeExcel' => route('pp-pengajuan.export-excel'),
            'routePdf' => route('pp-pengajuan.export-pdf'),
            'pengajuan' => Pengajuan_pinjaman::all()
        ];
        $isi = $this->crudService->messageConfirmDelete('pengajuan pinjaman');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.pinjaman.pengajuan.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => "Form Tambah Pengajuan",
            'anggota' => $this->anggotaService->getDataAnggotaToForm()
        ];

        return view('content.pinjaman.pengajuan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PengajuanPinjamanRequest $request)
    {
        $model = new Pengajuan_pinjaman;
        $request['kode'] = kode($model, 'PENG-', 'kode');
        $request['status'] = 'belum acc';
        $request['status_pencairan'] = 'konfirmasi';
        $this->pinjamanService->getConvertToNumberRequest($request);
        $this->crudService->create($request, $model);
        alert()->success('Sukses', 'Data pengajuan berhasil ditambahkan!');
        return redirect()->route('pp-pengajuan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'title' => 'Detil Pengajuan Pinjaman',
            'pengajuan' => $this->pinjamanService->getPengajuan($id),
        ];
        return view('content.pinjaman.pengajuan.show', $data);
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function konfirmasi(Request $request, $id)
    {
        $today = new DateTime();
        $request['tgl_acc'] = $today->format('Y-m-d');
        $this->crudService->update($request, 'id_pengajuan', $id, new Pengajuan_pinjaman);
        alert()->success('Sukses', 'Data pengajuan berhasil dikonfirmasi!');
        return redirect()->back();
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
            'title' => "Form Edit Pengajuan",
            'anggota' => $this->anggotaService->getDataAnggotaToForm(),
            'pengajuan' => $this->pinjamanService->getPengajuan($id),
        ];

        return view('content.pinjaman.pengajuan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PengajuanPinjamanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PengajuanPinjamanRequest $request, $id)
    {
        $this->pinjamanService->getConvertToNumberRequest($request);
        $this->crudService->update($request, 'id_pengajuan', $id, new Pengajuan_pinjaman);
        alert()->success('Sukses', 'Berhasil mengubah data pengajuan!');
        return redirect()->route('pp-pengajuan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->delete('id_pengajuan', $id, new Pengajuan_pinjaman);
        alert()->success('Sukses', 'Berhasil menghapus data pengajuan pinjaman!');
        return redirect()->back();
    }
}
