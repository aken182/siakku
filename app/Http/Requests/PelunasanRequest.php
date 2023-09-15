<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PelunasanRequest extends FormRequest
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
            'cek_pembayaran' => 'required',
            'id_penjualan' => 'required',
            'jumlah_bayar' => 'required',
            'no_bukti' => 'required',
            'saldo_piutang' => 'required',
            'no_pembayaran' => 'required|unique:transaksi,kode',
            'tgl_transaksi' => 'required|date|before_or_equal:today',
            'jenis_transaksi' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'keterangan' => 'required'
        ];

        if ($this->input('cek_pembayaran') === 'penyesuaian') {
            $rules['id_pny_pembayaran'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'cek_pembayaran.required' => 'Jenis pembayaran wajib dipilih!',
            'id_pny_pembayaran.required_if' => 'Invoice penyesuaian wajib dipilih!',
            'id_penjualan.required' => 'Kolom Tagihan wajib diisi!',
            'jumlah_bayar.required' => 'Kolom jumlah pembayaran wajib diisi!',
            'saldo_piutang.required' => 'Kolom sisa tagihan tidak boleh kosong. Silakan isi kolom tagihan dan jumlah pembayaran!',
            'no_pembayaran.required' => 'Kolom nomor pembayaran wajib diisi!',
            'no_pembayaran.unique' => 'Kolom nomor pembayaran harus unik!',
            'no_bukti.required' => 'Kolom nomor bukti wajib diisi!',
            'tgl_transaksi.required' => 'Kolom tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'jenis_transaksi.required' => 'Kolom via pembayaran wajib diisi!',
            'nota_transaksi.required' => 'File nota pembayaran wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota pembayaran harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota pembayaran tidak boleh lebih besar dari 1048 kb!',
            'keterangan.required' => 'Keterangan wajib diisi!'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
