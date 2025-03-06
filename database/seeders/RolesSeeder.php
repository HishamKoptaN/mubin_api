<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles =  [
            'kenya',
            'tanzania',
            'malawi',
            'cameroun',
            'benin',
            'ghana',
            'guinee',
            'uganda',
            'owner',
            'manager',
            'admin',
        ];
        foreach ($roles as $role) {
            Role::firstOrCreate(
                [
                    'name' => $role,
                    'guard_name' => 'api',
                ]
            );
        }
    }
}
