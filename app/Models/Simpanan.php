<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jumlah', 'created_at', 'updated_at'];
    protected $table = 'simpanan';
    protected $primaryKey = 'id_simpanan';
}
