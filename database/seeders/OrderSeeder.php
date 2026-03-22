<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;

use function Symfony\Component\Clock\now;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('orders')->insert([
            [
                'order_address' => '9 appley appleton road A14 BFT',
                'total_price' => 653.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_address' => '5 appley appleton road A12 BFN',
                'total_price' => 2353.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_address' => '9 appley appleton road A12 BFN',
                'total_price' => 16.95,
                'delivery_method' => 'express',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_address' => '5 appley appleton road A12 BFN',
                'total_price' => 1013.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_address' => '210 silly fish road F11 FFN',
                'total_price' => 1653.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_address' => '111 silly fish road F11 TMN',
                'total_price' => 2503.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        Order::factory()->count(30)->create();

        DB::table('order_details')->insert([
            [
                'order_price' => 650,
                'quantity' => 1,
                'order_id' => 1,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 650,
                'quantity' => 1,
                'order_id' => 3,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 1350,
                'quantity' => 3,
                'order_id' => 2,
                'product_id' => 26,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 1000,
                'quantity' => 1,
                'order_id' => 2,
                'product_id' => 22,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 1000,
                'quantity' => 1,
                'order_id' => 4,
                'product_id' => 22,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 10,
                'quantity' => 1,
                'order_id' => 3,
                'product_id' => 45,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 10,
                'quantity' => 1,
                'order_id' => 4,
                'product_id' => 45,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 1000,
                'quantity' => 1,
                'order_id' => 5,
                'product_id' => 22,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 650,
                'quantity' => 1,
                'order_id' => 5,
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 1000,
                'quantity' => 1,
                'order_id' => 6,
                'product_id' => 22,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_price' => 3000,
                'quantity' => 2,
                'order_id' => 6,
                'product_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
