<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pelunasan_pinjaman extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_pinjaman', 'jenis_angsuran', 'angsuran_ke', 'besar_pinjaman', 'angsuran_bunga', 'angsuran_pokok', 'total_angsuran', 'created_at', 'updated_at'];
    protected $table = 'detail_pelunasan_pinjaman';
    protected $primaryKey = 'id_detail';
}
