<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PengajuanImport implements ToCollection
{

    protected $customValidationMessages = [
        'id_anggota.required' => 'Data anggota tidak boleh kosong !',
        'gaji_perbulan.required' => 'Gaji perbulan tidak boleh kosong !',
        'potongan_perbulan.required' => 'Potongan rutin perbulan tidak boleh kosong !',
        'cicilan_perbulan.required' => 'Cicilan lain perbulan tidak boleh kosong !',
        'biaya_perbulan.required' => 'Biaya hidup perbulan tidak boleh kosong !',
        'sisa_penghasilan.required' => 'Sisa penghasilan perbulan tidak boleh kosong !',
        'perkiraan.required' => 'Persentase perkiraan cicilan tidak boleh kosong !',
        'kemampuan_bayar.required' => 'Kemampuan bayar perbulan tidak boleh kosong !',
        'jumlah_pinjaman.required' => 'Jumlah pengajuan pinjaman tidak boleh kosong !',
        'jangka_waktu.required' => 'Jangka waktu tidak boleh kosong !',
        'bunga.required' => 'Bunga perbulan tidak boleh kosong !',
        'kapitalisasi.required' => 'Kapitalisasi tidak boleh kosong !',
        'asuransi.required' => 'Asuransi tidak boleh kosong !',
        'angsuran_bunga.required' => 'Angsuran bunga perbulan tidak boleh kosong !',
        'angsuran_pokok.required' => 'Angsuran pokok perbulan tidak boleh kosong !',
        'total_angsuran.required' => 'Total angsuran perbulan tidak boleh kosong !',
        'total_pinjaman.required' => 'Total penerimaan pinjaman tidak boleh kosong !',
    ];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $c) {
        }
    }

    public function rules(): array
    {
        return [
            'id_anggota' => 'required',
            'gaji_perbulan' => 'required',
            'potongan_perbulan' => 'required',
            'cicilan_perbulan' => 'required',
            'biaya_perbulan' => 'required',
            'sisa_penghasilan' => 'required',
            'perkiraan' => 'required',
            'kemampuan_bayar' => 'required',
            'jumlah_pinjaman' => 'required',
            'jangka_waktu' => 'required',
            'bunga' => 'required',
            'kapitalisasi' => 'required',
            'asuransi' => 'required',
            'angsuran_bunga' => 'required',
            'angsuran_pokok' => 'required',
            'total_angsuran' => 'required',
            'total_pinjaman' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
