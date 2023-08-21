<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Super Admin*/
        $superAdmin = User::create([
            'nama' => 'Master Admin',
            'username' => 'Master Admin',
            'password' => bcrypt('superKpri1977'),
        ]);

        $super = Role::create(['name' => 'super-admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $super->syncPermissions($permissions);
        $superAdmin->assignRole([$super->id]);
    }
}
