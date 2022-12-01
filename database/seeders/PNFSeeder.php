<?php

namespace Database\Seeders;

use App\Models\DatosAcademicos\Pnf;
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
        Pnf::create([
            'nom_pnf' => 'Administración',
            'cod_pnf' => '?'
        ]);
        Pnf::create([
            'nom_pnf' => 'Agroalimentación',
            'cod_pnf' => '?'
        ]);
        Pnf::create([
            'nom_pnf' => 'Contaduría Pública',
            'cod_pnf' => '?'
        ]);
        Pnf::create([
            'nom_pnf' => 'Electricidad',
            'cod_pnf' => 'PEUA'
        ]);
        Pnf::create([
            'nom_pnf' => 'Electrónica',
            'cod_pnf' => 'PLUA'
        ]);
        Pnf::create([
            'nom_pnf' => 'Informática',
            'cod_pnf' => 'PIUA'
        ]);
        Pnf::create([
            'nom_pnf' => 'Instrumentación y Control',
            'cod_pnf' => 'PCUN'
        ]);
        Pnf::create([
            'nom_pnf' => 'Mantenimiento',
            'cod_pnf' => 'PNAA'
        ]);
        Pnf::create([
            'nom_pnf' => 'Mecánica',
            'cod_pnf' => 'No ve'
        ]);
        Pnf::create([
            'nom_pnf' => 'Sistemas de Calidad y Ambiente',
            'cod_pnf' => '?'
        ]);
        Pnf::create([
            'nom_pnf' => 'Telecomunicaciones',
            'cod_pnf' => 'PTUA'
        ]);
    }
}
