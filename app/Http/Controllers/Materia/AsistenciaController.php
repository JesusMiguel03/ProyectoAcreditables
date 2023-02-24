<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación.
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso.
        permiso('asistencias');

        // Busca a todos los estudiantes inscritos.
        $estudiantes = Estudiante_materia::all();

        if (rol('Profesor')) {
            $profesor = auth()->user()->profesor;

            if ($profesor) {
                $estudiantesProfesor = [];

                foreach ($estudiantes as $estudiante) {

                    if ($estudiante->tieneProfesor() === $profesor->id) array_push($estudiantesProfesor,  $estudiante);
                }
            }

            $estudiantes = $estudiantesProfesor;
        }

        $asistenciaEstudiantes = [];

        foreach ($estudiantes as $estudiante) {

            // Selecciona la asistencia
            $asistencia = $estudiante->esEstudiante->asistencia;

            $asistencias = 0;

            // Suma cada asistencia
            for ($i = 1; $i <= 12; $i++) {
                $sem = 'sem' . $i;

                if (!empty($asistencia)) $asistencia[$sem] === 1 ? $asistencias++ : '';
            }

            // Guarda el total de asistencias
            array_push($asistenciaEstudiantes, $asistencias);
        }

        return view('materias.asistencias.index', compact('estudiantes', 'asistenciaEstudiantes'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('asistencias');

        $asistencia = Estudiante::find($id)->asistencia;

        // Si tiene asistencia esa semana, activa el checkbox
        for ($i = 1; $i <= 12; $i++) {
            $campo = 'sem' . $i;
            $asistencia[$campo] = $request[$campo] === 'on' ? 1 : 0;
        }
        $asistencia->save();

        return redirect()->back()->with('registrado', 'registrado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('asistencias');

        // Busca al estudiante y su asistencia
        $estudiante = Estudiante_materia::find($id);

        // Valida que tenga perfil de estudiante o esté inscrito en una materia
        if (!$estudiante || $estudiante->validado === 0) {
            return redirect()->back()->with('no puede participar', 'no puede');
        }

        $asistencia = $estudiante->asistencia;

        // Se inicializan el contador
        $asistencias = 0;

        // Añade las asistencias
        for ($i = 1; $i <= 12; $i++) {
            $sem = 'sem' . $i;
            $asistencia[$sem] === null ? $asistencias++ : '';
        }

        return view('materias.asistencias.edit', compact('estudiante', 'asistencias'));
    }
}
