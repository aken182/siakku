<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BarangEceranRequest extends FormRequest
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
        $rules = [
            'id_barang' => 'required',
            'id_satuan' => 'required',
            'standar_nilai' => 'required',
            'jumlah_konversi' => 'required',
            'stok_konversi' => 'required',
            'sisa_stok' => 'required',
            'harga_barang_konversi' => 'required',
            'harga_jual_konversi' => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'id_barang.required' => 'Nama barang wajib diisi !',
            'id_satuan.required' => 'Satuan eceran wajib diisi!',
            'standar_nilai.required' => 'Nilai standar stok eceran wajib diisi !',
            'jumlah_konversi.required' => 'Jumlah stok grosir yang ingin dikonversi wajib diisi !',
            'stok_konversi.required' => 'Stok eceran wajib diisi !',
            'sisa_stok.required' => 'Sisa stok grosir wajib diisi !',
            'harga_barang_konversi.required' => 'Harga barang konversi wajib diisi !',
            'harga_jual_konversi.required' => 'Harga jual konversi wajib diisi !'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
