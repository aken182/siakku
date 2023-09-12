<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_penjualan_lain extends Model
{
      protected $fillable = ['id_penjualan', 'id_satuan', 'jenis', 'nama', 'qty', 'harga', 'subtotal', 'created_at', 'updated_at'];
      protected $table = 'detail_penjualan_lain';
      protected $primaryKey = 'id_detail';

      public function satuan()
      {
            return $this->belongsTo(Satuan::class, 'id_satuan');
      }

      public function main_penjualan()
      {
            return $this->belongsTo(Main_penjualan::class, 'id_penjualan');
      }
}
