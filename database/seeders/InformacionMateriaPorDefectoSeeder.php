<?php

namespace Database\Seeders;

use App\Models\Materia\Categoria;
use App\Models\Profesor\Profesor;
use Illuminate\Database\Seeder;

class InformacionMateriaPorDefectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nom_categoria' => 'Sin asignar'
        ]);
        Profesor::create([
            'usuario_id' => 2,
            'telefono' => 00000000000,
            'titulo' => 'Sin asignar',
            'direccion' => 'Sin asignar',
            'ciudad' => 'Sin asignar',
            'estado' => 'Sin asignar',
            'fecha_de_nacimiento' => '2000-01-01',
            'fecha_ingreso_institucion' => '2000-01-01',
            'estado_profesor' => '0',
        ]);
    }
}
