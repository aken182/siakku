<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shu extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'persen', 'nilai_bagi', 'unit', 'created_at', 'updated_at'];
    protected $table = 'shu';
    protected $primaryKey = 'id_shu';
}
