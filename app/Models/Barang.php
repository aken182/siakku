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

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }

    public function barang_eceran()
    {
        return $this->hasMany(Barang_eceran::class, 'id_barang');
    }

    public function detail_belanja_barang()
    {
        return $this->hasMany(Detail_belanja_barang::class, 'id_barang');
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'id_barang');
    }

    public function saldo_awal_barang()
    {
        return $this->hasMany(Saldo_awal_barang::class, 'id_barang');
    }

    public function detail_penyusutan()
    {
        return $this->hasMany(Detail_penyusutan::class, 'id_barang');
    }
}
