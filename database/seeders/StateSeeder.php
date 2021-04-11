<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state1 = new State();
        $state1->name="Pendiente";
        $state1->save();

        $state2 = new State();
        $state2->name="Realizada";
        $state2->save();

        $state3 = new State();
        $state3->name="Cancelada";
        $state3->save();
    }
}
