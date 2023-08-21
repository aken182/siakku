<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil_kpri extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'badan_hukum', 'tgl_badan_hukum', 'nmr_pad', 'tgl_pad', 'tgl_rat', 'alamat', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'bentuk_koperasi', 'jenis', 'kelompok_koperasi', 'sektor', 'nik', 'status_nik', 'status_grade', 'created_at', 'updated_at'];
    protected $table = 'profil_kpri';
    protected $primaryKey = 'id';
}
