<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function index()
    {
        $dataPermission = Permission::all();
        $data = [
            'title' => 'Permission Manager',
            'permissionData' => $dataPermission,
            'tableHeader' => getHeaders('permissions', 'guard_name')
        ];
        return view('content.authentications.permission', $data);
    }

    public function setPermission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|alpha_num',
            ],
            [
                'name.required' => 'Nama Otorisasinya belum diisi Boss, diisi dulu ya..',
                'name.alpha_num' => 'Hanya Berisi Huruf dan Angka',
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

    // public function import()
    // {
    //     $file = public_path('permission.xlsx');
    //     Excel::import(new PermissionImport, $file);
    //     return back()->with('succes', 'Success');
    // }
}
