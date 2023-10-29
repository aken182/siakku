<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pelunasan_penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_penjualan', 'jumlah_pelunasan', 'pot_bendahara', 'created_at', 'updated_at'];
    protected $table = 'detail_pelunasan_penjualan';
    protected $primaryKey = 'id_detail';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function main_penjualan()
    {
        return $this->belongsTo(Main_penjualan::class, 'id_penjualan');
    }
}
