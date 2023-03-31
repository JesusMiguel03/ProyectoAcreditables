<?php

namespace Database\Seeders;

use App\Models\Academico\AreaConocimiento;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Periodo;
use App\Models\Academico\PNF;
use App\Models\Academico\Profesor;
use App\Models\Academico\Trayecto;
use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use App\Models\User;
use Illuminate\Support\Str;
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
        $estudiante = User::create([
            'nombre' => 'Marco',
            'apellido' => 'Andrade',
            'nacionalidad' => 'V',
            'cedula' => '1111111',
            'email' => 'u1@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Estudiante');

        Estudiante::create([
            'pnf_id' => PNF::find(4)->id,
            'trayecto_id' => Trayecto::find(1)->id,
            'usuario_id' => $estudiante->id,
        ]);

        $estudiante = User::create([
            'nombre' => 'Andrea',
            'apellido' => 'Nuñez',
            'nacionalidad' => 'V',
            'cedula' => '1111114',
            'email' => 'u2@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Estudiante');

        Estudiante::create([
            'pnf_id' => PNF::find(4)->id,
            'trayecto_id' => Trayecto::find(1)->id,
            'usuario_id' => $estudiante->id,
        ]);

        $estudiante = User::create([
            'nombre' => 'Luisa',
            'apellido' => 'Muñoz',
            'nacionalidad' => 'V',
            'cedula' => '1111115',
            'email' => 'u3@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Estudiante');

        Estudiante::create([
            'pnf_id' => PNF::find(4)->id,
            'trayecto_id' => Trayecto::find(1)->id,
            'usuario_id' => $estudiante->id,
        ]);

        // Profesor
        $profesor = User::create([
            'nombre' => 'Ana',
            'apellido' => 'Flores',
            'nacionalidad' => 'V',
            'cedula' => '1111112',
            'email' => 'u4@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Profesor');

        Profesor::create([
            'usuario_id' => $profesor->id,
            'conocimiento_id' => AreaConocimiento::find(rand(1, 10))->id,
            'departamento_id' => PNF::find(rand(1, 11))->id,
            'telefono' => '04005406303',
            'casa' => '1',
            'calle' => '1',
            'urb' => '1',
            'ciudad' => '1',
            'estado' => '1',
            'fecha_de_nacimiento' => '1980-01-01',
            'fecha_ingreso_institucion' => '2000-01-01',
            'activo' => 1
        ]);

        $profesor = User::create([
            'nombre' => 'Marcus',
            'apellido' => 'Perez',
            'nacionalidad' => 'V',
            'cedula' => '1111116',
            'email' => 'u5@email.com',
            'password' => bcrypt('password'),
        ])->assignRole('Profesor');

        Profesor::create([
            'usuario_id' => $profesor->id,
            'conocimiento_id' => AreaConocimiento::find(rand(1, 10))->id,
            'departamento_id' => PNF::find(rand(1, 11))->id,
            'telefono' => '04005406302',
            'casa' => '1',
            'calle' => '1',
            'urb' => '1',
            'ciudad' => '1',
            'estado' => '1',
            'fecha_de_nacimiento' => '1980-01-01',
            'fecha_ingreso_institucion' => '2000-01-01',
            'activo' => 1
        ]);

        \App\Models\User::factory()->count(1000)->create()->each(function ($usuario) {
            $rol = rand(1, 2) === 1 ? 'Estudiante' : 'Profesor';
            $usuario->assignRole($rol);

            if ($rol === 'Estudiante') {
                $estudiante = Estudiante::create([
                    'pnf_id' => PNF::find(rand(4, 8))->id,
                    'trayecto_id' => Trayecto::find(rand(1, 5))->id,
                    'usuario_id' => $usuario->id,
                ]);

                $asistencia = Asistencia::create([
                    'sem1' => 0,
                    'sem2' => 0,
                    'sem3' => 0,
                    'sem4' => 0,
                    'sem5' => 0,
                    'sem6' => 0,
                    'sem7' => 0,
                    'sem8' => 0,
                    'sem9' => 0,
                    'sem10' => 0,
                    'sem11' => 0,
                    'sem12' => 0,
                ]);

                $materias = Materia::where('trayecto_id', '=', $estudiante->trayecto_id)->get();

                $materia = $materias->random();

                if ($materia->cupos_disponibles === 0) {
                    $materia = $materias->random();
                }

                Estudiante_materia::create([
                    'periodo_id' => Periodo::find(1)->id,
                    'materia_id' => $materia->id,
                    'estudiante_id' => $estudiante->id,
                    'asistencia_id' => $asistencia->id,
                    'nota' => 0,
                    'codigo' => Str::random(6),
                    'validado' => 1,
                    'aprobado' => null
                ]);

                $materia = Materia::find($materia->id);
                $materia->update(['cupos_disponibles' => $materia->cupos_disponibles - 1]);
            } else {
                Profesor::create([
                    'usuario_id' => $usuario->id,
                    'conocimiento_id' => AreaConocimiento::find(rand(1, 10))->id,
                    'departamento_id' => PNF::find(rand(1, 11))->id,
                    'telefono' => '0500' . rand(1000000, 9999999),
                    'casa' => '1',
                    'calle' => '1',
                    'urb' => '1',
                    'ciudad' => '1',
                    'estado' => '1',
                    'fecha_de_nacimiento' => '1980-01-01',
                    'fecha_ingreso_institucion' => '2000-01-01',
                    'activo' => 1
                ]);
            }
        });
    }
}
