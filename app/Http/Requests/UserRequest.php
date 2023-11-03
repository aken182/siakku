<?php

namespace App\Http\Requests;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
            'id_anggota' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'id_anggota.required' => 'Nama Harus Diisi !',
            'username.required' => 'Username Harus diisi !',
            'username.unique' => 'Username Sudah dipakai !',
            'password.required' => 'Password Harus diisi !',
            'password.min' => 'Password Minimal 6 Karakter !',
            'role.required' => 'Role Harus diisi !',
        ];
        return $messages;
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
