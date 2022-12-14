<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $estudiantes = Estudiante::all();
        $asistenciaEstudiantes = [];

        foreach ($estudiantes as $estudiante) {
            $asistencia = $estudiante->asistencia;

            // Se inicializan los contadores
            $asistencias = 0;

            // Añade las asistencias
            for ($i = 1; $i <= 12; $i++) {
                $sem = 'sem' . $i;
                $asistencia[$sem] === 1 ? $asistencias++ : '';
            }

            array_push($asistenciaEstudiantes, $asistencias);
        }

        return view('aside.materias.asistencias.index', compact('estudiantes', 'asistenciaEstudiantes', 'periodo'));
    }

    public function update(Request $request)
    {
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
        // Busca al estudiante y su asistencia
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $estudiante = Estudiante::find($id);

        // Valida que tenga perfil de estudiante o esté inscrito en una materia
        if (!$estudiante || !$estudiante->preinscrito) {
            return redirect()->back();
        }

        $asistencia = $estudiante->asistencia;

        // Se inicializan el contador
        $asistencias = 0;

        // Añade las asistencias
        for ($i = 1; $i <= 12; $i++) {
            $sem = 'sem' . $i;
            $asistencia[$sem] === 1 ? $asistencias++ : '';
        }

        return view('aside.materias.asistencias.edit', compact('estudiante', 'asistencias', 'periodo'));
    }
}
