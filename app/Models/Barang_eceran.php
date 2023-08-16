<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang_eceran extends Model
{
    use HasFactory;

    protected $fillable = ['id_barang', 'id_satuan', 'standar_nilai', 'jumlah_konversi', 'stok', 'harga_barang', 'nilai_saat_ini', 'harga_jual', 'created_at', 'updated_at'];
    protected $table = 'barang_eceran';
    protected $primaryKey = 'id_eceran';
}
