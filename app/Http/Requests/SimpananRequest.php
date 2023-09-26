<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SimpananRequest extends FormRequest
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
            'cek_simpanan' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'unit' => 'required',
            'jenis_transaksi' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'metode_transaksi' => 'required',
            'id_anggota' => 'required',
            // 'keterangan' => 'required',
            'total_transaksi' => 'required',
        ];

        if ($this->input('cek_simpanan') === 'penyesuaian') {
            $rules['id_penyesuaian'] = 'required';
        }

        if ($this->input('unit') === 'Simpan Pinjam' && $this->input('jenis_transaksi') === 'Simpanan') {
            $rules['data_simpanan'] = 'required';
        }

        if ($this->input('jenis_transaksi') === 'Simpanan Sukarela Berbunga') {
            $rules['bunga'] = 'required';
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
        $messages = [
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'cek_simpanan.required' => 'Jenis simpanan wajib dipilih!',
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
            // 'keterangan.required' => 'Keterangan wajib diisi!',
            'total_transaksi.required' => 'Jumlah setoran simpanan wajib diisi!',
        ];

        if ($this->input('cek_simpanan') === 'penyesuaian') {
            $messages['id_penyesuaian.required'] = 'Nomor transaksi penyesuaian simpanan wajib dipilih!';
        }

        if ($this->input('metode_transaksi') === 'Kas') {
            $messages['id_kas.required'] = 'Rekening kas wajib dipilih!';
        }

        if ($this->input('metode_transaksi') === 'Bank') {
            $messages['id_bank.required'] = 'Rekening bank wajib dipilih!';
        }

        if ($this->input('metode_transaksi') === 'Piutang') {
            $messages['id_piutang.required'] = 'Rekening piutang wajib dipilih!';
        }

        if ($this->input('unit') === 'Simpan Pinjam' && $this->input('jenis_transaksi') === 'Simpanan') {
            $messages['data_simpanan.required'] = 'Data keranjang wajib diisi!';
            $messages['total_transaksi.required'] = 'Total simpanan tidak boleh kosong !';
        }
        if ($this->input('jenis_transaksi') === 'Simpanan Sukarela Berbunga') {
            $messages['bunga.required'] = 'Kolom bunga simpanan tidak boleh kosong !';
            $messages['total_transaksi.required'] = 'Jumlah setoran simpanan wajib diisi !';
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
