<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\TaskProof;

class UserTasksSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [1, 2, 3];
        $users = [1, 2, 3, 4, 5];
        $image =  ['1.png', '2.png', '3.png'];
        for ($i = 0; $i < 10; $i++) {
            TaskProof::create([
                'status' => $this->getRandomStatus(),
                'image' => "https://api.aquan.website/public/storage/task_proofs/" . $image[array_rand($image)],
                'task_id' => $tasks[array_rand($tasks)],
                'user_id' => $users[array_rand($users)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
    private function getRandomStatus()
    {
        $statuses = ['accepted', 'rejected', 'pending'];
        return $statuses[array_rand($statuses)];
    }
}
