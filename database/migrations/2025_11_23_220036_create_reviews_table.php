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
        Schema::create('reviews', function (Blueprint $table) {
            //this table stores every review created by a user
            $table->id('review_id');
            $table->timestamps();
            $table->integer('rating');
            $table->string('review_image')->nullable();
            $table->text('review_text')->nullable();
            $table->dateTime('review_date');

            $table->foreignId('customer_id')->constrained('customers','customer_id');
            $table->foreignId('product_id')->constrained('products','product_id');
            $table->foreignId('order_id')->constrained('orders','order_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
