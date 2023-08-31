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
        $rules = [
            'nama_barang' => 'required',
            'id_satuan' => 'required',
            'jenis_barang' => 'required',
            'id_unit' => 'required',
        ];
        if ($this->input('posisi_pi') === "inventaris") {
            $rules['umur_ekonomis'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'nama_barang.required' => 'Field nama wajib diisi!',
            'id_satuan.required' => 'Field satuan wajib diisi!',
            'jenis_barang.required' => 'Field jenis wajib diisi!',
            'id_unit.required' => 'Field unit wajib diisi!',
            'umur_ekonomis.required_if' => 'Field umur ekonomis wajib diisi!'
        ];
    }


    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
