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
}
