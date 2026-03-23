<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->timestamp('admin_read_at')->nullable()->after('message');
            $table->text('admin_reply')->nullable()->after('admin_read_at');
            $table->timestamp('admin_replied_at')->nullable()->after('admin_reply');
            $table->boolean('customer_seen_reply')->default(false)->after('admin_replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn([
                'admin_read_at',
                'admin_reply',
                'admin_replied_at',
                'customer_seen_reply',
            ]);
        });
    }
};
