<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['id_penjualan', 'jenis_barang', 'id_barang', 'id_eceran', 'id_satuan', 'qty', 'harga', 'subtotal', 'created_at', 'updated_at'];
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail';
}
