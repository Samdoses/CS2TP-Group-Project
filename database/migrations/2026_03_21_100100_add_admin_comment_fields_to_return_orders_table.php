<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_orders', function (Blueprint $table) {
            $table->text('admin_comment')->nullable()->after('reason');
            $table->timestamp('admin_processed_at')->nullable()->after('admin_comment');
        });
    }

    public function down(): void
    {
        Schema::table('return_orders', function (Blueprint $table) {
            $table->dropColumn([
                'admin_comment',
                'admin_processed_at',
            ]);
        });
    }
};
