<?php

namespace App\Imports;

use App\Models\Coa;
use App\Services\CoaService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoaImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $customValidationMessages = [
        'kode.required' => 'Kode akun wajib diisi!',
        'kode.unique' => 'Kode akun sudah ada dalam database!',
        'nama.required' => 'Nama akun wajib diisi!',
        'kategori.required' => 'Kategori akun wajib diisi!',
        'header.required' => 'Header akun wajib diisi!',
        'header.in' => 'Header akun harus salah satu dari 1,2,3,4,5 atau 8!',
    ];

    private $coaService;

    public function __construct()
    {
        $this->coaService = new CoaService;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->coaService->createCoa($row);
        }
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|unique:coa,kode',
            'nama' => 'required',
            'kategori' => 'required',
            'header' => 'required|in:1,2,3,4,5,8',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
