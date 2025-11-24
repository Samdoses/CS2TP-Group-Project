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
        Schema::create('customers', function (Blueprint $table) {
            //this table stores every customers personal details and account information
            $table->id('customer_id');
            $table->timestamps();
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('email')->unique();
            $table->string('customer_username')->unique();
            $table->string('customer_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
