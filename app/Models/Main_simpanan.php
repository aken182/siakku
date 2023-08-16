<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_simpanan extends Model
{
    use HasFactory;
    protected $fillable = ['id_transaksi', 'id_anggota', 'jenis_simpanan', 'total_simpanan', 'created_at', 'updated_at'];
    protected $table = 'main_simpanan';
    protected $primaryKey = 'id_main';

    public function detail_simpanan()
    {
        return $this->hasMany(Detail_simpanan::class, 'id_main');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
