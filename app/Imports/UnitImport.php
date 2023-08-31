<?php

namespace App\Imports;

use App\Models\Unit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UnitImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use Importable, SkipsFailures;

    protected $customValidationMessages = [
        'nama.required' => 'Nama TPK harus diisi!',
        'unit.required' => 'Unit harus diisi!',
        'unit.in' => 'Unit harus Pertokoan atau Simpan Pinjam!',
        'kode_unit.required' => 'Kode unit harus diisi!',
        'kode_unit.unique' => 'Kode unit sudah ada dalam database!'
    ];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Unit::create([
                'nama'    => $row['nama'],
                'unit'    => $row['unit'],
                'kode_unit'    => $row['kode_unit']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'unit' => 'required|in:Pertokoan,Simpan Pinjam',
            'kode_unit' => 'required|unique:unit,kode_unit'
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
