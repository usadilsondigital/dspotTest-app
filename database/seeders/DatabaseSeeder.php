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
        $profilesTotal = 10;
         \App\Models\Profile::factory($profilesTotal)->create();

         \App\Models\Profile::factory()->create();
        //profilesTotal: Total number of profiles to create
        //friendsTotal: Total number of friends connections
    }
}
