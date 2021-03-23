<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'direccion_envio'=>$this->faker->address(),
            'telefono'=> $this->faker->randomElement(['3123456789','3216826730','3116594195','1234567890']),
            'total'=> $this->faker->randomElement(['15000','30000','50000']),
            'user_id'=> $this->faker->numberBetween(1,10),
            'sucursale_id' => $this->faker->numberBetween(1,3),
            'state_id' => $this->faker->numberBetween(1,3)
        ];
    }
}
