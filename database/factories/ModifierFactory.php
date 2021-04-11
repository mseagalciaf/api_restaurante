<?php

namespace Database\Factories;

use App\Models\Modifier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModifierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Modifier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->unique()->word()
        ];
    }
}
