<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['id_satuan', 'id_unit', 'kode_barang', 'jenis_barang', 'nama_barang', 'posisi_pi', 'tgl_beli', 'umur_ekonomis', 'harga_barang', 'nilai_saat_ini', 'harga_jual', 'stok', 'status_konversi', 'created_at', 'updated_at'];
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
}
