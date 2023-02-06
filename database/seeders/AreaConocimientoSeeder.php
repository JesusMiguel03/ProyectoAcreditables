<?php

namespace Database\Seeders;

use App\Models\Academico\AreaConocimiento;
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
        $areas = [
            ['nombre' => 'Seguridad informática', 'desc' => 'Ataques DDOS, troyanos, malware, zero day.'],
            ['nombre' => 'Carpintería', 'desc' => 'Técnicas y trucos con la madera.'],
            ['nombre' => 'Cocina', 'desc' => 'Platillos delicados y uso correcto de ingredientes.'],
            ['nombre' => 'Actividad física', 'desc' => 'Entrena el cuerpo a través del deporte.'],
            ['nombre' => 'Juegos recreacionales', 'desc' => 'Ajedrez, dominó, ludo, ping pong.'],
            ['nombre' => 'Coral', 'desc' => 'Canto y tonadas.'],
            ['nombre' => 'Castellano', 'desc' => 'Ortografía, redacción y análisis.'],
            ['nombre' => 'Ciencias', 'desc' => 'Física, química, biología.'],
            ['nombre' => 'Manualidades', 'desc' => 'Costura y bordado.'],
            ['nombre' => 'Panadería', 'desc' => 'Horneado y técnicas.'],
        ];

        foreach ($areas as $area) {
            AreaConocimiento::create([
                'nom_conocimiento' => $area['nombre'],
                'desc_conocimiento' => $area['desc']
            ]);
        }
    }
}
