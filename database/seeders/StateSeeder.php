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
        $state1->nombre="Pendiente";
        $state1->save();

        $state2 = new State();
        $state2->nombre="Realizada";
        $state2->save();

        $state3 = new State();
        $state3->nombre="Cancelada";
        $state3->save();
    }
}
