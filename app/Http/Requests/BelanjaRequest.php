<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BelanjaRequest extends FormRequest
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
            'tgl_transaksi' => 'required|date|before_or_equal:today',
            'cek_belanja' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'metode_transaksi' => 'required',
            'jenis_transaksi' => 'required',
            'tpk' => 'required',
            'keterangan' => 'required',
            'data' => 'required',
            'total_transaksi' => 'required',
        ];

        if ($this->input('cek_belanja') === 'penyesuaian') {
            $rules['id_belanja_penyesuaian'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $rules['id_kas'] = 'required';
            $rules['id_belanja'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $rules['id_bank'] = 'required';
            $rules['id_belanja'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Hutang') {
            $rules['id_hutang'] = 'required';
            $rules['id_penyedia'] = 'required';
            $rules['id_penerima'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'cek_belanja.required' => 'Jenis belanja wajib dipilih!',
            'id_belanja_penyesuaian.required_if' => 'Nomor transaksi penyesuaian belanja wajib dipilih!',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi harus unik!',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'nota_transaksi.required' => 'File nota transaksi wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota transaksi harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota transaksi tidak boleh lebih besar dari 1048 kb!',
            'metode_transaksi.required' => 'Metode transaksi wajib pilih!',
            'jenis_transaksi.required' => 'Jenis transaksi wajib diisi!',
            'tpk.required' => 'TPK wajib dipilih!',
            'id_kas.required_if' => 'Rekening kas wajib dipilih!',
            'id_bank.required_if' => 'Rekening bank wajib dipilih!',
            'id_hutang.required_if' => 'Rekening hutang wajib dipilih!',
            'id_penyedia.required_if' => 'Nama pemberi hutang wajib diisi!',
            'id_belanja.required_if' => 'Nama akun belanja wajib dipilih!',
            'id_penerima.required_if' => 'Nama akun penerima wajib dipilih!',
            'keterangan.required' => 'Keterangan wajib diisi!',
            'data.required' => 'Detail transaksi wajib diisi!',
            'total_transaksi.required' => 'Total transaksi tidak boleh kosong!'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
