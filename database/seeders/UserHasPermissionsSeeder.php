<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $userPermissions = [
            ['user_id' => 2, 'permission_id' => 1],
            ['user_id' => 2, 'permission_id' => 2], 
            ['user_id' => 2, 'permission_id' => 1],
            ['user_id' => 3, 'permission_id' => 3], 
        ];

        DB::table('user_has_permissions')->insert($userPermissions);
    }
}
