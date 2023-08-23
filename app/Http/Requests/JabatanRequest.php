<?php

namespace App\Http\Requests;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class JabatanRequest extends FormRequest
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
            'jabatan' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_anggota.required' => 'Nama anggota tidak boleh kosong!',
            'jabatan.required' => 'Jabatan tidak boleh kosong!',
            'status.required' => 'Status tidak boleh kosong!',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
