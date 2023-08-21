<?php

namespace App\Http\Requests;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AnggotaRequest extends FormRequest
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
            'kode' => 'required|unique:anggota,kode',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'pekerjaan' => 'required',
            'tempat_tugas' => 'required',
            'status' => 'required',
            'level' => 'required',
            'tgl_masuk' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode anggota tidak boleh kosong!',
            'kode.unique' => 'Kode anggota sudah ada!',
            'nama.required' => 'Nama anggota tidak boleh kosong!',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong!',
            'pekerjaan.required' => 'Pekerjaan tidak boleh kosong!',
            'tempat_tugas.required' => 'Tempat tugas tidak boleh kosong!',
            'status.required' => 'Status tidak boleh kosong!',
            'level.required' => 'Level tidak boleh kosong!',
            'tgl_masuk.required' => 'Tanggal masuk tidak boleh kosong!',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
