<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if categories exist, otherwise create them
        $pcCategoryId = DB::table('product_category')->where('category_name', 'Gaming PCs')->value('category_id');
        if (!$pcCategoryId) {
            $pcCategoryId = DB::table('product_category')->insertGetId(['category_name' => 'Gaming PCs']);
        }

        $componentCategoryId = DB::table('product_category')->where('category_name', 'Components')->value('category_id');
        if (!$componentCategoryId) {
            $componentCategoryId = DB::table('product_category')->insertGetId(['category_name' => 'Components']);
        }

        DB::table('products')->insert([
            // ===== Products from your branch (Gaming PCs) =====
            [
                'product_name' => 'RTX 4090 Beast',
                'product_model' => 'Beast-01',
                'product_price' => 3500,
                'product_description' => 'Ultimate gaming performance.',
                'category_id' => $pcCategoryId,
                'product_createdate' => now(),
                'product_stock' => 10,
                'product_image' => '/images/cool_pc.jpg'
            ],
            [
                'product_name' => 'Starter Rig',
                'product_model' => 'Starter-01',
                'product_price' => 800,
                'product_description' => 'Perfect for 1080p gaming.',
                'category_id' => $pcCategoryId,
                'product_createdate' => now(),
                'product_stock' => 5,
                'product_image' => '/images/cool_pc.jpg'
            ],
            [
                'product_name' => 'Streamer Pro',
                'product_model' => 'Streamer-01',
                'product_price' => 2200,
                'product_description' => 'Optimized for streaming and editing.',
                'category_id' => $pcCategoryId,
                'product_createdate' => now(),
                'product_stock' => 8,
                'product_image' => '/images/cool_pc.jpg'
            ],

            // ===== Products from main branch (Components) =====
            [
                'product_name' => 'GTX 4080',
                'product_model' => 'RTX4080-X',
                'category_id' => $componentCategoryId,
                'product_price' => 1200,
                'product_description'=> 'High-end graphics card.',
                'product_createdate' => now(),
                'product_stock' => 15,
                'product_image' => 'https://pchocasi.com.tr/wp-content/uploads/2022/09/Nvidia-GeForce-RTX-4080-1.jpg',
            ],
            [
                'product_name' => 'Intel i9 14900K',
                'product_model' => 'i9-14900K',
                'category_id' => $componentCategoryId,
                'product_price' => 700,
                'product_description'=> 'Top-tier processor.',
                'product_createdate' => now(),
                'product_stock' => 20,
                'product_image' =>'https://media.very.co.uk/i/very/W1HGC_SQ1_0000000099_N_A_SLf?$pdp_576x768_x2$&fmt=webp'
            ],
            [
                'product_name' => 'AMD Ryzen 9 7950X',
                'product_model' => 'Ryzen9-7950X',
                'category_id' => $componentCategoryId,
                'product_price' => 650,
                'product_description'=> 'High-performance AMD processor.',
                'product_createdate' => now(),
                'product_stock' => 18,
                'product_image' =>'https://m.media-amazon.com/images/I/5116zdA9uyL._AC_SL1200_.jpg'
            ],
            [
                'product_name' => 'Corsair 32GB DDR5 RAM',
                'product_model' => 'Vengeance DDR5-32GB',
                'category_id' => $componentCategoryId,
                'product_price' => 150,
                'product_description'=> 'Fast DDR5 memory.',
                'product_createdate' => now(),
                'product_stock' => 30,
                'product_image' => 'https://m.media-amazon.com/images/I/61eNiRqRcXL._AC_UF894,1000_QL80_.jpg'
            ],
            [
                'product_name' => 'Samsung 2TB NVMe SSD',
                'product_model' => '970 Evo Plus',
                'category_id' => $componentCategoryId,
                'product_price' => 250,
                'product_description'=> 'Blazing fast storage.',
                'product_createdate' => now(),
                'product_stock' => 25,
                'product_image' =>'https://m.media-amazon.com/images/I/71ByVZ1x2vL.jpg'
            ],
            [
                'product_name' => 'ASUS ROG Motherboard',
                'product_model' => 'ROG Strix Z790',
                'category_id' => $componentCategoryId,
                'product_price' => 400,
                'product_description'=> 'Feature-rich motherboard.',
                'product_createdate' => now(),
                'product_stock' => 12,
                'product_image' =>'https://dlcdnwebimgs.asus.com/files/media/B51D103D-2941-412E-8479-AF994957093B/v1/img/kv/ROG-Strix-X670E-E-Gaming.png'
            ],
            [
                'product_name' => 'Cooler Master 750W PSU',
                'product_model' => 'V750 Gold',
                'category_id' => $componentCategoryId,
                'product_price' => 120,
                'product_description'=> 'Reliable power supply.',
                'product_createdate' => now(),
                'product_stock' => 22,
                'product_image' =>'https://m.media-amazon.com/images/I/91bdi5kqQGL._AC_UF1000,1000_QL80_.jpg'
            ],
            [
                'product_name' => 'Noctua CPU Cooler',
                'product_model' => 'NH-D15',
                'category_id' => $componentCategoryId,
                'product_price' => 100,
                'product_description'=> 'Superior air cooling.',
                'product_createdate' => now(),
                'product_stock' => 17,
                'product_image' =>'https://img.overclockers.co.uk/images/HS-03M-NC/05e4e38b81d0351597f55b71637a424c.jpg'
            ],
            [
                'product_name' => 'NZXT H710 Case',
                'product_model' => 'H710 Matte Black',
                'category_id' => $componentCategoryId,
                'product_price' => 200,
                'product_description'=> 'Sleek and spacious PC case.',
                'product_createdate' => now(),
                'product_stock' => 10,
                'product_image' =>'https://nzxt.com/cdn/shop/files/h7-emea-hero-2000x2000.png?v=1762528364.'
            ],
            [
                'product_name' => 'Corsair 2x120mm Case Fans',
                'product_model' => 'AF120',
                'category_id' => $componentCategoryId,
                'product_price' => 50,
                'product_description'=> 'Quiet and efficient case fans.',
                'product_createdate' => now(),
                'product_stock' => 40,
                'product_image' =>'https://m.media-amazon.com/images/I/71Pgp9awWGL.jpg'
            ],
            [
                'product_name' => 'Intel Wi-Fi 6 Card',
                'product_model' => 'AX200',
                'category_id' => $componentCategoryId,
                'product_price' => 40,
                'product_description'=> 'High-speed wireless connectivity.',
                'product_createdate' => now(),
                'product_stock' => 35,
                'product_image' =>'https://m.media-amazon.com/images/I/61n4OsWtW7L.jpg.'
            ],
            [
                'product_name' => 'Samsung 27" Curved Monitor',
                'product_model' => 'Odyssey G5',
                'category_id' => $componentCategoryId,
                'product_price' => 300,
                'product_description'=> 'Immersive curved gaming monitor.',
                'product_createdate' => now(),
                'product_stock' => 25,
                'product_image' =>'https://m.media-amazon.com/images/I/61VO4NO1vHL._AC_UF1000,1000_QL80_.jpg.'
            ],
        ]);
    }
}
