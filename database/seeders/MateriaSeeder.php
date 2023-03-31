<?php

namespace Database\Seeders;

use App\Models\Academico\Profesor;
use App\Models\Academico\Trayecto;
use App\Models\Materia\Categoria;
use App\Models\Materia\Informacion_materia;
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
            ['nombre' => 'Economía', 'desc' => 'El dinero y su valor real'],
            ['nombre' => 'Artes', 'desc' => 'La pintura y el diseño'],
            ['nombre' => 'Ofimática', 'desc' => 'Herramientas de oficina que usas a diario y como sacarle el máximo provecho'],
            ['nombre' => 'Carpintería', 'desc' => 'El arte de la madera'],
            ['nombre' => 'Arquitectura', 'desc' => 'Edificios y su infraestructura'],
            ['nombre' => 'Geología', 'desc' => 'Estudio de la tierra'],
            ['nombre' => 'Ecología', 'desc' => 'La naturaleza y el ambiente'],
            ['nombre' => 'Ajedrez', 'desc' => 'Destreza y agilidad mental, toma de decisiones y seguridad en tus decisiones'],
            ['nombre' => 'Primeros auxilios', 'desc' => 'Cómo atender a un herido en situaciones frecuentes'],
            ['nombre' => 'Biología', 'desc' => 'Seres vivos y microorganismos'],
            ['nombre' => 'Quiropráctica', 'desc' => 'Realiza ajustes de la columna u otras partes del cuerpo para corregir problemas posturales o aliviar el dolor'],
            ['nombre' => 'Finanzas', 'desc' => 'Estudia el intercambio de capital entre individuos, empresas, o Estados y con la incertidumbre y el riesgo que estas actividades conllevan'],
            ['nombre' => 'Pedagogía', 'desc' => 'Ciencia social e interdisciplinaria enfocada en la investigación y reflexión de las teorías educativas en todas las etapas de la vida, no solo en la infancia.'],
            ['nombre' => 'Diseño gráfico', 'desc' => 'Se encargan de transmitir un mensaje o una idea mediante la comunicación visual. Su función principal es crear la imagen y el estilo estético de las empresas, ya que esa es la forma en la que se van a dar a conocer'],
            ['nombre' => 'Análisis de datos', 'desc' => 'Trabaja con grandes cantidades de datos. Su trabajo consiste en hacerse preguntas de negocio, recopilar datos, identificar información útil de los datos y estructurar sus hallazgos en cuadros de mandos fáciles de leer.']
        ];

        foreach ($materias as $materia) {
            $cupos = 50;
            $metodologias = ['Teórico', 'Práctico', 'Teórico-práctico'];

            $info = Informacion_materia::create([
                'metodologia' => $metodologias[array_rand($metodologias)],
                'categoria_id' => Categoria::find(rand(1, 12))->id,
                'profesor_id' => null,
                'horario_id' => null
            ]);
    
            Materia::create([
                'informacion_id' => $info->id,
                'trayecto_id' => Trayecto::find(rand(1, 5))->id,
                'nom_materia' => $materia['nombre'],
                'cupos' => $cupos,
                'cupos_disponibles' => $cupos,
                'desc_materia' => $materia['desc'],
                'estado_materia' => 'Activo',
            ]);
        }
    }
}
