<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
      protected $fillable = ['kode', 'nama', 'kategori', 'subkategori', 'header', 'created_at', 'updated_at'];
      protected $table = 'coa';
      protected $primaryKey = 'id_coa';
}
