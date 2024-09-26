<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['pending', 'completed', 'rejected']),
            'type' => fake()->randomElement(['plan', 'withdraw', 'deposit']),
            'amount' => rand(10, 100),
            'attachement' => "luof9cmrxb-1652187446638.jpeg",
            'message' => null,
            'data' => [],
            'user_id' => User::inRandomOrder()->first()->value('id'),
        ];
    }
}
