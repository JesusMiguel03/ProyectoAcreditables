<?php

namespace App\Http\Controllers\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Periodo;
use App\Models\Academico\PNF;
use App\Models\Academico\Profesor;
use App\Models\Academico\Trayecto;
use App\Models\Materia\Materia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EstadisticasController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación.
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        $periodos = Periodo::all();

        return view('estadisticas.index', compact('periodos'));
    }

    public function materia($periodo_id, $materia_id)
    {
        // Busca todos los periodos, el seleccionado y la materia.
        $periodos = Periodo::all();
        $periodoActual = Periodo::find($periodo_id);
        $materiaActual = Materia::find($materia_id);

        // Si no se encuentra uno u otro regresa.
        if (!$periodoActual || !$materiaActual) {
            return redirect()->back()->with('noEncontrado', 'error');
        }

        // Si no han pasado 45 días de la fecha de inicio regresa.
        $tiempoExtraInscripcion = Carbon::parse($periodoActual->inicio)->addDays(45)->format('Y-m-d');
        $fechaInicio = Carbon::parse($periodoActual->inicio)->format('Y-m-d');

        if (Carbon::today()->format('Y-m-d') !== $tiempoExtraInscripcion) {
            return redirect()->back()->with(['inscripcionActiva' => $tiempoExtraInscripcion, 'fechaInicio' => $fechaInicio]);
        }

        $trayecto = $materiaActual->infoAcreditable();

        // Formato de periodo a mostrar
        $inicioFormato = Carbon::parse($periodoActual->inicio)->format('d-m-Y');
        $finFormato = Carbon::parse($periodoActual->fin)->format('d-m-Y');
        $periodoFormateado = "Fase ({$periodoActual->fase}) - [{$inicioFormato} al {$finFormato}]";

        $materias = Materia::creadoEntre([$inicioFormato, $finFormato])->get();

        $estudiantes = $materiaActual->estudiantes;
        $profesor = $materiaActual->profesor ?? null;

        if (!empty($profesor)) {
            $profesor = $profesor->nombreProfesor() . ' ' . $profesor->profesorCI();
        }

        $datosEstudiantes = [];
        $pnfs = [];
        $totalEstudiantes = count($estudiantes);

        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];

        // Selecciona a los estudiantes que cursando el periodo seleccionado.
        foreach ($estudiantes as $estudianteM) {

            if (!$estudianteM->creadoEntre([$inicioFormato, $finFormato])->first()) {
                return redirect()
                    ->back()
                    ->with('sinDatos', $materiaActual->nom_materia)
                    ->with('periodo', $conversor[$periodoActual->fase] . '-' . Carbon::parse($periodoActual->inicio)->format('Y'));
            }

            $asistencias = 0;
            for ($i = 1; $i <= 12; $i++) {
                $sem = 'sem' . $i;
                $estudianteM->asistencia[$sem] === 1 ? $asistencias += 833 : '';
            }

            $asistencia = number_format(round($asistencias / 100), 0, '', '');
            $nota = $estudianteM->nota;

            $pnf = $estudianteM->inscritoPNFNombre();

            !empty($pnfs[$pnf]) ? $pnfs[$pnf]++ : $pnfs[$pnf] = 1;

            $nombreCI = $estudianteM->inscritoNombre() . ' ' . $estudianteM->inscritoCI();

            $datos = "$nombreCI, $asistencia, $nota";

            array_push($datosEstudiantes, $datos);
        }

        sort($datosEstudiantes);

        return view('estadisticas.materia', compact('periodoFormateado', 'datosEstudiantes', 'pnfs', 'trayecto', 'profesor', 'totalEstudiantes', 'materiaActual', 'periodos', 'periodoActual', 'materias'));
    }

    public function estadisticas($id)
    {
        // Busca el periodo.
        try {
            $periodoActual = Periodo::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect(route('estadisticas.index'))->with('noExiste', 'El periodo a buscar no existe');
        }

        // Si no han pasado 45 días regresa.
        $tiempoExtraInscripcion = Carbon::parse($periodoActual->inicio)->addDays(45)->format('Y-m-d');
        $fechaInicio = Carbon::parse($periodoActual->inicio)->format('Y-m-d');

        if (Carbon::today()->format('Y-m-d') !== $tiempoExtraInscripcion) {
            return redirect()->back()->with(['inscripcionActiva' => $tiempoExtraInscripcion, 'fechaInicio' => $fechaInicio]);
        }

        // Lista de periodos
        $periodos = Periodo::all();

        // Periodo buscado
        $inicio = $periodoActual->inicio;
        $fin = $periodoActual->fin;

        // Formato de periodo a mostrar
        $inicioFormato = Carbon::parse($inicio)->format('d-m-Y');
        $finFormato = Carbon::parse($fin)->format('d-m-Y');
        $periodoFormateado = "Fase ({$periodoActual->fase}) - [{$inicioFormato} al {$finFormato}]";

        $periodoAnterior = Periodo::whereDate('inicio', '<=', $inicio)
            ->whereDate('fin', '<=', $fin)
            ->where('id', '!=', $id)
            ->latest()
            ->first();
        $inicioAnterior = $periodoAnterior->inicio ?? null;
        $finAnterior = $periodoAnterior->fin ?? null;

        // Rango de fechas de registro en base al periodo
        $inicio = Carbon::parse($inicio)->startOfDay();
        $fin = Carbon::parse($fin)->endOfDay();

        // Materias totales
        $materias = Materia::all();

        // Estudiantes totales
        $estudiantesRegistrados = Estudiante::all();

        // Profesores totales
        $profesores = Profesor::all();

        $inscritos = Estudiante_materia::creadoEntre([$inicio, $fin])->get();

        $pnfs = PNF::where('cod_pnf', '!=', null)->get();
        $trayectos = Trayecto::all();

        // Materias
        $nombreMaterias = [];
        $estudiantesMateria = [];

        // Demanda por periodo
        $materiaMasDemandadaPorTrayecto = !$materias->isEmpty() ? [] : null;
        $listadoMateriasDemandadasPNF = !$materias->isEmpty() ? [] : null;

        // PNF
        $estudiantesPNF = [];
        $nombrePNF = [];
        $estudiantesAnteriorPNF = [];

        // Trayecto
        $estudiantesTrayecto = [];
        $numeroTrayecto = [];

        // Si hay materias y estudiantes.
        $condicion = !$materias->isEmpty() && !$materias[0]->estudiantes[0]->creadoEntre([$inicio, $fin])->get()->isEmpty();

        // Itera cada trayecto para añadirlos a una lista.
        foreach ($trayectos as $trayecto) {
            $acreditable = $trayecto->num_trayecto;

            array_push($estudiantesTrayecto, count($trayecto->creadoEntre([$inicio, $fin])->get()));
            array_push($numeroTrayecto, $acreditable);

            // Si hay materias en ese periodo y estudiantes
            if ($condicion) {
                $materiaMasDemandadaPorTrayecto[$acreditable] = [];
                $listadoMateriasDemandadasPNF[$acreditable] = [];

                foreach ($trayecto->materias as $materiaT) {
                    $nombre = $materiaT->nom_materia;

                    foreach ($materiaT->estudiantes as $estudianteT) {

                        $pnf = $estudianteT->esEstudiante->pnf->nom_pnf;

                        !empty($materiaMasDemandadaPorTrayecto[$acreditable][$pnf][$nombre])
                            ? $materiaMasDemandadaPorTrayecto[$acreditable][$pnf][$nombre]++
                            : $materiaMasDemandadaPorTrayecto[$acreditable][$pnf][$nombre] = 1;
                    }
                }
            }
        }

        // Si la condición se cumple reorganiza la información guardada.
        if ($condicion) {
            foreach ($materiaMasDemandadaPorTrayecto as $nroTrayecto => $trayecto) {

                foreach ($trayecto as $pnf => $materia) {

                    $materiaDemandada = ['pnf' => null, 'materia' => null, 'cantidad' => 0];

                    foreach ($materia as $acreditable => $cantidadEstudiantes) {

                        if ($materiaDemandada['cantidad'] < $cantidadEstudiantes) {
                            $materiaDemandada['pnf'] = $pnf;
                            $materiaDemandada['materia'] = $acreditable;
                            $materiaDemandada['cantidad'] = $cantidadEstudiantes;
                        }
                    }

                    array_push($listadoMateriasDemandadasPNF[$nroTrayecto], $materiaDemandada);
                }
            }
        }

        // Busca los estudiantes de los pnfs del periodo seleccionado y el anterior.
        foreach ($pnfs as $pnf) {
            if (periodo('anterior')) {
                array_push($estudiantesAnteriorPNF, count($pnf->creadoEntre([$inicioAnterior, $finAnterior])->get()));
            }
            array_push($estudiantesPNF, count($pnf->creadoEntre([$inicio, $fin])->get()));
            array_push($nombrePNF, $pnf->nom_pnf);
        }

        foreach ($materias as $materia) {
            if ($condicion) {
                $cantidad = count($materia->estudiantes);
                $nombre = $materia->nom_materia;

                $acreditable = $materia->infoAcreditable();
                $estudiantes = $materia->estudiantes;

                array_push($estudiantesMateria, $cantidad);
                array_push($nombreMaterias, $nombre);
            }
        }

        $trayecto1 = '';
        $trayecto2 = '';
        $trayecto3 = '';
        $trayecto4 = '';
        $trayecto5 = '';

        if ($listadoMateriasDemandadasPNF) {
            $trayecto1 = $listadoMateriasDemandadasPNF[1];
            $trayecto2 = $listadoMateriasDemandadasPNF[2];
            $trayecto3 = $listadoMateriasDemandadasPNF[3];
            $trayecto4 = $listadoMateriasDemandadasPNF[4];
            $trayecto5 = $listadoMateriasDemandadasPNF[5];
        }

        return view('estadisticas.show', compact('periodoActual', 'periodoFormateado', 'listadoMateriasDemandadasPNF', 'inscritos', 'materias', 'estudiantesRegistrados', 'profesores', 'pnfs', 'trayectos', 'periodos', 'nombreMaterias', 'estudiantesMateria', 'estudiantesPNF', 'estudiantesAnteriorPNF', 'nombrePNF', 'estudiantesTrayecto', 'numeroTrayecto', 'trayecto1', 'trayecto2', 'trayecto3', 'trayecto4', 'trayecto5'));
    }
}
