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
            'name' => 'Kossivi Hyacinthe',
            'surname' => 'AGBEDJINOU',
            'email' => 'kossivi.agbedjinou@centrale-casblanca.ma',
            'role' => 'admin',
            'status' => '1',
            'password' => bcrypt('Hyacinthe&Admin2024'),
            'created_at' => now(),
            // 'updated_at' => now(),
            'email_verified_at' => now(),
            ],
            [
                'name' => 'LAUNDRY',
                'surname' => 'ADMIN',
                'email' => 'laundry@centrale-casblanca.ma',
                'role' => 'admin',
                'status' => '1',
                'password' => bcrypt('Password&Admin2024'),
                'created_at' => now(),
                // 'updated_at' => now(),
                'email_verified_at' => now(),
            ]
        ]);

    }
}
