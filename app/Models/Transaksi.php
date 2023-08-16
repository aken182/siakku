<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'kode_pny', 'no_bukti', 'tipe', 'tgl_transaksi', 'jenis_transaksi', 'detail_tabel', 'metode_transaksi', 'nota_transaksi', 'total', 'keterangan', 'tpk', 'unit', 'created_at', 'updated_at'];
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
}
