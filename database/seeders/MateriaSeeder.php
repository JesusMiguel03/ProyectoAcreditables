<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Materia\Materia::factory()->count(10)->create();
    }
}
