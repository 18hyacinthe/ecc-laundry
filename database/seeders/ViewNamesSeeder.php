<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViewNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('view_names')->insert([
            ['url' => '/admin/dashboard', 'view_name' => 'Dashboard'],
            ['url' => '/admin/users', 'view_name' => 'User Management'],
            // Ajoutez d'autres correspondances URL -> nom de vue ici
        ]);
    }
}
