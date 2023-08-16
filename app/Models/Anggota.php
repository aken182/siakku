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

    public function main_penjualan()
    {
        return $this->hasMany(Main_penjualan::class, 'id_anggota');
    }

    public function main_pinjaman()
    {
        return $this->hasMany(Main_pinjaman::class, 'id_anggota');
    }

    public function main_simpanan()
    {
        return $this->hasMany(Main_simpanan::class, 'id_anggota');
    }

    public function detail_piutang()
    {
        return $this->hasMany(Detail_piutang::class, 'id_anggota');
    }

    public function detail_penarikan()
    {
        return $this->hasMany(Detail_penarikan::class, 'id_anggota');
    }

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'id_anggota');
    }
}
