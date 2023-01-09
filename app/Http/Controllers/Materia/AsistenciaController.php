<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Materia\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('asistencias');

        $periodo = periodoActual();
        $estudiantes = Estudiante_materia::all();

        $asistenciaEstudiantes = [];

        foreach ($estudiantes as $estudiante) {
            $asistencia = $estudiante->esEstudiante->asistencia;

            $asistencias = 0;

            for ($i = 1; $i <= 12; $i++) {
                $sem = 'sem' . $i;
                $asistencia[$sem] === 1 ? $asistencias++ : '';
            }

            array_push($asistenciaEstudiantes, $asistencias);
        }

        return view('materias.asistencias.index', compact('estudiantes', 'asistenciaEstudiantes', 'periodo'));
    }

    public function update(Request $request)
    {
        // Valida si tiene el permiso
        permiso('asistencias');

        $asistencia = Estudiante::find($request->get('id'))->asistencia;

        for ($i = 1; $i <= 12; $i++) {
            $campo = 'sem' . $i;
            $asistencia[$campo] = $request->get($campo) === 'on' ? 1 : 0;
        }
        $asistencia->save();

        return redirect()->back()->with('registrado', 'registrado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('asistencias');

        // Busca al estudiante y su asistencia
        $estudiante = Estudiante::find($id);
        $periodo = periodoActual();

        // Valida que tenga perfil de estudiante o esté inscrito en una materia
        if (!$estudiante || $estudiante->inscrito->validacion_estudiante === 0) {
            return redirect()->back()->with('no puede participar', 'no puede');
        }

        $asistencia = $estudiante->asistencia;

        // Se inicializan el contador
        $asistencias = 0;

        // Añade las asistencias
        for ($i = 1; $i <= 12; $i++) {
            $sem = 'sem' . $i;
            $asistencia[$sem] === 1 ? $asistencias++ : '';
        }

        return view('materias.asistencias.edit', compact('estudiante', 'asistencias', 'periodo'));
    }
}
