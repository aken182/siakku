<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TransaksiShuRequest extends FormRequest
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
            // 'tgl_transaksi' => 'required|before_or_equal:today',
            'tahun_shu' => 'required',
            'nomor' => 'required|unique:transaksi,kode',
            'keterangan' => 'required'
        ];

        if ($this->input('cek_penyesuaian') === 'penyesuaian') {
            $rules['id_penyesuaian'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'cek_penyesuaian.required' => 'Jenis transaksi wajib dipilih !',
            // 'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi !',
            // 'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'tahun_shu.required' => 'Tahun pembukuan wajib diisi !',
            'nomor.required' => 'Nomor transaksi wajib diisi !',
            'nomor.unique' => 'Nomor transaksi sudah ada dalam database !',
            'keterangan' => 'Keterangan transaksi wajib diisi !'
        ];

        if ($this->input('cek_penyesuaian') === 'penyesuaian') {
            $messages['id_penyesuaian.required'] = 'Nomor transaksi yang disesuikan wajib diisi !';
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
