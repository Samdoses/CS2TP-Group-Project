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
                'created_at' => now()
            ],
            [
                'order_address' => '5 appley appleton road A12 BFN',
                'total_price' => 1353.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 2,
                'created_at' => now()
            ],
            [
                'order_address' => '5 appley appleton road A12 BFN',
                'total_price' => 653.95,
                'delivery_method' => 'standard',
                'order_date' => now(),
                'order_status' => 'Delivered',
                'user_id' => 2,
                'created_at' => now()
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
            ]
        ]);
    }
}
