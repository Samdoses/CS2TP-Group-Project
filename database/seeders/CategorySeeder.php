<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_category')->insert([
            [
                'category_name' => 'Computer Components',
                'created_at' => now(), 
                'updated_at' => now(), 
            ]
        ]);
        
        // Add other categories 
        DB::table('product_category')->insert([
            ['category_name' => 'Prebuilt PCs', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Bundles', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}