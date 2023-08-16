<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_berita',
        'slug_berita',
        'isi_berita',
        'penulis',
        'gambar_berita',
        'tgl_berita',
        'created_at',
        'updated_at',
    ];
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
}
