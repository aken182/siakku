<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transfer_saldo extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_pengirim', 'id_penerima', 'jumlah', 'created_at', 'updated_at'];
    protected $table = 'detail_transfer_saldo';
    protected $primaryKey = 'id_detail';
}
