<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_satuan'];
    protected $table = 'satuan';
    protected $primaryKey = 'id_satuan';

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_barang', 'id_satuan');
    }

    public function barang_eceran()
    {
        return $this->hasMany(Barang_eceran::class, 'id_eceran', 'id_satuan');
    }
}
