<?php

namespace App\Imports;

use App\Models\Simpanan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterSimpananImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $customValidationMessages = [
        'nama.required' => 'Nama simpanan harus diisi!',
        'nama.unique' => 'Simpanan sudah ada dalam database!',
        'jumlah.required' => 'Jumlah harus diisi!',
    ];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $c) {
            Simpanan::create([
                'nama' => $c['nama'],
                'jumlah' => $c['jumlah'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|unique:simpanan,nama',
            'jumlah' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
