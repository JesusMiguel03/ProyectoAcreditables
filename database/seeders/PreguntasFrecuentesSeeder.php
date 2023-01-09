<?php

namespace Database\Seeders;

use App\Models\Informacion\Pregunta_frecuente;
use Illuminate\Database\Seeder;

class PreguntasFrecuentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pregunta_frecuente::create([
            'titulo' => 'Qué son',
            'explicacion' => 'Una formación con enfoque curricular asumido por los diferentes programas nacionales de formación a ser impartidos en las instituciones de educación universitaria, comprende la interacción de sus participantes en manifestaciones artísticas y culturales',
        ]);
        Pregunta_frecuente::create([
            'titulo' => 'Cómo funcionan',
            'explicacion' => 'Estas se consideran como cualquier otra unidad curricular, pueden ser tanto prácticas, teóricas o ambas, en base a la metodología que desee emplear el profesor encargado',
        ]);
        Pregunta_frecuente::create([
            'titulo' => 'Cómo me afectan',
            'explicacion' => 'Para optar por tu título de TSU debes cursar (2) acreditables en cualquiera de los (3) trimestres que componen el año y otras (2) acreditables para culminar la carrera',
        ]);
        Pregunta_frecuente::create([
            'titulo' => 'Cuáles son las opciones',
            'explicacion' => "Las acreditables se aperturan al inicio de cada trimestre y tienen una duración de (3) meses cada una, estas pueden ser teóricas, prácticas o una combinación de ambas",
        ]);
        Pregunta_frecuente::create([
            'titulo' => 'Cómo puedo ver mi nota',
            'explicacion' => 'En progreso...',
        ]);
    }
}
