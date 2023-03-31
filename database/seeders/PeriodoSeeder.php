<?php

namespace Database\Seeders;

use App\Models\Academico\Periodo;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::create([
            'fase' => 1,
            'inicio' => '2023-03-01',
            'fin' => '2023-03-31',
        ]);
    }
}
