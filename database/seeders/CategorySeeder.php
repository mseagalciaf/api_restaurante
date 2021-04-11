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
        $category1->name="Helados";
        $category1->save();

        $category2 = new Category();
        $category2->name="Bebidas";
        $category2->save();

        $category3 = new Category();
        $category3->name="Comidas Rapidas";
        $category3->save();
    }
}
