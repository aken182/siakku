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
}
