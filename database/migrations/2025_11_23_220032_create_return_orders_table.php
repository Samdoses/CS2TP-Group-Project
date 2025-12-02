<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_orders', function (Blueprint $table) {
            $table->id(); 
            
            $table->date('return_date');
            $table->text('reason'); 
            $table->string('status');

            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};