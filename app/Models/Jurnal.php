<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = ['id_coa', 'id_transaksi', 'posisi_dr_cr', 'nominal', 'created_at', 'updated_at'];
    protected $table = ['jurnal'];
    protected $primaryKey = 'id_jurnal';

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'id_coa');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
