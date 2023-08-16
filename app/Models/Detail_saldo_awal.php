<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_saldo_awal extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_coa', 'posisi_dr_cr', 'saldo', 'created_at', 'updated_at'];
    protected $table = 'detail_saldo_awal';
    protected $primaryKey = 'id_detail';
}
