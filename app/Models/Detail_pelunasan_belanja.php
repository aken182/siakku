<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pelunasan_belanja extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_belanja', 'jumlah_pelunasan', 'created_at', 'updated_at'];
    protected $table = 'detail_pelunasan_belanja';
    protected $primaryKey = 'id_detail';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function main_belanja()
    {
        return $this->belongsTo(Main_belanja::class, 'id_belanja');
    }
}
