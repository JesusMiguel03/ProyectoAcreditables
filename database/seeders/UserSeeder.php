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
        $student = User::create([
            'name' => 'User1',
            'cedula' => '11111111',
            'email' => 'u1@email.com',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole('Estudiante');

        $professor = User::create([
            'name' => 'User2',
            'cedula' => '11111112',
            'email' => 'u2@email.com',
            'password' => bcrypt('password'),
        ]);
        $professor->assignRole('Profesor');

        $coordinator = User::create([
            'name' => 'User3',
            'cedula' => '11111113',
            'email' => 'u3@email.com',
            'password' => bcrypt('password'),
        ]);
        $coordinator->assignRole('Coordinador');
    }
}
