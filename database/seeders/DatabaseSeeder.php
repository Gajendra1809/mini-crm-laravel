<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //creating admin
        \App\Models\User::create([
            "name"=>"Gajendra Chilhate",
            "email"=>"admin@admin.com",
            "password"=>\Hash::make("password")
        ]);
    }
}
