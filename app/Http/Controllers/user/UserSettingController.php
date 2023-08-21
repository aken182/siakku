<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use \Illuminate\Support\Facades\Validator;

class UserSettingController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['role:super-admin']);
    // }
    public function index($request, $data)
    {
        return view('content.pengaturan.pengaturan-user', $data);
    }

    public function userManager(Request $request)
    {
        $userData = User::all();
        $roleData = Role::all();
        $data = [
            'title' => 'User',
            'tableHeader' => getHeaders('users', ''),
            'userData' => $userData,
            'roles' => $roleData
        ];
        return view('content.pengaturan.pengaturan-user', $data);
    }
    public function roleManager(Request $request)
    {
        $roleData = Roles::all();
        $data = [
            'title' => 'Otoritas',
            'tableHeader' => getHeaders('roles', 'guard_name'),
            'roleData' => $roleData
        ];
        return view('content.pengaturan.pengaturan-otoritas', $data);
    }
    public function permissionManager()
    {
        $permissionData = Permission::all();
        $roleData = Roles::all();
        $data = [
            'title' => 'Pengaturan Otorisasi',
            'tableHeader' => getHeaders('permissions', 'guard_name'),
            'permissionData' => $permissionData,
            'roleData' => $roleData
        ];
        return view('content.pengaturan.pengaturan-otorisasi', $data);
    }
    public function storeUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'username' => 'required|unique:users,username',
                'password' => 'required|min:6'
            ],
            [
                'nama.required' => 'Nama Harus Diisi',
                'username.required' => 'Username Harus diisi!',
                'username.unique' => 'Username Sudah dipakai.',
                'password.required' => 'Password Harus diisi',
                // 'password.confirmed' => 'Password Tidak Sesuai',
                'password.min' => 'Password Minimal 6 Karakter',
            ],

        );
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $profil = $request->input('nama') . '-' . time() . '.' . $request->file('foto_profil')->extension();
            $data = [
                'nama' => $request->input('nama'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'foto' => $profil
            ];
            User::create($data)->assignRole($request->input('role'));
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                $fileName = $profil;
                $file->storeAs('foto_profil_mini', $fileName, 'local');
            }
            Alert::success('Sukses', 'Berhasil menambah data user baru.');
            return redirect()->back();
        }
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Nama Otoritas belum diisi Boss, diisi dulu ya..'
            ],

        );
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            Roles::create($request->all());
            Alert::success('Sukses', 'Berhasil menambah data user baru.');
            return redirect()->back();
        }
    }
    public function storePermission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Nama Otorsasinya belum diisi Boss, diisi dulu ya..'
            ],

        );
        if ($validator->fails()) {
            Alert::error('Error', 'Data belum diisi dengan benar.');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            Permission::create($request->all());
            Alert::success('Sukses', 'Berhasil menambah data user baru.');
            return redirect()->back();
        }
    }
    public function roleHasPermission(Request $request)
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role = Role::findByName($request->input('role_name'));
            $role->givePermissionTo([$request->input("permission_name$permission->id")]);
        }

        return redirect()->back();
    }
}
