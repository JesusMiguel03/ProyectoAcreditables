<?php

namespace Database\Seeders;

use App\Models\Academico\Trayecto;
use App\Models\Materia\Materia;
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
        $materias = [
            ['nombre' => 'Cocina', 'desc' => 'Aprende acerca de las artes culinarias'],
            ['nombre' => 'Panadería', 'desc' => 'Los panes es algo más que solo masa y levadura'],
            ['nombre' => 'Manualidades', 'desc' => 'Bordados o decoraciones'],
            ['nombre' => 'Turismo', 'desc' => 'Comprende tu alrededor'],
            ['nombre' => 'Publicidad', 'desc' => 'El arte de vender con la vista'],
            ['nombre' => 'Deporte', 'desc' => 'Actividad física para el cuerpo'],
            ['nombre' => 'Danzas', 'desc' => 'Bailes interpretativos'],
            ['nombre' => 'Agricultura', 'desc' => 'Cuidado de la tierra'],
        ];

        foreach ($materias as $materia) {
            $cupos = rand(1, 50);
    
            Materia::create([
                'informacion_id' => null,
                'trayecto_id' => Trayecto::find(1)->id,
                'nom_materia' => $materia['nombre'],
                'cupos' => $cupos,
                'cupos_disponibles' => $cupos,
                'desc_materia' => $materia['desc'],
                'estado_materia' => 'Activo',
            ]);
        }
    }
}
