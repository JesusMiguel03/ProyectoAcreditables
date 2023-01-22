<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estudiante = User::create([
            'nombre' => 'Marco',
            'apellido' => 'Andrade',
            'nacionalidad' => 'V',
            'cedula' => '1111111',
            'email' => 'u1@email.com',
            'password' => bcrypt('password'),
        ]);
        $estudiante->assignRole('Estudiante');

        $profesor = User::create([
            'nombre' => 'Ana',
            'apellido' => 'Flores',
            'nacionalidad' => 'V',
            'cedula' => '1111112',
            'email' => 'u2@email.com',
            'password' => bcrypt('password'),
        ]);
        $profesor->assignRole('Profesor');

        $coordinador = User::create([
            'nombre' => 'Luis',
            'apellido' => 'Santander',
            'nacionalidad' => 'V',
            'cedula' => '1111113',
            'email' => 'u3@email.com',
            'password' => bcrypt('password'),
        ]);
        $coordinador->assignRole('Coordinador');

        $estudiante1 = User::create([
            'nombre' => 'Andrea',
            'apellido' => 'Nuñez',
            'nacionalidad' => 'V',
            'cedula' => '1111114',
            'email' => 'u4@email.com',
            'password' => bcrypt('password'),
        ]);
        $estudiante1->assignRole('Estudiante');

        $estudiante1 = User::create([
            'nombre' => 'Luisa',
            'apellido' => 'Muñoz',
            'nacionalidad' => 'V',
            'cedula' => '1111115',
            'email' => 'u5@email.com',
            'password' => bcrypt('password'),
        ]);
        $estudiante1->assignRole('Estudiante');

        $estudiante1 = User::create([
            'nombre' => 'Marcus',
            'apellido' => 'Perez',
            'nacionalidad' => 'V',
            'cedula' => '1111116',
            'email' => 'u6@email.com',
            'password' => bcrypt('password'),
        ]);
        $estudiante1->assignRole('Profesor');
    }
}
