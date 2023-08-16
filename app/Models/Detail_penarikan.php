<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_penarikan extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_anggota', 'jenis_penarikan', 'nama_penarikan', 'jumlah_penarikan', 'created_at', 'updated_at'];
    protected $table = 'detail_penarikan';
    protected $primaryKey = 'id_detail';
}
