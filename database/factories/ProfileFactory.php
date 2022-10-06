<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'img'=>"https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinys
            rgb&dpr=1&w=500",
            'first_name' => $this->faker->unique()->word,
            'last_name' => $this->faker->lastName(),            
            'phone'=>$this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            'city'=>$this->faker->city(),
            'state'=>$this->faker->state(),
            'zipcode'=>Address::postcode(),
            'available'=>$this->faker->boolean(),       
        
        ];
    }
}
