<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(), 
            'email' => $this->faker->unique()->safeEmail(), 
            'password' => Hash::make("password"),  
            'sucursale_id' => $this->faker->numberBetween(1,3)
        ];
    }
}
