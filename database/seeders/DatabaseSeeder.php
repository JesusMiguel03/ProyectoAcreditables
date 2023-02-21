<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Estático
        $this->call(TrayectoSeeder::class);
        $this->call(PNFSeeder::class);
        $this->call(PreguntasFrecuentesSeeder::class);
        $this->call(RoleSeeder::class);

        // Pruebas
        $this->call(CategoriaSeeder::class);
        $this->call(MateriaSeeder::class);
        $this->call(AreaConocimientoSeeder::class);
        $this->call(NoticiaSeeder::class);
        $this->call(UserSeeder::class);
    }
}
