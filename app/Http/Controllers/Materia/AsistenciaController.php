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
        
        $asistencia->Sem1 = $request->get('Sem1') === 'on' ? 1 : 0;
        $asistencia->Sem2 = $request->get('Sem2') === 'on' ? 1 : 0;
        $asistencia->Sem3 = $request->get('Sem3') === 'on' ? 1 : 0;
        $asistencia->Sem4 = $request->get('Sem4') === 'on' ? 1 : 0;
        $asistencia->Sem5 = $request->get('Sem5') === 'on' ? 1 : 0;
        $asistencia->Sem6 = $request->get('Sem6') === 'on' ? 1 : 0;
        $asistencia->Sem7 = $request->get('Sem7') === 'on' ? 1 : 0;
        $asistencia->Sem8 = $request->get('Sem8') === 'on' ? 1 : 0;
        $asistencia->Sem9 = $request->get('Sem9') === 'on' ? 1 : 0;
        $asistencia->Sem10 = $request->get('Sem10') === 'on' ? 1 : 0;
        $asistencia->Sem11 = $request->get('Sem11') === 'on' ? 1 : 0;
        $asistencia->Sem12 = $request->get('Sem12') === 'on' ? 1 : 0;
        $asistencia->save();
        // $tem->Sem1 = 1;
        // $tem->Sem2 = 1;
        // $tem->Sem3 = 1;
        // $tem->Sem4 = 1;
        // $tem->Sem5 = 1;
        // $tem->save();
        // dd(Estudiante::find($request->get('id'))->asistencia);
        // Asistencia::updateOrCreate(
        //     ['id' => $request->get('id')],
        //     [
        //         'Sem1' => $request->get('Sem1') === 'on' ? 1 : 0,
        //         'Sem2' => $request->get('Sem2') === 'on' ? 1 : 0,
        //         'Sem3' => $request->get('Sem3') === 'on' ? 1 : 0,
        //         'Sem4' => $request->get('Sem4') === 'on' ? 1 : 0,
        //         'Sem5' => $request->get('Sem5') === 'on' ? 1 : 0,
        //         'Sem6' => $request->get('Sem6') === 'on' ? 1 : 0,
        //         'Sem7' => $request->get('Sem7') === 'on' ? 1 : 0,
        //         'Sem8' => $request->get('Sem8') === 'on' ? 1 : 0,
        //         'Sem9' => $request->get('Sem9') === 'on' ? 1 : 0,
        //         'Sem10' => $request->get('Sem10') === 'on' ? 1 : 0,
        //         'Sem11' => $request->get('Sem11') === 'on' ? 1 : 0,
        //         'Sem12' => $request->get('Sem12') === 'on' ? 1 : 0,
        //     ]
        // );
        return redirect()->back()->with('creado', 'creado');
    }

    public function edit($id)
    {
        $estudiante = Estudiante::find($id);
        return view('aside.materias.asistencias.edit', compact('estudiante'));
    }
}
