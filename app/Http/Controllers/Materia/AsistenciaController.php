<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Materia\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('aside.materias.asistencias.index', compact('estudiantes'));
    }

    public function update(Request $request)
    {
        $asistencia = Estudiante::find($request->get('id'))->asistencia;

        for ($i = 1; $i <= 12; $i++) {
            $campo = 'sem' . $i;
            $asistencia[$campo] = $request->get($campo) === 'on' ? 1 : 0;
        }
        $asistencia->save();
        
        return redirect()->back()->with('creado', 'creado');
    }

    public function edit($id)
    {
        $estudiante = Estudiante::find($id);
        return view('aside.materias.asistencias.edit', compact('estudiante'));
    }
}
