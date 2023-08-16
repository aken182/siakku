<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pendapatan extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_satuan', 'jenis_pendapatan', 'nama_pendapatan', 'qty', 'harga', 'subtotal', 'created_at', 'updated_at'];
    protected $table = 'detail_pendapatan';
    protected $primaryKey = 'id_detail';
}
