<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'tracking_code' => fake()->regexify('^[a-zA-Z0-9]{14}$'),
            'commune_id' => 1,
            'delivery_type_id' => 1,
            'status_id' => 1,
            'store_id' => 1,
            'address' => fake()->address(),
            'can_be_opened' => fake()->boolean(),
            'name' => fake()->word(),
            'client_first_name' => fake()->firstName(),
            'client_last_name' => fake()->lastName(),
            'client_phone' => fake()->phoneNumber(),
            'cod_to_pay' => fake()->randomFloat(2, 10000, 100000),
            'commission' => fake()->randomFloat(2, 1000, 10000),
            'status_updated_at' => fake()->dateTime(),
            'delivery_price' => fake()->randomFloat(2, 10000, 100000),
            'free_delivery' => fake()->boolean(),
            'packaging_price' => fake()->randomFloat(2, 500, 100000),
            'partner_cod_price' => fake()->randomFloat(2, 500, 100000),
            'partner_delivery_price' => fake()->randomFloat(2, 500, 100000),
            'price' => fake()->randomFloat(2, 500, 100000),
            'price_to_pay' => fake()->randomFloat(2, 500, 100000),
            'total_price' => fake()->randomFloat(2, 500, 100000),
            'weight' => fake()->numberBetween(1, 1000),
        ];
    }
}
