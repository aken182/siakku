<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_pinjaman extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_anggota', 'id_pengajuan', 'total_pinjaman', 'kapitalisasi', 'angsuran_pokok', 'angsuran_bunga', 'saldo_pokok', 'saldo_bunga', 'sisa', 'status', 'jenis', 'created_at', 'updated_at'];
    protected $table = 'main_pinjaman';
    protected $primaryKey = 'id_pinjaman';
}
