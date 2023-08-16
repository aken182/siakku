<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyedia extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'no_tlp', 'created_at', 'updated_at'];
    protected $table = 'penyedia';
    protected $primaryKey = 'id_penyedia';

    public function main_belanja()
    {
        return $this->hasMany(Main_belanja::class, 'id_penyedia');
    }
}
