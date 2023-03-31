<?php

namespace Database\Seeders;

use App\Models\Informacion\Noticia;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $noticias = [
            ['titulo' => 'Nueva acreditable', 'desc' => 'Panadería ha sido añadida'],
            ['titulo' => 'Actividad extracurricular', 'desc' => 'Si necesitas algunos puntos'],
            ['titulo' => 'Encuesta', 'desc' => '¿Nuevas actividades o acreditables?'],
            ['titulo' => 'Acreditable modificada', 'desc' => 'Baloncesto solo estará disponible para 2 y 3 trayecto'],
            ['titulo' => 'Posibles cambios', 'desc' => 'Cambios de interfaz en el apartado de inicio'],
            ['titulo' => 'Materias descontinuadas', 'desc' => 'Coral y Primeros Auxilios no serán cursables este trimestre'],
            ['titulo' => 'Culminación de trimestre', 'desc' => 'Este 18 de abril termina el periodo'],
            ['titulo' => 'Apertura de inscripciones', 'desc' => 'A partir del 5 de marzo se abrirán las incripciones'],
            ['titulo' => 'Promedios regulares', 'desc' => 'Muchas inasistencias el periodo pasado'],
            ['titulo' => 'Acreditables demandadas', 'desc' => 'Ortografía puede ser descontinuadas en el siguiente periodo'],
            ['titulo' => 'En mantenimiento', 'desc' => 'Desde el 20 al 24 de febrero se suspenderá la página'],
            ['titulo' => '¿Apertura oficial?', 'desc' => 'Apertura del componente al público'],
            ['titulo' => 'Población flotante', 'desc' => 'La cantidad de estudiantes flotantes supera la espectativa'],
        ];

        foreach ($noticias as $noticia) {
            Noticia::create([
                'titulo' => $noticia['titulo'],
                'desc_noticia' => $noticia['desc'],
                'activo' => 1
            ]);
        }
    }
}
