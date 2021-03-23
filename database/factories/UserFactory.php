<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'nombre' => $this->faker->firstName(), 
            'correo' => $this->faker->unique()->safeEmail(), 
            'password' => $this->faker->password(), 
            'role_id' => $this->faker->numberBetween(1,3), 
            'sucursale_id' => $this->faker->numberBetween(1,3)
        ];
    }
}
