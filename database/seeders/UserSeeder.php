<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
            'name' => 'Admin user',
            'surname' => 'adminuser',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => '1',
            'password' => bcrypt('Password&Admin2024'),
            'created_at' => now(),
            // 'updated_at' => now(),
            'email_verified_at' => now(),
            ],
            [
            'name' => 'User',
            'surname' => 'user',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'status' => '1',
            'password' => bcrypt('Password&User2024'),
            'created_at' => now(),
            // 'updated_at' => now(),
            'email_verified_at' => now(),
            ],
            [
            'name' => 'Kossivi Hyacinthe',
            'surname' => 'AGBEDJINOU',
            'email' => 'agbehyavargas@gmail.com',
            'role' => 'admin',
            'status' => '1',
            'password' => bcrypt('Hyacinthe&Admin2024'),
            'created_at' => now(),
            // 'updated_at' => now(),
            'email_verified_at' => now(),
            ]
        ]);

    }
}
