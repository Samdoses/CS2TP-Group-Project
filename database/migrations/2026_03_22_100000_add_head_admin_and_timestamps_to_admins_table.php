<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('is_head_admin')->default(false)->after('admin_password');
            $table->timestamps();
        });

        DB::table('admins')
            ->where('email', 'admin@happyhardware.local')
            ->update([
                'is_head_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('admins')
            ->whereNull('created_at')
            ->update([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['is_head_admin', 'created_at', 'updated_at']);
        });
    }
};
