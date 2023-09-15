<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'status_pembeli', 'id_anggota', 'nama_bukan_anggota', 'jenis_penjualan', 'status_penjualan', 'jumlah_penjualan', 'saldo_piutang', 'created_at', 'updated_at'];
    protected $table = 'main_penjualan';
    protected $primaryKey = 'id_penjualan';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function detail_pelunasan_penjualan()
    {
        return $this->hasMany(Detail_pelunasan_penjualan::class, 'id_penjualan');
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'id_penjualan');
    }

    public function detail_penjualan_lain()
    {
        return $this->hasMany(Detail_penjualan_lain::class, 'id_penjualan');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
