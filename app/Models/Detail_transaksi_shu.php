<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transaksi_shu extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_shu', 'jenis_pembagian', 'total', 'created_at', 'updated_at'];
    protected $table = 'detail_transaksi_shu';
    protected $primaryKey = 'id_detail';
}
