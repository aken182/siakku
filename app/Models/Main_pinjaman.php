<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_pinjaman extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_anggota', 'id_pengajuan', 'total_pinjaman', 'pinjam_tindis', 'kapitalisasi', 'asuransi', 'angsuran_pokok', 'angsuran_bunga', 'saldo_pokok', 'saldo_bunga', 'sisa', 'status', 'jenis', 'created_at', 'updated_at'];
    protected $table = 'main_pinjaman';
    protected $primaryKey = 'id_pinjaman';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function pengajuan_pinjaman()
    {
        return $this->belongsTo(Pengajuan_pinjaman::class, 'id_pengajuan');
    }

    public function detail_pelunasan_pinjaman()
    {
        return $this->hasMany(Detail_pelunasan_pinjaman::class, 'id_pinjaman');
    }
}
