<?php

namespace App\Imports;

use App\Models\Satuan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SatuanImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use Importable, SkipsFailures;

    protected $customValidationMessages = [
        'nama_satuan.required' => 'Nama satuan harus diisi!',
        'nama_satuan.unique' => 'Nama satuan sudah ada dalam database!'
    ];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Satuan::create([
                'nama_satuan' => $row['nama_satuan'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama_satuan' => 'required|unique:satuan,nama_satuan'
        ];
    }

    public function customValidationMessages(): array
    {
        return $this->customValidationMessages;
    }
}
