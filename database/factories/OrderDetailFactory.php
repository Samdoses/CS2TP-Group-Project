<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\OrderDetail::class;

    public function definition()
    {
        return [
            'order_price' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(1, 10),
            'product_id' => $this->faker->numberBetween(1, 45),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}
