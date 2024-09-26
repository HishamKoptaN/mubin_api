<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskUser>
 */
class TaskUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $task = Task::inRandomOrder()->first();

        return [
            'status' => 'pending',
            'proof' => "luof9cmrxb-1652187446638.jpeg",
            'amount' => $task->amount,

            'task_id' => $task->id,
            'user_id' => User::inRandomOrder()->first()->value('id')
        ];
    }
}
