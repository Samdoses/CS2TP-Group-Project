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
        Schema::create('return_orders', function (Blueprint $table) {
            //this table stores every return order placed by a user
            $table->id('return_id');
            $table->timestamps();
            $table->text('return_reason')->nullable();
            $table->string('return_status');
            $table->dateTime('return_date');

            $table->foreignId('order_id')->constrained('orders','order_id');
            $table->foreignId('product_id')->constrained('products','product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};
