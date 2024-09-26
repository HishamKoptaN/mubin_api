<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $c1 = Currency::inRandomOrder()->first();
        $c2 = Currency::inRandomOrder()->first();

        return [
            'status' => fake()->randomElement(['pending', 'completed']),
            'amount' => fake()->randomFloat(2, 100, 200),
            'rate' => $c1->rate,
            'charge' => $c1->charge,
            'message' => "",
            'admin_id' => 1,
            'user_id' => User::inRandomOrder()->first()->value('id'),
            'receiver_id' => User::inRandomOrder()->first()->value('id'),
            'sender_currency_id' => $c1->id,
            'receiver_currency_id' => $c2->id
        ];
    }
}
