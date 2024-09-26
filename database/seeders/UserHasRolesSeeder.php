<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasRolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_has_roles')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
            [
                'user_id' => 1,
                'role_id' => 2,
            ],
            [
                'user_id' => 2,
                'role_id' => 1,
            ], 
            [
                'user_id' => 1,
                'role_id' => 1,
            ], 
            [
                'user_id' => 1,
                'role_id' => 1,
            ], 
            [
                'user_id' => 1,
                'role_id' => 1,
            ], 
            [
                'user_id' => 1,
                'role_id' => 1,
            ], 
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ]);
    }
}
