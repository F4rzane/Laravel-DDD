<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Laravel\Models\User>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->name(),
            'lastname' => fake()->name,
            'birth_date' => fake()->date(),
            'phone' => fake()->numerify('+989#########'),
            'bank_account' => fake()->unique()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
