<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PenarikanRequest extends FormRequest
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
            'cek_penarikan' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'unit' => 'required',
            'jenis_transaksi' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'metode_transaksi' => 'required',
            'id_anggota' => 'required',
            'total_transaksi' => 'required',
        ];

        if ($this->input('cek_penarikan') === 'penyesuaian') {
            $rules['id_penyesuaian'] = 'required';
        }

        if ($this->input('jenis') === 'umum') {
            $rules['nama_simpanan'] = 'required';
            $rules['sisa_saldo'] = 'required';
        }

        if ($this->input('jenis') === 'sukarela berbunga') {
            $rules['cek_penarikan_simpanan'] = 'required';
            $rules['bunga'] = 'required';
            $rules['saldo_simpanan'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $rules['id_kas'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $rules['id_bank'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'cek_penarikan.required' => 'Jenis transaksi wajib dipilih!',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi harus unik!',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'nota_transaksi.required' => 'File nota transaksi wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota transaksi harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota transaksi tidak boleh lebih besar dari 1048 kb!',
            'metode_transaksi.required' => 'Metode transaksi wajib pilih!',
            'unit.required' => 'Unit wajib diisi!',
            'jenis_transaksi.required' => 'Jenis transaksi wajib diisi!',
            'id_anggota.required' => 'Nama anggota wajib dipilih!',
            'total_transaksi.required' => 'Jumlah penarikan wajib diisi!',
        ];

        if ($this->input('cek_penarikan') === 'penyesuaian') {
            $messages['id_penyesuaian.required'] = 'Nomor transaksi penyesuaian penarikan wajib dipilih!';
        }

        if ($this->input('jenis') === 'umum') {
            $messages['nama_simpanan.required'] = 'Jenis simpanan wajib dipilih!';
            $messages['sisa_saldo.required'] = 'Sisa saldo simpanan tidak boleh kosong!';
        }

        if ($this->input('jenis') === 'sukarela berbunga') {
            $messages['cek_penarikan_simpanan.required'] = 'Jenis penarikan simpanan wajib dipilih!';
            $messages['bunga.required'] = 'Bunga/bulan sekarang tidak boleh kosong!';
            $messages['saldo_simpanan.required'] = 'Sisa saldo simpanan tidak boleh kosong!';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $messages['id_kas.required'] = 'Rekening kas wajib dipilih!';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $messages['id_bank.required'] = 'Rekening bank wajib dipilih!';
        }

        return $messages;
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
