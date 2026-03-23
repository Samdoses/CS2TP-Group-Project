<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'first_name' => 'Edward',
                'last_name' => 'Forest',
                'email' => 'lavender@gmail.com',
                'password'=>'$2y$12$i72J2cDpphmrXcrcAwxkfeBYgM5yeS5wLuArma1H8YV4M0fOfbc6q'
            ],
            [
                'first_name' => 'Linda',
                'last_name' => 'Forest',
                'email' => 'malteser@gmail.com',
                'password'=>'$2y$12$i72J2cDpphmrXcrcAwxkfeBYgM5yeS5wLuArma1H8YV4M0fOfbc6q'
            ],
            [
                'first_name' => 'Gibi',
                'last_name' => 'Winter',
                'email' => 'snow@gmail.com',
                'password'=>'$2y$12$DRVnyw3fMAU6hunVvBeAhu.6BS3WeQICdU6H2jxV5cov2VluhoijO'
            ],
            [
                'first_name' => 'Eddy',
                'last_name' => 'Fish',
                'email' => 'fish@gmail.com',
                'password'=>'$2y$12$DRVnyw3fMAU6hunVvBeAhu.6BS3WeQICdU6H2jxV5cov2VluhoijO'
            ]
        ]);
    }
}
