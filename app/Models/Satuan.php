<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_satuan'];
    protected $table = 'satuan';
    protected $primaryKey = 'id_satuan';

    public function detail_pendapatan()
    {
        return $this->hasMany(Detail_pendapatan::class, 'id_satuan');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_barang', 'id_satuan');
    }

    public function barang_eceran()
    {
        return $this->hasMany(Barang_eceran::class, 'id_eceran', 'id_satuan');
    }

    public function detail_belanja_barang()
    {
        return $this->hasMany(Detail_belanja_barang::class, 'id_detail', 'id_satuan');
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'id_detail', 'id_satuan');
    }

    public function detail_penjualan_lain()
    {
        return $this->hasMany(Detail_penjualan_lain::class, 'id_detail', 'id_satuan');
    }

    public function detail_penyusutan()
    {
        return $this->hasMany(Detail_penyusutan::class, 'id_detail', 'id_satuan');
    }
}
