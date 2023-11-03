<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ModelHasRoles;
use App\Services\CrudService;
use App\Services\ImageService;
use App\Services\AnggotaService;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use \Illuminate\Support\Facades\Validator;

class UserSettingController extends Controller
{
    protected $crudService;
    protected $anggotaService;

    public function __construct()
    {
        $this->crudService = new CrudService;
        $this->anggotaService = new AnggotaService(new ImageService);
    }

    public function index($request, $data)
    {
        return view('content.pengaturan.pengaturan-user', $data);
    }

    public function userManager(Request $request)
    {
        $data = [
            'title' => 'User',
            'userData' => User::all(),
            'userHasRoles' => ModelHasRoles::with(['roles'])->get(),
            'routeCreate' => 'pengaturan-user.create',
            'routeEdit' => 'pengaturan-user.edit',
            'routeDestroy' => 'pengaturan-user.destroy',
        ];
        $isi = $this->crudService->messageConfirmDelete('User');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.pengaturan.pengaturan-user', $data);
    }

    public function createUser()
    {
        $data = [
            'title' => 'Tambah User',
            'roles' => Role::all(),
            'anggota' => $this->anggotaService->getDataAnggotaToForm(),
            'routeStore' => 'pengaturan-user.store',
        ];
        return view('content.pengaturan.create-user', $data);
    }

    public function storeUser(UserRequest $request)
    {
        $anggota = $this->anggotaService->getDataAnggota($request->input('id_anggota'));
        $data = [
            'nama' => $anggota->nama,
            'id_anggota' => $request->input('id_anggota'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        ];
        User::create($data)->assignRole($request->input('role'));
        Alert::success('Sukses', 'Berhasil menambah data user baru.');
        return redirect()->route('pengaturan-user');
    }

    public function editUser($id)
    {
        $id_user = Crypt::decrypt($id);
        $data = [
            'user' => User::find($id_user),
            'roles' => Roles::all(),
            'userRole' => ModelHasRoles::with(['roles'])->where('model_id', $id_user)->first(),
            'routeUpdate' => 'pengaturan-user.update',
            'title' => 'Edit User',
        ];
        return view('content.pengaturan.edit-user', $data);
    }

    public function updateUser(UserRequest $request, $id)
    {
        $input = $request->all();

        if (!empty($input['password'])) {

            $input['password'] = bcrypt($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('role'));

        Alert::success('Sukses', 'Berhasil mengubah data user.');
        return redirect()->route('pengaturan-user');
    }

    public function destroyUser($id)
    {
        User::find($id)->delete();
        Alert::success('Sukses', 'Berhasil menghapus data user.');
        return redirect()->back();
    }

    public function roleManager(Request $request)
    {
        $roleData = Roles::all();
        $data = [
            'title' => 'Otoritas',
            'roleData' => $roleData,
            'routeEdt' => 'pengaturan-otoritas.edit',
            'routeDlt' => 'pengaturan-otoritas.destroy',
        ];
        $isi = $this->crudService->messageConfirmDelete('Role');
        confirmDelete($isi['title'], $isi['text']);
        return view('content.pengaturan.pengaturan-otoritas', $data);
    }

    public function storeRole(RoleRequest $request)
    {
        Roles::create($request->all());
        Alert::success('Sukses', 'Berhasil menambah data user baru.');
        return redirect()->back();
    }

    public function editRole($id)
    {
        $data = [
            'title' => 'Edit Role',
            'role' => Roles::find($id),
            'routeUpdate' => 'pengaturan-otoritas.update',
        ];
        return view('content.pengaturan.edit-role', $data);
    }

    public function updateRole(RoleRequest $request, $id)
    {
        $input = $request->all();
        $roles = Roles::find($id);
        $roles->update($input);
        Alert::success('Sukses', 'Berhasil mengubah data role.');
        return redirect()->route('pengaturan-otoritas');
    }

    public function destroyRole($id)
    {
        Roles::find($id)->delete();
        Alert::success('Sukses', 'Berhasil menghapus data role.');
        return redirect()->back();
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
