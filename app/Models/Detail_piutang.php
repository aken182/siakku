<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_piutang extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_anggota', 'jumlah_piutang', 'saldo', 'created_at', 'updated_at'];
    protected $table = 'detail_piutang';
    protected $primaryKey = 'id_piutang';
}
