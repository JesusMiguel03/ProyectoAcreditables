<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estudiante = Role::create(['name' => 'Estudiante']);
        $profesor = Role::create(['name' => 'Profesor']);
        $coordinador = Role::create(['name' => 'Coordinador']);

        // Inicio
        Permission::create(['name' => 'home'])->syncRoles([$estudiante, $profesor, $coordinador]);

        // Perfiles
        Permission::create(['name' => 'perfiles'])->syncRoles([$coordinador]);

        // Acreditables
        Permission::create(['name' => 'materias.gestion'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'materias'])->syncRoles([$estudiante, $profesor]);

        Permission::create(['name' => 'categorias'])->syncRoles([$coordinador]);

        // Preinscripcion en materia
        Permission::create(['name' => 'preinscribir'])->syncRoles([$estudiante]);

        // Datos académicos
        Permission::create(['name' => 'pnf'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'trayecto'])->syncRoles([$coordinador]);

        // Información
        Permission::create(['name' => 'preguntas.create'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'noticias.create'])->syncRoles([$coordinador]);
        
        Permission::create(['name' => 'preguntas'])->syncRoles([$estudiante, $profesor, $coordinador]);
        Permission::create(['name' => 'noticias'])->syncRoles([$estudiante, $profesor, $coordinador]);

        // Cuenta
        Permission::create(['name' => 'ver.perfil'])->syncRoles([$estudiante, $profesor, $coordinador]);
    }
}
