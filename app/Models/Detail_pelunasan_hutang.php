<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pelunasan_hutang extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_hutang', 'jumlah_pelunasan', 'created_at', 'updated_at'];
    protected $table = 'detail_pelunasan_hutang';
    protected $primaryKey = 'id_detail';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function detail_hutang()
    {
        return $this->belongsTo(Detail_hutang::class, 'id_hutang');
    }
}
