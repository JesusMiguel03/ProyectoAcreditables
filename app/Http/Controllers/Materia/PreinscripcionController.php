<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\DatosAcademicos\Estudiante_materia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreinscripcionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Estudiante_materia::updateOrCreate(
            ['estudiante_id' => $request->get('usuario_id')],
            [
                'calificacion' => 0,
                'codigo' => Str::random(20),
                'validacion_estudiante' => 0,
                'materia_id' => $request->get('materia_id')
            ]
        );

        return redirect('materias')->with('registrado', 'El tipo fue creada exitosamente');
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
