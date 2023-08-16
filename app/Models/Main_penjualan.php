<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'status_pembeli', 'id_anggota', 'nama_bukan_anggota', 'jenis_penjualan', 'status_penjualan', 'jumlah_penjualan', 'saldo_piutang', 'created_at', 'updated_at'];
    protected $primaryKey = ['id_penjualan'];
    protected $table = 'main_penjualan';
}
