<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Materia\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function asistencia(Request $request)
    {
        $id = $request->get('id');
        Asistencia::updateOrCreate(
            ['id' => $id],
            [
                'Sem1' => $request->get('sem1') === 'on' ? 1 : 0,
                'Sem2' => $request->get('sem2') === 'on' ? 1 : 0,
                'Sem3' => $request->get('sem3') === 'on' ? 1 : 0,
                'Sem4' => $request->get('sem4') === 'on' ? 1 : 0,
                'Sem5' => $request->get('sem5') === 'on' ? 1 : 0,
                'Sem6' => $request->get('sem6') === 'on' ? 1 : 0,
                'Sem7' => $request->get('sem7') === 'on' ? 1 : 0,
                'Sem8' => $request->get('sem8') === 'on' ? 1 : 0,
                'Sem9' => $request->get('sem9') === 'on' ? 1 : 0,
                'Sem10' => $request->get('sem10') === 'on' ? 1 : 0,
                'Sem11' => $request->get('sem11') === 'on' ? 1 : 0,
                'Sem12' => $request->get('sem12') === 'on' ? 1 : 0,
            ]
        );

        return redirect()->back()->with('actualizado', 'actualizado');
    }
}
