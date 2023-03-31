<?php

namespace Database\Seeders;

use App\Models\Academico\Trayecto;
use Illuminate\Database\Seeder;

class TrayectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trayecto::create([
            'num_trayecto' => 1
        ]);
        Trayecto::create([
            'num_trayecto' => 2
        ]);
        Trayecto::create([
            'num_trayecto' => 3
        ]);
        Trayecto::create([
            'num_trayecto' => 4
        ]);
        Trayecto::create([
            'num_trayecto' => 5
        ]);
    }
}
