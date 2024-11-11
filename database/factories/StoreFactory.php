<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->regexify('^[a-zA-Z0-9]{8}$'),
            'name' => fake()->company(),
            'email' => fake()->unique()->email(),
            'phones' => fake()->phoneNumber(),
            'company_name' => fake()->companySuffix(),
            'capital' => fake()->randomFloat(2, 10000000, 100000000),
            'address' => fake()->address(),
            'register_commerce_number' => fake()->randomNumber(),
            'nif' => fake()->randomNumber(),
            'can_update_preparing_packages' => fake()->boolean(),
        ];
    }
}
