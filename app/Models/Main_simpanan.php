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
}
