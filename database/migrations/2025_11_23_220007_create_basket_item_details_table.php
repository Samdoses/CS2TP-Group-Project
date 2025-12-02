<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('basket_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(1);

            $table->foreignId('basket_id')->constrained('baskets')->onDelete('cascade');
            
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('basket_items');
    }
};