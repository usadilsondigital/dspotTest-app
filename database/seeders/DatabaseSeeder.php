<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $profilesTotal = env('PROFILES_TOTAL', 1);
        $friendsTotal = env('FRIENDS_TOTAL', 1);
        \App\Models\Profile::factory()->count($profilesTotal)->create();

         
    }
}
