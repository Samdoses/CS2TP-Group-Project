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
        Schema::create('basket_item_details', function (Blueprint $table) {
            //this table represents every single item stored in the users basket
            $table->id('basket_item_id');
            $table->timestamps();
            $table->integer('quantity');

            $table->foreignId('basket_id')->constrained('basket','basket_id');
            $table->foreignId('product_id')->constrained('products','product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_item_details');
    }
};
