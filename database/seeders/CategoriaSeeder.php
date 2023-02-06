<?php

namespace Database\Seeders;

use App\Models\Materia\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            0 => 'Juegos de mesa',
            1 => 'Cocina',
            2 => 'Manualidades',
            3 => 'Ingeniería',
            4 => 'Recreación',
            5 => 'Deporte',
            6 => 'Ciencias sociales',
            7 => 'Ciencias naturales',
            8 => 'Economía',
            9 => 'Medicina',
            10 => 'Marketing',
            11 => 'Cultura',
        ];

        for ($i = 0; $i < count($categorias); $i++) {
            Categoria::create([
                'nom_categoria' => $categorias[$i]
            ]);
        }
    }
}
