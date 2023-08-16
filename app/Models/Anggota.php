<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'no_induk', 'nama', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'pekerjaan', 'tempat_tugas', 'status', 'level', 'tgl_masuk', 'tgl_berhenti', 'alasan_berhenti', 'pas_foto', 'created_at', 'updated_at'];
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
}
