<?php

namespace App\Imports;

use App\Models\Shu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ShuImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $customValidationMessages = [
        'nama.required' => 'Nama shu harus diisi!',
        'persen.required' => 'persentase shu harus diisi!',
        'unit.required' => 'Unit harus diisi!',
        'unit.in' => 'Unit harus Pertokoan atau Simpan Pinjam!',
    ];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $c) {
            Shu::create([
                'nama' => $c['nama'],
                'persen' => $c['persen'],
                'nilai_bagi' => 0,
                'unit' => $c['unit'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'persen' => 'required',
            'unit' => 'required|in:Pertokoan,Simpan Pinjam',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
