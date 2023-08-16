<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
      protected $fillable = ['kode', 'nama', 'kategori', 'subkategori', 'header', 'created_at', 'updated_at'];
      protected $table = 'coa';
      protected $primaryKey = 'id_coa';

      public function jurnal()
      {
            return $this->hasMany(Jurnal::class, 'id_jurnal');
      }

      public function detail_saldo_awal()
      {
            return $this->hasMany(Detail_saldo_awal::class, 'id_coa');
      }

      public function detail_transfer_saldo_as_pengirim()
      {
            return $this->hasMany(Detail_transfer_saldo::class, 'id_pengirim');
      }

      public function detail_transfer_saldo_as_penerima()
      {
            return $this->hasMany(Detail_transfer_saldo::class, 'id_penerima');
      }
}
