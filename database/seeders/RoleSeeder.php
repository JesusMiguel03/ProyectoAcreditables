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
        $student = Role::create(['name' => 'Estudiante']);
        $professor = Role::create(['name' => 'Profesor']);
        $coordinator = Role::create(['name' => 'Coordinador']);

        Permission::create(['name' => 'student.index'])->syncRoles([$student]);
        Permission::create(['name' => 'professor.index'])->syncRoles([$professor]);
        Permission::create(['name' => 'coordinator.index'])->syncRoles([$coordinator]);
        
        Permission::create(['name' => 'courses.index'])->syncRoles([$student, $professor, $coordinator]);
        Permission::create(['name' => 'courses.create'])->syncRoles([$coordinator]);
        Permission::create(['name' => 'courses.store'])->syncRoles([$coordinator]);
        Permission::create(['name' => 'courses.update'])->syncRoles([$coordinator]);
        Permission::create(['name' => 'courses.show'])->syncRoles([$student, $professor, $coordinator]);
        Permission::create(['name' => 'courses.edit'])->syncRoles([$coordinator]);
        Permission::create(['name' => 'courses.destroy'])->syncRoles([$coordinator]);

        Permission::create(['name' => 'faq']);

        Permission::create(['name' => 'profile.show']);
    }
}
