<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserBranch;

class UserBranchSeeder extends Seeder
{
    public function run()
    {
        UserBranch::factory()->count(8)->create();
    }
}
