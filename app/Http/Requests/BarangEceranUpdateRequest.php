<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BarangEceranUpdateRequest extends FormRequest
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
        $sisa_stok = $this->input('sisa_stok');
        $rules = [
            "tambah_stok" => "required|numeric",
            "sisa_stok" => "required|numeric|min:" . (-$sisa_stok),
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'tambah_stok.required' => 'Jumlah stok grosir wajib diisi!',
            'tambah_stok.numeric' => 'Jumlah stok harus berupa angka.',
            'sisa_stok.required' => 'Sisa stok grosir tidak boleh kosong!',
            'sisa_stok.numeric' => 'Jumlah stok harus berupa angka.',
            'sisa_stok.min' => 'Sisa stok grosir tidak boleh negatif!',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar!');
        }
    }
}
