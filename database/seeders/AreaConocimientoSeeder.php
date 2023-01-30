<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreaConocimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Academico\AreaConocimiento::factory()->count(10)->create();
    }
}
