<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ali',
            'surname' => 'ahmad',
            'email' => 'ali@gmail.com',
        ]);

        DB::table('users')->insert([
            'name' => 'mohammad',
            'surname' => 'ahmad',
            'email' => 'mohammad@gmail.com',
        ]);

        DB::table('products')->insert([
            'name' => 'lenovo',
        ]);
        DB::table('products')->insert([
            'name' => 'sony',
        ]);
        DB::table('products')->insert([
            'name' => 'nokia',
        ]);
        DB::table('products')->insert([
            'name' => 'samsung',
        ]);

    }
}
