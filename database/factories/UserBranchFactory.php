<?php

namespace Database\Factories;

use App\Models\UserBranch;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserBranchFactory extends Factory
{
    protected $model = UserBranch::class;

    public function definition()
    {
        static $branchId = 1;
        static $userId = 1;

        return [
            'branch_id' => $branchId++,
            'user_id' => $userId++,
        ];
    }
}
