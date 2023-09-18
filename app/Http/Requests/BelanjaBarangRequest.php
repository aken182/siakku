<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BelanjaBarangRequest extends FormRequest
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
            'cek_belanja' => 'required',
            'data_barang' => 'required',
            'total_transaksi' => 'required',
            'tgl_transaksi' => 'required|date|before_or_equal:today',
            'id_penyedia' => 'required',
            'unit' => 'required',
            'tpk' => 'required',
            'jenis_transaksi' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'metode_transaksi' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
        ];

        if ($this->input('cek_belanja') === 'penyesuaian') {
            $rules['id_belanja_penyesuaian'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $rules['id_kas'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $rules['id_bank'] = 'required';
        }

        if ($this->input('metode_transaksi') === 'Hutang') {
            $rules['id_hutang'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'cek_belanja.required' => 'Jenis belanja wajib dipilih!',
            'id_belanja_penyesuaian.required_if' => 'Nomor transaksi penyesuaian belanja wajib dipilih!',
            'data_barang.required' => 'Data keranjang wajib diisi!',
            'total_transaksi.required' => 'Total transaksi tidak boleh kosong!',
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'id_penyedia.required' => 'Data vendor wajib dipilih!',
            'unit.required' => 'Data unit wajib diisi !',
            'tpk.required' => 'Data TPK wajib diisi !',
            'jenis_transaksi.required' => 'Jenis transaksi wajib diisi !',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi sudah ada dalam database. Ganti nomor transaksi !',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'metode_transaksi.required' => 'Metode belanja wajib dipilih!',
            'id_kas.required_if' => 'Rekening kas wajib dipilih!',
            'id_bank.required_if' => 'Rekening bank wajib dipilih!',
            'id_hutang.required_if' => 'Rekening hutang wajib dipilih!',
            'nota_transaksi.required' => 'File nota transaksi wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota transaksi harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota transaksi tidak boleh lebih besar dari 1048 kb!',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'Data belum diisi dengan benar.');
        }
    }
}
