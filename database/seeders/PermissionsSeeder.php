<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'manage-kinia',
            'manage-tanzania',
            'manage-benin',
            'manage-cameroun',
            'manage-ghana',
            'manage-guinee',
            'manage-malawi',
            'manage-uganda',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                ],
            );
        }
    }
}
