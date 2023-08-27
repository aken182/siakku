<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BarangRequest extends FormRequest
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
            'nama_barang' => 'required',
            'id_satuan' => 'required',
            'jenis_barang' => 'required',
            'id_unit' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_barang.required' => 'Field Nama wajib diisi!',
            'id_satuan.required' => 'Field Satuan wajib diisi!',
            'jenis_barang.required' => 'Field Jenis wajib diisi!',
            'id_unit.required' => 'Field Unit wajib diisi!'
        ];
    }


    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
