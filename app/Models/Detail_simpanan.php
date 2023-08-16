<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_simpanan extends Model
{
    use HasFactory;

    protected $fillable = ['id_main', 'id_simpanan', 'jumlah', 'bunga', 'ppn', 'created_at', 'updated_at'];
    protected $table = 'detail_simpanan';
    protected $primaryKey = 'id_detail';

    public function main_simpanan()
    {
        return $this->belongsTo(Main_simpanan::class, 'id_main');
    }

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class, 'id_simpanan');
    }
}
