<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deposit>
 */
class DepositFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['pending', 'completed']),
            'amount' => fake()->randomFloat(2, 100, 200),
            'rate' => 1,
            'charge' => 0.5,
            'method' => "Bank",
            'transaction' => null,
            'proof' => null,

            'user_id' => User::inRandomOrder()->first()->value('id'),
        ];
    }
}
