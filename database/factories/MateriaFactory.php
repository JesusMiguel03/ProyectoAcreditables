<?php

namespace Database\Factories;

use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

class MateriaFactory extends Factory
{
    protected $model = Materia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cupos = rand(1, 50);

        $materias = [
            0 => 'Cocina',
            1 => 'Panadería',
            2 => 'Manualidades',
            3 => 'Turismo',
            4 => 'Publicidad',
            5 => 'Dominó',
            6 => 'Ajedrez',
            7 => 'Deporte',
            8 => 'Danzas',
            9 => 'Agricultura',
            10 => 'Coral',
            11 => 'Análisis',
            12 => 'Baloncesto'
        ];

        $materias_estados = [
            'Activo', 'Inactivo'
        ];

        return [
            'informacion_id' => null,
            'nom_materia' => $materias[array_rand($materias)],
            'cupos' => $cupos,
            'cupos_disponibles' => $cupos,
            'num_acreditable' => rand(1, 4),
            'desc_materia' => $this->faker->text,
            'estado_materia' => $materias_estados[array_rand($materias_estados)]
        ];
    }
}
