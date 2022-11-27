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
            'nom_pnf' => 'Administración'
        ]);
        Pnf::create([
            'nom_pnf' => 'Agroalimentación'
        ]);
        Pnf::create([
            'nom_pnf' => 'Contaduría Pública'
        ]);
        Pnf::create([
            'nom_pnf' => 'Electricidad'
        ]);
        Pnf::create([
            'nom_pnf' => 'Electrónica'
        ]);
        Pnf::create([
            'nom_pnf' => 'Informática'
        ]);
        Pnf::create([
            'nom_pnf' => 'Instrumentación y Control'
        ]);
        Pnf::create([
            'nom_pnf' => 'Mantenimiento'
        ]);
        Pnf::create([
            'nom_pnf' => 'Mecánica'
        ]);
        Pnf::create([
            'nom_pnf' => 'Sistemas de Calidad y Ambiente'
        ]);
        Pnf::create([
            'nom_pnf' => 'Telecomunicaciones'
        ]);
    }
}
