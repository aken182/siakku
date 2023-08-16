<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pelunasan_piutang extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_piutang', 'jumlah_pelunasan', 'created_at', 'updated_at'];
    protected $table = 'detail_pelunasan_piutang';
    protected $primaryKey = 'id_detail';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function detail_piutang()
    {
        return $this->belongsTo(Detail_piutang::class, 'id_piutang');
    }
}
