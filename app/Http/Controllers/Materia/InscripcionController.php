<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Informacion\Bitacora;
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

        // Busca la materia y todos los estudiantes
        $materia = Materia::find($id);

        if ($materia->estado_materia === 'Finalizado') {
            return redirect()->back()->with('finalizado', 'No se puede inscribir en una acreditable que ya ha finalizado.');
        }

        $estudiantes = Estudiante::where('trayecto_id', '=', $materia->trayecto->id)->get();

        $no_inscritos = [];

        foreach ( $estudiantes as $estudiante ) {
            if (!count($estudiante->inscrito) > 0) {
                array_push($no_inscritos, $estudiante);
            }
        }

        return view('materias.acreditables.inscribir', compact('no_inscritos', 'materia'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('materias.inscribir');

        if (periodo('modelo')->finalizado()) {
            return redirect()->back()->with('periodoFinalizado', 'No se puede inscribir debido a que el periodo se encuentra finalizado');
        }

        // Si no hay estudiantes pero aún así se envía el formulario no hace nada.
        if ($request['vacio'] === '0') {
            return redirect()->back();
        }

        $id = $request['materia_id'];
        $materia = Materia::find($id);

        if ($materia->cupos_disponibles === 0) {
            return redirect()->back();
        }

        $estudiantes = $request['estudiantes'];

        // Si el coordinador los inscribe
        if (is_array($estudiantes)) {

            foreach ($estudiantes as $estudiante) {

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

                Estudiante_materia::create([
                    'periodo_id' => periodo('modelo')->id,
                    'estudiante_id' => $estudiante,
                    'nota' => 0,
                    'codigo' => Str::random(6),
                    'validado' => rol('Coordinador') ? 1 : 0,
                    'materia_id' => $id,
                    'asistencia_id' => $asistencia->id,
                ]);

                $estudianteModelo = Estudiante::find($estudiante);

                Bitacora::create([
                    'usuario' => "Estudiante - ({$estudianteModelo->nombreEstudiante()})",
                    'accion' => "Se ha inscrito en {$materia->nom_materia} exitosamente",
                    'estado' => 'success'
                ]);
            }

            // Si se inscribe el estudiante solo
        } else {

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

            Estudiante_materia::create([
                'periodo_id' => periodo('modelo')->id,
                'estudiante_id' => auth()->user()->estudiante->id,
                'nota' => 0,
                'codigo' => Str::random(6),
                'validado' => rol('Coordinador') ? 1 : 0,
                'materia_id' => $id,
                'asistencia_id' => $asistencia->id,
            ]);

            Bitacora::create([
                'usuario' => 'Estudiante - (' .auth()->user()->nombre . ' ' . auth()->user()->apellido . ')',
                'accion' => "Se ha inscrito en {$materia->nom_materia} exitosamente",
                'estado' => 'success'
            ]);
        }


        // Cuenta la cantidad de inscritos y los resta de los cupos disponibles
        $cuposMenos = is_array($estudiantes) ? count($estudiantes) : 1;

        $materia['cupos_disponibles'] = $materia['cupos_disponibles'] === 0
            ? 0
            : $materia['cupos_disponibles'] - $cuposMenos;
        $materia->save();

        // Si fue el coordinador que registró
        if (rol('Coordinador')) {
            return redirect()->back()->with('registrado', 'registro');
        }

        // Si fue el estudiante
        return redirect('materias/' . $id)->with('registrado', 'registrado');
    }

    public function cambiar($usuarioID, $materiaID)
    {
        $usuario = Estudiante_materia::where('estudiante_id', '=', $usuarioID)->get()->last();

        /**
         *  Añade un cupo disponible a la materia anterior y resta uno a la que se desea cambiar.
         */
        $materiaAnterior = Materia::find($usuario->materia_id);
        $materiaAnterior->update(['cupos_disponibles' => $materiaAnterior->cupos_disponibles + 1]);

        $materiaActual = Materia::find($materiaID);
        $materiaActual->update(['cupos_disponibles' => $materiaAnterior->cupos_disponibles - 1]);

        $usuario->update([
            'materia_id' => $materiaID,
            'validado' => 0,
            'codigo' => Str::random(6)
        ]);

        $usuario->asistencia->update([
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

        Bitacora::create([
            'usuario' => "Estudiante - ({$usuario->inscritoNombre()})",
            'accion' => "Se ha cambiado de acreditable ({$materiaAnterior->nombre_materia}) a ({$materiaActual->nombre_materia}) exitosamente",
            'estado' => 'success'
        ]);

        return redirect()->back()->with('cambioExitoso', 'cambioExitoso');
    }

    public function validar($id)
    {
        // Valida si tiene el permiso
        permiso('validar.estudiante');

        // Busca al estudiante y cambia la validación
        $estudiante = Estudiante_materia::find($id);
        $estudiante->update(['validado' => 1]);

        Bitacora::create([
            'usuario' => "Estudiante - ({$estudiante->inscritoNombre()})",
            'accion' => 'Ha sido validado exitosamente',
            'estado' => 'success'
        ]);

        return redirect()->back()->with('validado', 'Se ha validado');
    }

    public function invalidar($id)
    {
        // Valida si tiene el permiso
        permiso('validar.estudiante');

        // Busca al estudiante y cambia la validación
        $estudiante = Estudiante_materia::find($id);
        $estudiante->update(['validado' => 0]);

        Bitacora::create([
            'usuario' => "Estudiante - ({$estudiante->inscritoNombre()})",
            'accion' => 'Ha sido invalidado exitosamente',
            'estado' => 'success'
        ]);

        return redirect()->back()->with('invalidado', 'Se ha invalidado');
    }

    public function asignarNota(Request $request, $estudiante_id)
    {
        $estudiante = Estudiante_materia::find($estudiante_id);
        $estudiante->update([
            'nota' => $request['nota']
        ]);

        Bitacora::create([
            'usuario' => "Estudiante - ({$estudiante->inscritoNombre()})",
            'accion' => "Se ha asignado la nota ({$request['nota']}) exitosamente",
            'estado' => 'success'
        ]);

        return redirect()->back()->with('notaActualizada', "({$estudiante->inscritoCI()}) {$estudiante->inscritoNombre()}");
    }
}
