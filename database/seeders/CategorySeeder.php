<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = new Category();
        $category1->nombre="Helados";
        $category1->save();

        $category2 = new Category();
        $category2->nombre="Bebidas";
        $category2->save();

        $category3 = new Category();
        $category3->nombre="Comidas Rapidas";
        $category3->save();
    }
}
