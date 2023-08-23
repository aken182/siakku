<?php

namespace App\Http\Requests;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SatuanRequest extends FormRequest
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
            'nama_satuan' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'nama_satuan.required' => 'Nama satuan tidak boleh kosong.'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
