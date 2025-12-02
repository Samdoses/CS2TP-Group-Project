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
        Schema::create('products', function (Blueprint $table) {
            //this table stores every product with relevant information
            $table->id();
            $table->string('product_name');
            $table->string('product_model')->nullable();
            $table->integer('product_price');
            $table->text('product_description');
            $table->string('product_thumbnail')->nullable();
            $table->string('product_image')->nullable();
            $table->dateTime('product_createdate');
            $table->integer('product_stock')->default(0);

            $table->foreignId('category_id')->constrained('product_category')->onDelete('cascade');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
