<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Permission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermissionImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $rows)
    {
        return new Permission([
            'name' => $rows['name'],
            'authority' => $rows['authority'],
            'guard_name' => 'web'
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
