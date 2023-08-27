<?php

namespace App\Http\Requests;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PengajuanPinjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
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

    public function messages()
    {
        return [
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
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
