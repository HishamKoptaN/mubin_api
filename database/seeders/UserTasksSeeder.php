<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\UserTask;
class UserTasksSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [1, 2, 3]; 
        $users = [1, 2, 3, 4, 5];
        $image =  ['1.png','2.png','3.png'];
        for ($i = 0; $i < 10; $i++) {
            UserTask::create([
                'status' => 'completed',
                'image' => "https://aquan.aquan.website/api/show/image/user_tasks/" . $image[array_rand($image)],
                'task_id' => $tasks[array_rand($tasks)], 
                'user_id' => $users[array_rand($users)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
