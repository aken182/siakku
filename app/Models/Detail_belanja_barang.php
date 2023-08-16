<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_belanja_barang extends Model
{
    use HasFactory;

    protected $fillable = ['id_belanja', 'id_barang', 'id_satuan', 'qty', 'harga', 'subtotal', 'created_at', 'updated_at'];
    protected $table = 'detail_belanja_barang';
    protected $primaryKey = 'id_detail';
}
