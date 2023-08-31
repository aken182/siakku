<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Services\ImageService;
use App\Services\AnggotaService;
use App\Services\ImportExportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AnggotaImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use Importable, SkipsFailures;

    private $anggotaService;
    private $importService;

    protected $customValidationMessages = [
        'nama.required' => 'Nama anggota harus diisi!',
        'nama.unique' => 'Nama anggota sudah ada dalam database!',
        'jenis_kelamin.required' => 'Jenis kelamin harus diisi!',
        'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan!',
        'status.required' => 'Status harus diisi!',
        'status.in' => 'Status harus Aktif atau Tidak Aktif!',
        'level.required' => 'Level harus diisi!',
        'level.in' => 'Level harus Anggota atau Karyawan!',
        'tgl_masuk.required' => 'Tanggal menjadi anggota harus diisi!'
    ];

    public function __construct()
    {
        $this->anggotaService = new AnggotaService(new ImageService);
        $this->importService = new ImportExportService;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Anggota::create([
                'kode' => $this->anggotaService->getKode(),
                'no_induk' => $row['no_induk'],
                'nama' => $row['nama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tgl_lahir' => $this->importService->getTanggalImport($row['tgl_lahir']),
                'jenis_kelamin' => $row['jenis_kelamin'],
                'pekerjaan' => $row['pekerjaan'],
                'tempat_tugas' => $row['tempat_tugas'],
                'status' => $row['status'],
                'level' => $row['level'],
                'tgl_masuk' => $this->importService->getTanggalImport($row['tgl_masuk']),
                'tgl_berhenti' => $this->importService->getTanggalImport($row['tgl_berhenti']),
                'alasan_berhenti' => $row['alasan_berhenti'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|unique:anggota,nama',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'level' => 'required|in:Anggota,Karyawan',
            'tgl_masuk' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
