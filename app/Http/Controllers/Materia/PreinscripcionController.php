<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\DatosAcademicos\Estudiante_materia;
use App\Models\Estudiante;
use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreinscripcionController extends Controller
{
    public function preinscribir($id)
    {
        $estudiantes = Estudiante::all();
        $no_preinscritos = [];

        foreach ($estudiantes as $estudiante) {
            if (empty($estudiante->preinscrito)) {
                array_push($no_preinscritos, $estudiante);
            }
        }

        $materia = Materia::find($id);
        return view('aside.materias.acreditables.preinscribir', compact('no_preinscritos', 'materia'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('usuario_id') === '0') {
            return redirect()->back()->with('usuario-invalido', 'error');
        }

        $asistencia = Asistencia::create([
            'Sem1' => 0,
            'Sem2' => 0,
            'Sem3' => 0,
            'Sem4' => 0,
            'Sem5' => 0,
            'Sem6' => 0,
            'Sem7' => 0,
            'Sem8' => 0,
            'Sem9' => 0,
            'Sem10' => 0,
            'Sem11' => 0,
            'Sem12' => 0,
        ]);

        Estudiante_materia::updateOrCreate(
            ['estudiante_id' => $request->get('usuario_id')],
            [
                'calificacion' => 0,
                'codigo' => Str::random(20),
                'validacion_estudiante' => 0,
                'materia_id' => $request->get('materia_id'),
                'asistencia_id' => $asistencia->id,
            ]
        );

        $materia = Materia::find($request->get('materia_id'));
        $materia->cupos_disponibles = $materia->cupos_disponibles === 0 ? 0 : $materia->cupos_disponibles - 1;
        $materia->save();
        
        if (!empty($request->get('validador'))) {
            return redirect()->back()->with('registrado', 'registro');
        }

        return redirect('materias/' . $request->get('materia_id'))->with('registrado', 'El tipo fue creada exitosamente');
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
        return redirect()->back()->with('validado', 'Se ha validado');
    }
}
