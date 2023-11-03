<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'model_type'];
    protected $table = 'model_has_roles';
    protected $primaryKey = 'model_id';

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
