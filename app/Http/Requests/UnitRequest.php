<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UnitRequest extends FormRequest
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
            'nama' => 'required',
            'unit' => 'required',
        ];
        $route = Route::currentRouteName();
        if ($route === 'mdu-unit.store') {
            $rules['kode_unit'] = 'required|unique:unit,kode_unit';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'kode_unit.required_if' => 'Kode tidak boleh kosong!',
            'kode_unit.unique_if' => 'Kode harus unik dan belum terdaftar!',
            'nama.required' => 'Nama TPK tidak boleh kosong!',
            'unit.required' => 'Unit induk tidak boleh kosong!',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
