<?php

namespace App\Imports;

use App\Models\Penyedia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VendorImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $customValidationMessages = [
        'nama.required' => 'Nama vendor harus diisi !',
        'alamat.required' => 'Alamat harus diisi!',
    ];
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Penyedia::create([
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
                'no_tlp' => $row['no_tlp'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'alamat' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
