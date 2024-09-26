<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
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
            'name' => fake()->currencyCode(),
            'rate' => rand(1, 200),
            'charge' => rand(1, 10),
            'charge_type' => fake()->randomElement(['fixed', 'porcentage']),
            'min' => 5,
            'max' => 5000
        ];
    }
}
