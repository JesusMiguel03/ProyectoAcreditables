<?php

namespace Database\Seeders;

use App\Models\Academico\PNF;
use Illuminate\Database\Seeder;

class PNFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PNF::create([
            'nom_pnf' => 'Administración',
            'cod_pnf' => null,
            'trayectos' => 0
        ]);
        PNF::create([
            'nom_pnf' => 'Agroalimentación',
            'cod_pnf' => null,
            'trayectos' => 0
        ]);
        PNF::create([
            'nom_pnf' => 'Contaduría Pública',
            'cod_pnf' => null,
            'trayectos' => 0
        ]);
        PNF::create([
            'nom_pnf' => 'Electricidad',
            'cod_pnf' => 'PEUA',
            'trayectos' => 5
        ]);
        PNF::create([
            'nom_pnf' => 'Electrónica',
            'cod_pnf' => 'PLUA',
            'trayectos' => 5
        ]);
        PNF::create([
            'nom_pnf' => 'Informática',
            'cod_pnf' => 'PIUA',
            'trayectos' => 4
        ]);
        PNF::create([
            'nom_pnf' => 'Instrumentación y Control',
            'cod_pnf' => 'PCUN',
            'trayectos' => 5
        ]);
        PNF::create([
            'nom_pnf' => 'Mantenimiento',
            'cod_pnf' => 'PNAA',
            'trayectos' => 2
        ]);
        PNF::create([
            'nom_pnf' => 'Mecánica',
            'cod_pnf' => null,
            'trayectos' => 0
        ]);
        PNF::create([
            'nom_pnf' => 'Sistemas de Calidad y Ambiente',
            'cod_pnf' => null,
            'trayectos' => 0
        ]);
        PNF::create([
            'nom_pnf' => 'Telecomunicaciones',
            'cod_pnf' => 'PTUA',
            'trayectos' => 3
        ]);
    }
}
