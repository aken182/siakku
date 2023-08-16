<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan_pinjaman extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'id_anggota', 'gaji_perbulan', 'potongan_perbulan', 'cicilan_perbulan', 'biaya_perbulan', 'sisa_penghasilan', 'perkiraan', 'kemampuan_bayar', 'jumlah_pinjaman', 'jangka_waktu', 'bunga', 'asuransi', 'kapitalisasi', 'biaya_administrasi', 'angsuran_bunga', 'angsuran_pokok', 'total_angsuran', 'total_pinjaman', 'keterangan', 'status', 'tgl_acc', 'status_pencairan', 'created_at', 'updated_at'];
    protected $table = 'pengajuan_pinjaman';
    protected $primaryKey = 'id_pengajuan';
}
