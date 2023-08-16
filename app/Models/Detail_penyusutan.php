<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_penyusutan extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_barang', 'id_eceran', 'id_satuan', 'qty', 'harga_brg_sekarang', 'harga_penyusutan', 'subtotal', 'created_at', 'updated_at'];
    protected $table = 'detail_penyusutan';
    protected $primaryKey = 'id_detail';
}
