<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscripcionController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }
    
    public function inscribir($id)
    {
        // Valida si tiene el permiso
        permiso('materias.inscribir');

        $materia = Materia::find($id);
        $estudiantes = Estudiante::all();
        $periodo = periodoActual();
        $no_inscritos = [];

        foreach ($estudiantes as $estudiante) {
            if (empty($estudiante->inscrito) && $estudiante->trayecto->num_trayecto === $materia->num_acreditable) {
                array_push($no_inscritos, $estudiante);
            }
        }

        return view('materias.acreditables.inscribir', compact('no_inscritos', 'materia', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('materias.inscribir');

        $materia = Materia::find($request->get('materia_id'));
        if ($materia->cupos_disponibles === 0) {
            return redirect()->back();
        }

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

        
        $materia->cupos_disponibles = $materia->cupos_disponibles === 0 ? 0 : $materia->cupos_disponibles - count($estudiantes);
        $materia->save();
        
        if (!empty($request->get('validador'))) {
            return redirect()->back()->with('registrado', 'registro');
        }

        return redirect('materias/' . $request->get('materia_id'))->with('registrado', 'registrado');
    }

    public function validar($id)
    {
        // Valida si tiene el permiso
        permiso('validar.estudiante');

        $estudiante = Estudiante_materia::where('estudiante_id', '=', $id)->first();
        $estudiante->validacion_estudiante = 1;
        $estudiante->update();
        return redirect()->back()->with('validado', 'Se ha validado');
    }

    public function invalidar($id)
    {
        // Valida si tiene el permiso
        permiso('validar.estudiante');

        $estudiante = Estudiante_materia::where('estudiante_id', '=', $id)->first();
        $estudiante->validacion_estudiante = 0;
        $estudiante->update();
        return redirect()->back()->with('invalidado', 'Se ha invalidado');
    }
}
