<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo_awal_barang extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'posisi', 'id_barang', 'qty', 'harga', 'nilai_buku', 'subtotal', 'created_at', 'updated_at'];
    protected $table = 'saldo_awal_barang';
    protected $primaryKey = 'id_saldo';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
