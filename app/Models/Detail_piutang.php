<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_piutang extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_anggota', 'jumlah_piutang', 'saldo', 'created_at', 'updated_at'];
    protected $table = 'detail_piutang';
    protected $primaryKey = 'id_piutang';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function detail_pelunasan_piutang()
    {
        return $this->hasMany(Detail_pelunasan_piutang::class, 'id_piutang');
    }
}
