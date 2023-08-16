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
}
