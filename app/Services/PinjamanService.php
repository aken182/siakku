<?php

namespace App\Services;

use App\Models\Pengajuan_pinjaman;

class PinjamanService
{
      public function getConvertToNumberRequest($request)
      {
            $request['gaji_perbulan'] = convertToNumber($request->input('gaji_perbulan'));
            $request['potongan_perbulan'] = convertToNumber($request->input('potongan_perbulan'));
            $request['cicilan_perbulan'] = convertToNumber($request->input('cicilan_perbulan'));
            $request['biaya_perbulan'] = convertToNumber($request->input('biaya_perbulan'));
            $request['sisa_penghasilan'] = convertToNumber($request->input('sisa_penghasilan'));
            $request['kemampuan_bayar'] = convertToNumber($request->input('kemampuan_bayar'));
            $request['jumlah_pinjaman'] = convertToNumber($request->input('jumlah_pinjaman'));
            $request['kapitalisasi'] = convertToNumber($request->input('kapitalisasi'));
            $request['asuransi'] = convertToNumber($request->input('asuransi'));
            $request['angsuran_bunga'] = convertToNumber($request->input('angsuran_bunga'));
            $request['angsuran_pokok'] = convertToNumber($request->input('angsuran_pokok'));
            $request['total_angsuran'] = convertToNumber($request->input('total_angsuran'));
            $request['total_pinjaman'] = convertToNumber($request->input('total_pinjaman'));

            return $request;
      }

      public function getPengajuan($id)
      {
            return Pengajuan_pinjaman::with(['anggota'])->where('id_pengajuan', $id)->first();
      }
}
