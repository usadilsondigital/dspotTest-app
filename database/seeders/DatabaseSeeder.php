<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Profile;
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
        $all = Profile::all();
        $counter = 0;        
        for ($x = 0; $x < $profilesTotal-1; $x++) {
          if($counter<$friendsTotal+1){
            $random = rand(1, $profilesTotal);
            while($random == $all[$x]->id){
              $random = rand(1, $profilesTotal);
            }
            $all[$x]->friends()->attach($random );
          }$counter++;
        }             
    }

    
}
