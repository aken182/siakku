<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;


class Permission extends Model
{
    use HasFactory;
    use HasPermissions;
    protected $fillable = ['name', 'authority', 'guard_name'];
    protected $table = 'permissions';
    protected $primaryKey = 'id';
}
