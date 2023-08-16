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

    public function main_belanja()
    {
        return $this->belongsTo(Main_belanja::class, 'id_belanja');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }
}
