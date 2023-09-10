<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TransferSaldoRequest extends FormRequest
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
            'cek_penyesuaian' => 'required',
            'tgl_transaksi' => 'required|date|before_or_equal:today',
            'id_pengirim' => 'required',
            'id_penerima' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'no_bukti' => 'required',
            'nota_transaksi' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required'
        ];

        if ($this->input('cek_penyesuaian') === 'penyesuaian') {
            $rules['id_penyesuaian'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'cek_penyesuaian.required' => 'Jenis transaksi wajib dipilih!',
            'id_penyesuaian.required_if' => 'Nomor transaksi penyesuaian wajib dipilih!',
            'nomor.required' => 'Nomor transaksi wajib diisi!',
            'nomor.unique' => 'Nomor transaksi sudah ada dalam database!',
            'no_bukti.required' => 'Nomor bukti wajib diisi!',
            'tgl_transaksi.required' => 'Tanggal Transaksi wajib diisi !',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'id_pengirim.required' => 'Akun pengirim wajib dipilih !',
            'id_penerima.required' => 'Akun penerima wajib dipilih !',
            'jumlah.required' => 'Jumlah transfer wajib diisi!',
            'nota_transaksi.required' => 'Nota Transaksi wajib diisi!',
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
