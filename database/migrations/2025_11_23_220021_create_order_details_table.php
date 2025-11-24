<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            //this table represents every product inside the order
            $table->id();
            $table->integer('order_price');
            $table->integer('quantity');

            $table->foreignId('order_id')->constrained('orders','order_id');
            $table->foreignId('product_id')->constrained('products','product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
