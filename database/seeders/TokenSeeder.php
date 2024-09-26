<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class TokenSeeder extends Seeder
{
   
 
    public function run()
    {
        $user = DB::table('users')->find(1);
        if ($user) {
            $plainTextToken = 'manager';
            DB::table('personal_access_tokens')->insert([
                'tokenable_type' => 'App\\Models\\User', 
                'tokenable_id' => 1,
                'name' => 'Development Token',
                'token' => $plainTextToken,
                'abilities' => json_encode(['*']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info("Development token created for user with ID 1: {$plainTextToken}");
        } else {
            $this->command->error("User with ID 1 not found.");
        }
    }
}
