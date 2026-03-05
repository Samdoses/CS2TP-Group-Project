<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('review_status')->default('Pending');
            $table->integer('rating');
            $table->string('review_image')->nullable();
            $table->text('review_text')->nullable();

            $table->dateTime('review_date')->useCurrent();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
