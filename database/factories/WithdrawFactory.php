<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdraw>
 */
class WithdrawFactory extends Factory
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
            'amount' => fake()->randomFloat(2, 10, 100),
            'charge' => 0,
            'method' => Currency::inRandomOrder()->first()->value('name'),
            'transaction' => fake()->text(20),
            'attachement' => null,
            'message' => null,
            'user_id' => User::inRandomOrder()->first()->value('id')
        ];
    }
}
