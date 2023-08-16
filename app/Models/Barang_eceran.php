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

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'id_eceran');
    }

    public function detail_penyusutan()
    {
        return $this->hasMany(Detail_penyusutan::class, 'id_eceran');
    }
}
