<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_belanja extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_penyedia', 'jenis_belanja', 'status_belanja', 'jumlah_belanja', 'saldo_hutang', 'created_at', 'updated_at'];
    protected $table = 'main_belanja';
    protected $primaryKey = 'id_belanja';


    public function detail_pelunasan_belanja()
    {
        return $this->hasMany(Detail_pelunasan_belanja::class, 'id_belanja');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function penyedia()
    {
        return $this->belongsTo(Penyedia::class, 'id_penyedia');
    }
}
