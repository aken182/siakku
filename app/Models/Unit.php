<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_unit',
        'nama',
        'unit',
        'created_at',
        'updated_at'
    ];
    protected $table = 'unit';
    protected $primaryKey = 'id_unit';

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_unit');
    }
}
