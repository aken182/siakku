<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PinjamanRequest extends FormRequest
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
            'cek_penyesuaian' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'metode_transaksi' => 'required',
        ];

        if ($this->input('cek_penyesuaian') === 'penyesuaian') {
            $rules['id_penyesuaian'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $rules['id_kas'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $rules['id_bank'] = 'required';
        }

        if ($this->routeIs('pp-pinjaman.store-baru')) {
            $rules['id_pengajuan'] = 'required';
        }

        if ($this->routeIs('pp-pinjaman.store-pinjam-tindis')) {
            $rules['id_pinjaman'] = 'required';
            $rules['total_transaksi'] = 'required';
            $rules['saldo_pokok'] = 'required';
            $rules['saldo_bunga'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'cek_penyesuaian.required' => 'Jenis transaksi wajib dipilih!',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi sudah ada dalam database!',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'tgl_transaksi.required' => 'Tanggal Transaksi wajib diisi !',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'nota_transaksi.required' => 'File nota transaksi wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota transaksi harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota transaksi tidak boleh lebih besar dari 1048 kb!',
            'metode_transaksi.required' => 'Via penerimaan pinjaman wajib dipilih!',
        ];

        if ($this->input('cek_penyesuaian') === 'penyesuaian') {
            $messages['id_penyesuaian.required'] = 'Nomor transaksi penyesuaian wajib dipilih!';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $messages['id_kas.required'] = 'Rekening kas wajib dipilih!';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $messages['id_bank.required'] = 'Rekening bank wajib dipilih!';
        }

        if ($this->routeIs('pp-pinjaman.store-baru')) {
            $messages['id_pengajuan.required'] = 'Pengajuan pinjaman anggota wajib diisi!';
        }

        if ($this->routeIs('pp-pinjaman.store-pinjam-tindis')) {
            $messages['id_pinjaman.required'] = 'Pinjaman sebelumnya wajib diisi!';
            $messages['total_transaksi.required'] = 'Jumlah tambahan pinjaman wajib diisi!';
            $messages['saldo_pokok.required'] = 'Saldo pokok pinjaman wajib diisi!';
            $messages['saldo_bunga.required'] = 'Saldo bunga pinjaman wajib diisi!';
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
