<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_hutang extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'pemberi_pinjaman', 'jenis_hutang', 'jumlah_hutang', 'saldo_hutang', 'created_at', 'updated_at'];
    protected $table = 'detail_hutang';
    protected $primaryKey = 'id_hutang';
}
