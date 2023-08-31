<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'kode_pny', 'no_bukti', 'tipe', 'tgl_transaksi', 'jenis_transaksi', 'detail_tabel', 'metode_transaksi', 'nota_transaksi', 'total', 'keterangan', 'tpk', 'unit', 'created_at', 'updated_at'];
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    public function detail_hutang()
    {
        return $this->hasMany(Detail_hutang::class, 'id_transaksi');
    }

    public function detail_pelunasan_hutang()
    {
        return $this->hasMany(Detail_pelunasan_hutang::class, 'id_transaksi');
    }

    public function detail_pelunasan_pinjaman()
    {
        return $this->hasMany(Detail_pelunasan_pinjaman::class, 'id_transaksi');
    }

    public function detail_pelunasan_piutang()
    {
        return $this->hasMany(Detail_pelunasan_piutang::class, 'id_transaksi');
    }

    public function detail_piutang()
    {
        return $this->hasMany(Detail_piutang::class, 'id_transaksi');
    }

    public function detail_penarikan()
    {
        return $this->hasMany(Detail_penarikan::class, 'id_transaksi');
    }

    public function detail_pendapatan()
    {
        return $this->hasMany(Detail_pendapatan::class, 'id_transaksi');
    }

    public function detail_penyusutan()
    {
        return $this->hasMany(Detail_penyusutan::class, 'id_transaksi');
    }

    public function detail_saldo_awal()
    {
        return $this->hasMany(Detail_saldo_awal::class, 'id_transaksi');
    }

    public function detail_transfer_saldo()
    {
        return $this->hasMany(Detail_transfer_saldo::class, 'id_transaksi');
    }

    public function detail_transaksi_shu()
    {
        return $this->hasMany(Detail_transaksi_shu::class, 'id_transaksi');
    }

    public function main_simpanan()
    {
        return $this->hasMany(Main_simpanan::class, 'id_transaksi');
    }

    public function main_penjualan()
    {
        return $this->hasMany(Main_penjualan::class, 'id_transaksi');
    }

    public function main_pinjaman()
    {
        return $this->hasMany(Main_pinjaman::class, 'id_transaksi');
    }

    public function main_belanja()
    {
        return $this->hasMany(Main_belanja::class, 'id_transaksi');
    }

    public function saldo_awal_barang()
    {
        return $this->hasMany(Saldo_awal_barang::class, 'id_transaksi');
    }

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'id_transaksi');
    }
}
