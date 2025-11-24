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
        Schema::create('orders', function (Blueprint $table) {
            //this table represents the entire order as whole
            $table->id('order_id');
            $table->timestamps();
            $table->string('order_address');
            $table->dateTime('order_date');
            $table->string('order_status');

            $table->foreignId('customer_id')->constrained('customers','customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
