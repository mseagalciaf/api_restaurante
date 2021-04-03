<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Modifier;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        //----DATOS REALES DE PRUEBA---------
        $this->call(CitySeeder::class);
        $this->call(SucursaleSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(RoleSeeder::class);

        //-----DATOS FALSOS DE PRUEBA--------
        User::factory(10)->create();
        Product::factory(5)->create();
        Group::factory(5)->create();
        Modifier::factory(20)->create();
        Sale::factory(20)->create();
    }
}
