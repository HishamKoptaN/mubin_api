<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
            [
                PermissionsSeeder::class,
                UsersSeeder::class,
                ClientsSeeder::class,
                BranchsSeeder::class,
                OrdersSeeder::class,
                RolesSeeder::class,
                RoleUserSeeder::class,
            ],
        );
    }
}
