<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Review::class;

    public function definition(): array
    {
        //finds an order that hasnt been reviewed yet
        $validItem = OrderDetail::whereHas('order', function ($query) {
            $query->whereIn('user_id', [1, 2])
                  ->where('order_status', 'Delivered');
        })
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('reviews')
                  ->whereColumn('reviews.order_id', 'order_details.order_id')
                  ->whereColumn('reviews.product_id', 'order_details.product_id');
        })
        ->inRandomOrder()
        ->first();

        //generates some orders if none have been reviewed
        if (!$validItem) {
            $order = Order::factory()->create([
                'user_id' => $this->faker->randomElement([1, 2]),
                'order_status' => 'Delivered'
            ]);
            //grabs the first item from this brand new order
            $validItem = OrderDetail::where('order_id', $order->id)->first();
        } else {
            $order = $validItem->order;
        }

        //creates some responses so that the reviews seem legit
        $positives = [
            'The quality is really good.',
            'Runs very well!',
            'Definitely worth the price.',
            'Really good performance.',
            'Looks great!'
        ];

        $negatives = [
            'A bit on the pricier side, but its performing well.',
            'Shipping took a while, but it arrived well-packaged.'
        ];
        $isPositive = fake()->boolean(80); // 80% chance of a good review

        //selects a product from that list
        $productItem = OrderDetail::where('order_id', $order->id)->inRandomOrder()->first();


        return [
            'rating' => $isPositive ? 5 : fake()->numberBetween(3, 4), //mostly positive reviews based on odds
            'review_image' => null,
            'review_status' => $this->faker->randomElement(['Approved', 'Approved', 'Approved', 'Pending', 'Pending', 'Rejected']),
            'review_text' => $isPositive ? fake()->randomElement($positives) : fake()->randomElement($negatives), //chooses a random positive/negative response (higher odds of positive)
            'review_date' => $order->order_date,
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'product_id' => $validItem->product_id,
            'created_at' => $this->faker->dateTimeBetween($order->order_date, 'now'),
        ];
    }

}
