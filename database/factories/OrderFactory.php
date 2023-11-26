<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" =>random_int(1, 10),
            "full_name" =>  $this->faker->name,
            "tel" => $this->faker->phoneNumber,
            "address" => $this->faker-> address,
            "grand_total" => 0,
            "shipping_method" => "Express",
            "payment_method" => "COD",
            "status" => random_int(0,3)
        ];
    }
}
