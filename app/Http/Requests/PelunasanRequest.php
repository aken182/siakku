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
            'no_bukti' => 'required',
            'no_pembayaran' => 'required|unique:transaksi,kode',
            'tgl_transaksi' => 'required|date|before_or_equal:today',
            'jenis_transaksi' => 'required',
            'metode_transaksi' => 'required',
            'nota_transaksi' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'keterangan' => 'required'
        ];

        if ($this->input('cek_pembayaran') === 'penyesuaian') {
            $rules['id_pny_pembayaran'] = 'required';
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Piutang Penjualan' || $this->input('jenis_transaksi') === 'Pembayaran Hutang Belanja') {
            $rules['jumlah_bayar'] = 'required';
            $rules['saldo_tagihan'] = 'required';
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Piutang Penjualan') {
            $rules['id_penjualan'] = 'required';
            $rules['pot_bendahara'] = 'required';
            $rules['tpk'] = 'required';
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Hutang Belanja') {
            $rules['id_belanja'] = 'required';

            if ($this->input('cek_bunga_hutang') == 'on') {
                $rules['bunga_hutang'] = 'required';
            }
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Pinjaman Anggota') {
            $rules['id_pinjaman'] = 'required';
            $rules['angsuran_pokok'] = 'required';
            $rules['angsuran_bunga'] = 'required';
            $rules['total_transaksi'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'cek_pembayaran.required' => 'Jenis pembayaran wajib dipilih!',
            'no_pembayaran.required' => 'Kolom nomor pembayaran wajib diisi!',
            'no_pembayaran.unique' => 'Kolom nomor pembayaran harus unik!',
            'no_bukti.required' => 'Kolom nomor bukti wajib diisi!',
            'tgl_transaksi.required' => 'Kolom tanggal transaksi wajib diisi!',
            'tgl_transaksi.before_or_equal' => 'Tanggal transaksi tidak boleh lebih besar dari tanggal hari ini!',
            'jenis_transaksi.required' => 'Jenis transaksi wajib diisi!',
            'metode_transaksi.required' => 'Kolom via pembayaran wajib diisi!',
            'nota_transaksi.required' => 'File nota pembayaran wajib diisi!',
            'nota_transaksi.mimes' => 'Jenis file nota pembayaran harus jpeg/png/jpg/gif/svg!',
            'nota_transaksi.max' => 'Ukuran file nota pembayaran tidak boleh lebih besar dari 1048 kb!',
            'keterangan.required' => 'Keterangan wajib diisi!'
        ];

        if ($this->input('cek_pembayaran') === 'penyesuaian') {
            $messages['id_pny_pembayaran.required'] = 'Invoice penyesuaian wajib diisi!';
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Piutang Penjualan' || $this->input('jenis_transaksi') === 'Pembayaran Hutang Belanja') {
            $messages['jumlah_bayar.required'] = 'Kolom jumlah pembayaran wajib diisi!';
            $messages['saldo_tagihan.required'] = 'Kolom sisa tagihan tidak boleh kosong. Silakan isi kolom tagihan dan jumlah pembayaran!';
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Piutang Penjualan') {
            $messages['id_penjualan.required'] = 'Kolom tagihan wajib diisi!';
            $messages['pot_bendahara.required'] = 'Kolom potongan dari bendahara wajib diisi !';
            $messages['tpk.required'] = 'Kolom TPK wajib diisi !';
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Hutang Belanja') {
            $messages['id_belanja.required'] = 'Kolom tagihan wajib diisi!';

            if ($this->input('cek_bunga_hutang') == 'on') {
                $messages['bunga_hutang.required'] = 'Kolom bunga hutang wajib diisi!';
            }
        }

        if ($this->input('jenis_transaksi') === 'Pembayaran Pinjaman Anggota') {
            $messages['id_pinjaman.required'] = 'Kolom tagihan pinjaman wajib diisi!';
            $messages['angsuran_pokok.required'] = 'Jumlah angsuran pokok wajib diisi!';
            $messages['angsuran_bunga.required'] = 'Jumlah angsuran bunga wajib diisi!';
            $messages['total_transaksi.required'] = 'Total angsuran tidak boleh kosong!';
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
