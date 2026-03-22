<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('contact_reason')->nullable()->after('sender_email');
            $table->foreignId('related_order_id')->nullable()->after('contact_reason')->constrained('orders')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('related_order_id');
            $table->dropColumn('contact_reason');
        });
    }
};
