<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $city1= new City();
        $city1->name="Pereira";
        $city1->save();

        $city2= new City();
        $city2->name="Armenia";
        $city2->save();

        $city3= new City();
        $city3->name="Manizales";
        $city3->save();
    }
}
