<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'subjek', 'pesan', 'created_at', 'updated_at'];
    protected $table = 'pesan';
    protected $primaryKey = 'id_pesan';
}
