<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TasksSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $image =  ['1.png', '2.png', '3.png'];
        foreach (range(1, 15) as $index) {
            Task::create(
                [
                    'status' => $faker->randomElement(
                        [
                            true,
                            false,
                        ],
                    ),
                    'name' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'amount' => $faker->numberBetween(100, 1000),
                    'link' => $faker->url,
                    'image' => "https://api.aquan.website/public/storage/tasks/" . $image[array_rand($image)],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            );
        }
    }
}
