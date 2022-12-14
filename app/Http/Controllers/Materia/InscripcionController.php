<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\DatosAcademicos\Estudiante_materia;
use App\Models\Estudiante;
use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscripcionController extends Controller
{
    public function inscribir($id)
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $estudiantes = Estudiante::all();
        $no_preinscritos = [];

        foreach ($estudiantes as $estudiante) {
            if (empty($estudiante->preinscrito)) {
                array_push($no_preinscritos, $estudiante);
            }
        }

        $materia = Materia::find($id);
        return view('aside.materias.acreditables.preinscribir', compact('no_preinscritos', 'materia', 'periodo'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $estudiantes = $request->get('estudiantes');

        foreach ($estudiantes as $estudiante) {
            Estudiante_materia::updateOrCreate(
                ['estudiante_id' => $estudiante],
                [
                    'calificacion' => 0,
                    'codigo' => Str::random(20),
                    'validacion_estudiante' => 0,
                    'materia_id' => $request->get('materia_id'),
                    'asistencia_id' => $asistencia->id,
                ]
            );
        }

        $materia = Materia::find($request->get('materia_id'));
        $materia->cupos_disponibles = $materia->cupos_disponibles === 0 ? 0 : $materia->cupos_disponibles - count($estudiantes);
        $materia->save();
        
        if (!empty($request->get('validador'))) {
            return redirect()->back()->with('registrado', 'registro');
        }

        return redirect('materias/' . $request->get('materia_id'))->with('registrado', 'registrado');
    }

    public function validar(Request $request)
    {
        $id = $request->get('id');
        $estudiante = Estudiante_materia::where('estudiante_id', '=', $id)->first();
        $estudiante->validacion_estudiante = 1;
        $estudiante->update();
        return redirect()->back()->with('validado', 'Se ha validado');
    }

    public function invalidar(Request $request)
    {
        $id = $request->get('id');
        $estudiante = Estudiante_materia::where('estudiante_id', '=', $id)->first();
        $estudiante->validacion_estudiante = 0;
        $estudiante->update();
        return redirect()->back()->with('invalidado', 'Se ha invalidado');
    }
}
