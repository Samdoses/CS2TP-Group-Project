<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Review;

use function Symfony\Component\Clock\now;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {

        DB::table('reviews')->insert([
            [
                'rating' => 5,
                'review_image' => '1772411357_69a4d9dda3fbe.jpg',
                'review_text' => 'A very fast and good quality cpu.',
                'review_date' => now(),
                'user_id' => 1,
                'order_id' => 1,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' =>now(),
                'review_status' => 'Approved'
            ],
            [
                'rating' => 5,
                'review_image' => '1772411308_69a4d9ac6aa81.jpg',
                'review_text' => 'A perfect pc cpu.',
                'review_date' => now(),
                'user_id' => 2,
                'order_id' => 3,
                'product_id' => 3,
                'review_status' => 'Approved',
                'created_at' => now(),
                'updated_at' =>now()
            ],
            [
                'rating' => 5,
                'review_image' => '1772411357_69a4d9dda3faa.jpg',
                'review_text' => 'I love this cpu, its cheap and very good quality!',
                'review_date' => now(),
                'user_id' => 2,
                'order_id' => 2,
                'product_id' => 26,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => now()
            ],
            [
                'rating' => 4,
                'review_image' => '1773693266_69b8695223843.jpg',
                'review_text' => 'This usb makes installing archlinux so easy',
                'review_date' => now(),
                'user_id' => 1,
                'order_id' => 4,
                'product_id' => 45,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => now()
            ],
            [
                'rating' => 5,
                'review_image' => '1773692744_69b867485d29b.png',
                'review_text' => 'IT ACTUALLY WORKS!!',
                'review_date' => now(),
                'user_id' => 2,
                'order_id' => 3,
                'product_id' => 45,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => now()
            ],
            [
                'rating' => 4,
                'review_image' => '1773693402_69b869da09f3f.jpg',
                'review_text' => '',
                'review_date' => now(),
                'user_id' => 3,
                'order_id' => 5,
                'product_id' => 22,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => now()
            ],
            [
                'rating' => 5,
                'review_image' => '1773693417_69b869e9d63aa.jpg',
                'review_text' => 'Perfect for my setup! I even set the colour of the pc to blue.',
                'review_date' => '2026-03-16 21:01:13',
                'user_id' => 2,
                'order_id' => 2,
                'product_id' => 22,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => '2026-03-12 21:01:13'
            ],
            [
                'rating' => 5,
                'review_image' => '1773693432_69b869f892368.jpg',
                'review_text' => 'Saw my wife had one of these and got it for myself, amazing quality.',
                'review_date' => '2026-03-16 21:01:13',
                'user_id' => 1,
                'order_id' => 4,
                'product_id' => 22,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => '2026-03-16 21:01:13'
            ],
            [
                'rating' => 4,
                'review_image' => '1773693447_69b86a073c7a1.jpg',
                'review_text' => 'Nice colour for my setup, a bit expensive though.',
                'review_date' => '2026-03-10 21:01:13',
                'user_id' => 4,
                'order_id' => 6,
                'product_id' => 13,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => '2026-03-10 21:01:13'
            ],
            [
                'rating' => 4,
                'review_image' => '',
                'review_text' => 'Good specs, overall a pretty decent CPU',
                'review_date' => '2026-03-3 21:01:13',
                'user_id' => 4,
                'order_id' => 5,
                'product_id' => 3,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => '2026-03-3 21:01:13'
            ]
        ]);

        DB::table('website_reviews')->insert([
            [
                'rating' => 5,
                'review_text' => 'I love happy hardware! There are amazing deals with the bundles and extremely fast delivery times!',
                'user_id' => 1,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => now()
            ],
            [
                'rating' => 5,
                'review_text' => 'I\'ve never seen such great prices on computer parts! Their ram prices are a steal!',
                'user_id' => 2,
                'review_status' => 'Approved',
                'updated_at' =>now(),
                'created_at' => now()
            ]
        ]);

        //make sure we have some delivered orders (linked to edward and lindas accounts)
        if (Order::count() == 0) {
            Order::factory(20)->create(['order_status' => 'Delivered']);
        }

        //obtain 30 different reviews for user 1 and 2 (edward and linda)
        Review::factory(30)->create();
        $this->command->info('...30 reviews generated for users 1 and 2!');
    }
}
