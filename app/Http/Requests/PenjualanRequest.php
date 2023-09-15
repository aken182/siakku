<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PenjualanRequest extends FormRequest
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
            'cek_penjualan' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'metode_transaksi' => 'required',
            'pembeli' => 'required',
            'id_kredit' => 'required',
            'keterangan' => 'required',
            'data' => 'required',
            'total_transaksi' => 'required',
        ];

        if ($this->input('cek_penjualan') === 'penyesuaian') {
            $rules['id_penjualan_penyesuaian'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $rules['id_kas'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $rules['id_bank'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Piutang') {
            $rules['id_piutang'] = 'required';
        }

        if ($this->input('pembeli') === 'pegawai') {
            $rules['pegawai_id'] = 'required';
        }

        if ($this->input('pembeli') === 'non-pegawai') {
            $rules['nama_bukan_pegawai'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'cek_penjualan.required' => 'Jenis penjualan wajib dipilih!',
            'id_penjualan_penyesuaian.required_if' => 'Nomor transaksi penyesuaian penjualan wajib dipilih!',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi harus unik!',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'pembeli.required' => 'Data Pembeli wajib diisi!',
            'pegawai_id.required_if' => 'Nama pegawai atau karyawan pembeli wajib dipilih!',
            'nama_bukan_pegawai.required_if' => 'Nama pembeli wajib diisi!',
            'nota_transaksi.required' => 'File nota transaksi wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota transaksi harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota transaksi tidak boleh lebih besar dari 1048 kb!',
            'metode_transaksi.required' => 'Metode transaksi wajib pilih!',
            'id_kas.required_if' => 'Rekening kas wajib dipilih!',
            'id_bank.required_if' => 'Rekening bank wajib dipilih!',
            'id_piutang.required_if' => 'Rekening piutang wajib dipilih!',
            'id_kredit.required' => 'Nama akun wajib dipilih!',
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
