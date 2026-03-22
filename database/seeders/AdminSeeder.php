<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@happyhardware.local');
        $username = env('ADMIN_USERNAME', 'admin');

        $payload = [
            'FirstName' => env('ADMIN_FIRST_NAME', 'System'),
            'LastName' => env('ADMIN_LAST_NAME', 'Admin'),
            'email' => $email,
            'admin_username' => $username,
            'admin_password' => Hash::make(env('ADMIN_PASSWORD', 'admin12345')),
            'email_verified_at' => now(),
            'remember_token' => null,
        ];

        $existingAdmin = DB::table('admins')
            ->where('email', $email)
            ->orWhere('admin_username', $username)
            ->first();

        if ($existingAdmin) {
            DB::table('admins')
                ->where('admin_id', $existingAdmin->admin_id)
                ->update($payload);

            return;
        }

        DB::table('admins')->insert($payload);
    }
}
