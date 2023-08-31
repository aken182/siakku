<?php

namespace App\Imports;

use App\Models\Berita;
use App\Services\BeritaService;
use App\Services\ImportExportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BeritaImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private $importService;
    private $beritaService;

    protected $customValidationMessages = [
        'tgl_berita.required' => 'Tanggal berita harus diisi!',
        'judul_berita.required' => 'Judul berita harus diisi!',
        'judul_berita.unique' => 'Judul berita sudah ada dalam database!',
        'isi_berita.required' => 'Isi berita harus diisi!',
        'penulis.required' => 'Penulis harus diisi!',
        'gambar_berita.required' => 'Gambar berita harus diisi!',
    ];

    public function __construct()
    {
        $this->importService = new ImportExportService;
        $this->beritaService = new BeritaService;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Berita::create([
                'judul_berita' => $row['judul_berita'],
                'slug_berita' => $this->beritaService->generateSlug($row['judul_berita']),
                'isi_berita' => $row['isi_berita'],
                'penulis' => $row['penulis'],
                'gambar_berita' => $row['gambar_berita'],
                'tgl_berita' => $this->importService->getTanggalImport($row['tgl_berita']),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'tgl_berita' => 'required',
            'judul_berita' => 'required|unique:berita,judul_berita',
            'isi_berita' => 'required',
            'penulis' => 'required',
            'gambar_berita' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
