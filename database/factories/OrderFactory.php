<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\OrderDetail;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Order::class;

    public function definition(): array
    {
        return [
            'order_address' => $this->faker->address(),
            'total_price' => 0, //placeholder for the total price calculation
            'delivery_method' => $this->faker->randomElement(['standard','express']),
            'order_date' => $this->faker->dateTimeThisYear(),
            'order_status' => $this->faker->randomElement(['Placed','Shipped','Delivered']), //add returned later
            'user_id' => $this->faker->randomElement([1, 2]), // only on linda or edwards account
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Order $order) {
        //create the order items
        $items = OrderDetail::factory(rand(1, 5))->create([
                'order_id' => $order->id,
            ]);

            //calculate total price
            $deliveryCost = ($order->delivery_method === 'standard') ? 3.95 : 6.95;
            $subtotal = $items->sum(function ($item) {
                return $item->order_price * $item->quantity;
            });

            // have the total price update to match quantity values
            $order->update([
                'total_price' => $subtotal + $deliveryCost
            ]);
        });
    }
}
