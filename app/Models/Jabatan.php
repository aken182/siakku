<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = ['id_anggota', 'jabatan', 'status', 'created_at', 'updated_at'];
    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
