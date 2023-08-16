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

    public function main_penjualan()
    {
        return $this->belongsTo(Main_penjualan::class, 'id_penjualan');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function barang_eceran()
    {
        return $this->belongsTo(Barang_eceran::class, 'id_eceran');
    }
}
