<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_belanja_operasionallain extends Model
{
    use HasFactory;

    protected $fillable = ['id_belanja', 'id_satuan', 'jenis', 'nama_belanja', 'qty', 'harga', 'subtotal', 'created_at', 'updated_at'];
    protected $table = 'detail_belanja_operasionallain';
    protected $primaryKey = 'id_detail';
}
