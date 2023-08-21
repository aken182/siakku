<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Roles extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = ['name', 'description'];
    protected $table = 'roles';
    protected $primaryKey = 'id';

    public function manyPermission()
    {
        return $this->hasMany(Permission::class, 'id');
    }
}
