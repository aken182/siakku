<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BeritaRequest extends FormRequest
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
            'tgl_berita' => 'required|date|before_or_equal:today',
            'judul_berita' => 'required',
            'isi_berita' => 'required',
            'penulis' => 'required',
        ];
        $route = Route::currentRouteName();
        if ($route === 'mdu-berita.store') {
            $rules['file_gambar'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'tgl_berita.required' => 'Tanggal berita wajib diisi!',
            'tgl_berita.before_or_equal' => 'Tanggal berita tidak boleh lebih besar dari tanggal hari ini!',
            'judul_berita.required' => 'Judul berita tidak boleh kosong!',
            'isi_berita.required' => 'Isi berita tidak boleh kosong!',
            'penulis.required' => 'Nama penulis tidak boleh kosong!',
            'file_gambar.required_if' => 'File gambar tidak boleh kosong!',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
