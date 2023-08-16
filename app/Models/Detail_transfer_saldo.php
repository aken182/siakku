<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transfer_saldo extends Model
{
    use HasFactory;

    protected $fillable = ['id_transaksi', 'id_pengirim', 'id_penerima', 'jumlah', 'created_at', 'updated_at'];
    protected $table = 'detail_transfer_saldo';
    protected $primaryKey = 'id_detail';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function pengirim()
    {
        return $this->belongsTo(Coa::class, 'id_pengirim');
    }

    public function penerima()
    {
        return $this->belongsTo(Coa::class, 'id_penerima');
    }
}
