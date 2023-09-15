<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PenjualanBarangRequest extends FormRequest
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
            'pembeli' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'metode_transaksi' => 'required',
            'no_bukti' => 'required',
            'data_barang' => 'required',
            'total_transaksi' => 'required',
        ];

        if ($this->input('cek_penjualan') === 'penyesuaian') {
            $rules['id_penjualan_penyesuaian'] = 'required';
        }
        if ($this->input('pembeli') === 'pegawai') {
            $rules['pegawai_id'] = 'required';
        }

        if ($this->input('pembeli') === 'non-pegawai') {
            $rules['nama_bukan_pegawai'] = 'required';
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

        return $rules;
    }

    public function messages()
    {
        return [
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'cek_penjualan.required' => 'Jenis penjualan wajib dipilih!',
            'id_penjualan_penyesuaian.required_if' => 'Nomor transaksi penyesuaian penjualan wajib dipilih!',
            'pembeli.required' => 'Data Pembeli wajib diisi!',
            'pegawai_id.required_if' => 'Nama pegawai atau karyawan pembeli wajib dipilih!',
            'nama_bukan_pegawai.required_if' => 'Nama pembeli wajib diisi!',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi sudah ada dalam database. Ganti nomor transaksi !',
            'nota_transaksi.required' => 'File nota transaksi wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota transaksi harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota transaksi tidak boleh lebih besar dari 1048 kb!',
            'metode_transaksi.required' => 'Metode pembayaran wajib dipilih!',
            'id_kas.required_if' => 'Rekening kas wajib dipilih!',
            'id_bank.required_if' => 'Rekening bank wajib dipilih!',
            'id_piutang.required_if' => 'Rekening piutang wajib dipilih!',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'data_barang.required' => 'Data keranjang wajib diisi!',
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
