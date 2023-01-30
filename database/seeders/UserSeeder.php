<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Coordinador
        User::create([
            'nombre' => 'Luis',
            'apellido' => 'Santander',
            'nacionalidad' => 'V',
            'cedula' => '1111113',
            'email' => 'u6@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Coordinador');

        // Estudiante
        User::create([
            'nombre' => 'Marco',
            'apellido' => 'Andrade',
            'nacionalidad' => 'V',
            'cedula' => '1111111',
            'email' => 'u1@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Estudiante');

        User::create([
            'nombre' => 'Andrea',
            'apellido' => 'Nuñez',
            'nacionalidad' => 'V',
            'cedula' => '1111114',
            'email' => 'u2@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Estudiante');

        User::create([
            'nombre' => 'Luisa',
            'apellido' => 'Muñoz',
            'nacionalidad' => 'V',
            'cedula' => '1111115',
            'email' => 'u3@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Estudiante');

        // Profesor
        User::create([
            'nombre' => 'Ana',
            'apellido' => 'Flores',
            'nacionalidad' => 'V',
            'cedula' => '1111112',
            'email' => 'u4@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Profesor');

        User::create([
            'nombre' => 'Marcus',
            'apellido' => 'Perez',
            'nacionalidad' => 'V',
            'cedula' => '1111116',
            'email' => 'u5@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Profesor');

        \App\Models\User::factory()->count(20)->create()->each(function ($usuario) {
            $usuario->assignRole(rand(1, 2) === 1 ? 'Estudiante' : 'Profesor');
        });
    }
}
