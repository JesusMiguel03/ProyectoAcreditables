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
            'cedula' => '11111111',
            'email' => 'u1@email.com',
            'password' => bcrypt('password'),
        ]);
        $estudiante->assignRole('Estudiante');

        $profesor = User::create([
            'nombre' => 'Ana',
            'apellido' => 'Flores',
            'cedula' => '11111112',
            'email' => 'u2@email.com',
            'password' => bcrypt('password'),
        ]);
        $profesor->assignRole('Profesor');

        $coordinador = User::create([
            'nombre' => 'Luis',
            'apellido' => 'Santander',
            'cedula' => '11111113',
            'email' => 'u3@email.com',
            'password' => bcrypt('password'),
        ]);
        $coordinador->assignRole('Coordinador');
    }
}
