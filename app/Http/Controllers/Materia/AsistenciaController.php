<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Periodo;
use App\Models\Informacion\Bitacora;
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

        $periodos = Periodo::all();

        /**
         *  Busca a todos los estudiante inscritos que:
         * 
         *  1. No hayan sido aprobados.
         *  2. Fueron reprobados (en caso de haber un error en la asistencia).
         */
        $estudiantes = Estudiante_materia::where('aprobado', '!=', 1)->orWhere('aprobado', '=', null)->get();

        if (rol('Profesor')) {
            $estudiantesProfesor = [];

            $profesor = auth()->user()->profesor;

            $materiasImpartidas = $profesor->imparteMateria;

            /**
             *  Lista todos los estudiantes inscritos en las materias que imparta el profesor
             * 
             *  Si el estudiante se encuentra aprobado no se cargará su asistencia.
             */
            foreach ($materiasImpartidas as $infoMateria) {
                foreach ($infoMateria->materia->estudiantes as $estudiante) {

                    if ($estudiante->aprobado !== 1) {
                        array_push($estudiantesProfesor,  $estudiante);
                    }
                }
            }

            $estudiantes = $estudiantesProfesor;
        }

        $asistenciaEstudiantes = [];

        foreach ($estudiantes as $estudiante) {
            $inscrito = $estudiante->inscrito;

            // Selecciona la asistencia
            $asistencia = $estudiante->asistencia;

            $asistencias = 0;

            // Suma cada asistencia
            for ($i = 1; $i <= 12; $i++) {
                $sem = 'sem' . $i;

                if (!empty($asistencia)) $asistencia[$sem] === 1 ? $asistencias++ : '';
            }

            // Guarda el total de asistencias
            array_push($asistenciaEstudiantes, $asistencias);
        }

        return view('materias.asistencias.index', compact('estudiantes', 'asistenciaEstudiantes', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('asistencias');

        $estudiante = Estudiante_materia::find($id);

        $asistencia = $estudiante->asistencia;

        // Si tiene asistencia esa semana, activa el checkbox
        for ($i = 1; $i <= 12; $i++) {
            $campo = 'sem' . $i;
            $asistencia[$campo] = $request[$campo] === 'on' ? 1 : 0;
        }
        $asistencia->save();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró la asistencia de ({$estudiante->inscritoNombre()}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        $nombreEstudiante = $estudiante->inscritoNombre();
        $asistencia = $estudiante->aprobo()[1];

        return redirect()->to(session('URLPrevioRedireccionAsistencias'))->with('asistencia', "La asistencia del estudiante ({$nombreEstudiante}) ha sido actualizada a [{$asistencia} % / 100 %].");
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
            $asistencia[$sem] === 1 ? $asistencias++ : '';
        }

        return view('materias.asistencias.edit', compact('estudiante', 'asistencias'));
    }

    public function show($id)
    {
        // Valida si tiene el permiso.
        permiso('asistencias');

        $periodos = Periodo::all();
        $periodoSeleccionado = Periodo::find($id);

        /**
         *  Busca a todos los estudiante inscritos que:
         * 
         *  1. No hayan sido aprobados.
         *  2. Fueron reprobados (en caso de haber un error en la asistencia).
         */
        $estudiantes = Estudiante_materia::where('aprobado', '!=', 1)->orWhere('aprobado', '=', null)->where('periodo_id', '=', $periodoSeleccionado->id)->get();

        if (rol('Profesor')) {
            $estudiantesProfesor = [];

            $profesor = auth()->user()->profesor;

            $materiasImpartidas = $profesor->imparteMateria;

            /**
             *  Lista todos los estudiantes inscritos en las materias que imparta el profesor
             * 
             *  Si el estudiante se encuentra aprobado no se cargará su asistencia.
             */
            foreach ($materiasImpartidas as $infoMateria) {
                foreach ($infoMateria->materia->estudiantes as $estudiante) {
                    array_push($estudiantesProfesor,  $estudiante);
                }
            }

            $estudiantes = $estudiantesProfesor;
        }

        $asistenciaEstudiantes = [];

        foreach ($estudiantes as $estudiante) {
            $inscrito = $estudiante->inscrito;

            // Selecciona la asistencia
            $asistencia = $estudiante->asistencia;

            $asistencias = 0;

            // Suma cada asistencia
            for ($i = 1; $i <= 12; $i++) {
                $sem = 'sem' . $i;

                if (!empty($asistencia)) {
                    $asistencia[$sem] === 1 ? $asistencias++ : '';
                }
            }

            // Guarda el total de asistencias
            array_push($asistenciaEstudiantes, $asistencias);
        }

        return view('materias.asistencias.index', compact('estudiantes', 'asistenciaEstudiantes', 'periodoSeleccionado', 'periodos'));
    }
}
