<?php

namespace App\Http\Controllers;

use App\Imports\PermissionImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportTablesController extends Controller
{
    public function import()
    {
        $permissionFile = storage_path('app/public/template-xl/permission.xlsx');
        Excel::import(new PermissionImport, $permissionFile);
        return back()->with('succes', 'Success');
    }
}
