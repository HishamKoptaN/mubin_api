<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chat;
use Faker\Factory as Faker;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $adminId = 3;
        $userIds = [4, 5];
        for ($j = 0; $j < 5; $j++) {
            Chat::create([
                'admin_id' => $adminId,
                'user_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
