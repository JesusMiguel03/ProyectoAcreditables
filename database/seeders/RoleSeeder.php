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

        // Lista y gestión de usuarios
        Permission::create(['name' => 'usuarios'])->syncRoles([$coordinador]);

        // Materias
        Permission::create(['name' => 'gestionar.materias'])->syncRoles([$coordinador]);
        
        Permission::create(['name' => 'materias.index'])->syncRoles([$estudiante, $profesor, $coordinador]);
        Permission::create(['name' => 'materias.create'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'materias.store'])->syncRoles($coordinador);
        Permission::create(['name' => 'materias.update'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'materias.show'])->syncRoles([$estudiante, $profesor, $coordinador]);
        Permission::create(['name' => 'materias.edit'])->syncRoles([$coordinador]);

        // Preinscripcion en materia
        Permission::create(['name' => 'preinscribir'])->syncRoles([$estudiante]);

        // Preguntas frecuentes
        Permission::create(['name' => 'preguntas'])->syncRoles([$estudiante, $profesor, $coordinador]);

        // Cuenta
        Permission::create(['name' => 'ver.perfil'])->syncRoles([$estudiante, $profesor, $coordinador]);
    }
}
