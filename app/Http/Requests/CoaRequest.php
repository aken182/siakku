<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CoaRequest extends FormRequest
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
            'header' => 'required',
            'kategori' => 'required',
            'nama' => 'required|max:150',
        ];
        $route = Route::currentRouteName();
        if ($route === 'coa-master.store') {
            $rules['kode'] = 'required|unique:coa,kode';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'header.required' => 'Header akun wajib diisi!',
            'kategori.required' => 'Kategori akun wajib diisi!',
            'kode.required_if' => 'Kode akun wajib diisi!',
            'kode.unique_if' => 'Kode akun harus unik!',
            'nama.required' => 'Nama akun wajib diisi!',
            'nama.max' => 'Panjang maksimal nama akun harus 150 karakter!'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
