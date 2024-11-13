<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'session_duration', 'value' => '120', 'created_at' => now()],
            ['key' => 'session_start_time', 'value' => '06:00', 'created_at' => now()],
            ['key' => 'weekly_session_limit', 'value' => '3', 'created_at' => now()],
            ['key' => 'reset_time', 'value' => '06:00', 'created_at' => now()],
            ['key' => 'allowed_domain', 'value' => 'centrale-casablanca.ma', 'created_at' => now()],
            ['key' => 'allow_other_domains', 'value' => '0', 'created_at' => now()],
        ];

        DB::table('settings')->insert($settings);
    }
}
