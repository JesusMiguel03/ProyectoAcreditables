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

        // Acciones de Coordinador
        Permission::create(['name' => 'registrar.usuario'])->syncRoles([$coordinador]);

        // Inicio
        Permission::create(['name' => 'inicio'])->syncRoles([$estudiante, $profesor, $coordinador]);
        
        // Periodo
        Permission::create(['name' => 'periodo'])->syncRoles([$coordinador]);
        
        // Área de Conocimiento, profesores, estudiantes
        Permission::create(['name' => 'registrar'])->syncRoles([$coordinador]);
        
        // Categorias
        Permission::create(['name' => 'categorias'])->syncRoles([$coordinador]);
        
        // Horarios
        Permission::create(['name' => 'horarios'])->syncRoles([$coordinador]);
        
        // Inscripcion
        Permission::create(['name' => 'inscribir'])->syncRoles([$estudiante]);

        // Materias
        Permission::create(['name' => 'materias.principal'])->syncRoles([$profesor, $coordinador]);
        Permission::create(['name' => 'materias.estudiante'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'materias.modificar'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'materias.inscribir'])->syncRoles([$estudiante, $coordinador]);
        Permission::create(['name' => 'validar.estudiante'])->syncRoles([$coordinador]);
        
        // Estudiante
        Permission::create(['name' => 'estudiante'])->syncRoles([$estudiante]);

        // Asistencias
        Permission::create(['name' => 'asistencias'])->syncRoles([$profesor, $coordinador]);

        // Pnfs, trayectos
        Permission::create(['name' => 'academico'])->syncRoles([$coordinador]);
        
        // Información
        Permission::create(['name' => 'noticias'])->syncRoles([$coordinador]);
        Permission::create(['name' => 'preguntas.principal'])->syncRoles([$estudiante, $profesor, $coordinador]);
        Permission::create(['name' => 'preguntas.modificar'])->syncRoles([$coordinador]);

        // Cuenta
        Permission::create(['name' => 'perfil'])->syncRoles([$estudiante, $profesor, $coordinador]);
        
        // Soporte
        Permission::create(['name' => 'soporte'])->syncRoles([$coordinador]);

        // Gráficos y estadísticas
        Permission::create(['name' => 'estadisticas'])->syncRoles([$coordinador]);
    }
}
