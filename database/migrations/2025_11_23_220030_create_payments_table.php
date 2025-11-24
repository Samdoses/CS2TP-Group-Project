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
        Schema::create('payments', function (Blueprint $table) {
            //this table stores the users payment details for the order
            $table->id('payment_id');
            $table->timestamps();
            $table->string('payment_method');
            $table->string('payment_status');
            $table->dateTime('payment_date');

            $table->foreignId('order_id')->constrained('orders','order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
