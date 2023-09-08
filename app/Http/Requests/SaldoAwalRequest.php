<?php

namespace App\Http\Requests;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SaldoAwalRequest extends FormRequest
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
            'tgl_transaksi' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tgl_transaksi.required' => 'Tanggal mulai menggunakan aplikasi wajib diisi!'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar!');
        }
    }
}
