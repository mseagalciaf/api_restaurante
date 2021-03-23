<?php

namespace Database\Seeders;

use App\Models\Sucursale;
use Illuminate\Database\Seeder;

class SucursaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursal1 = new Sucursale();
        $sucursal1->nombre="Sucursal Pereira";
        $sucursal1->city_id=1;
        $sucursal1->save();

        $sucursal2 = new Sucursale();
        $sucursal2->nombre="Sucursal Armenia";
        $sucursal2->city_id=2;
        $sucursal2->save();

        $sucursal3 = new Sucursale();
        $sucursal3->nombre="Sucursal Manizales";
        $sucursal3->city_id=3;
        $sucursal3->save();
    }
}
