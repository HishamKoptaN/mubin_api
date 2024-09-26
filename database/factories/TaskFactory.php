<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['active', 'inactive']),
            'name' => fake()->text(100),
            'description' => fake()->text(500),
            'amount' => fake()->randomFloat(2, 5, 500)
        ];
    }
}
