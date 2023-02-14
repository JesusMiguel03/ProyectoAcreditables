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
use Illuminate\Http\Request;
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

    public function estadisticas($id)
    {
        try {
            $periodoActual = Periodo::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect(route('estadisticas.index'))->with('noExiste', 'El periodo a buscar no existe');
        }

        // Lista de periodos
        $periodos = Periodo::all();

        // Periodo buscado
        $periodoActual = Periodo::find($id);
        $inicio = $periodoActual->inicio;
        $fin = $periodoActual->fin;

        // Formato de periodo a mostrar
        $inicioFormato = \Carbon\Carbon::parse($inicio)->format('d-m-Y');
        $finFormato = \Carbon\Carbon::parse($fin)->format('d-m-Y');
        $periodoFormateado = "Fase ({$periodoActual->fase}) - [{$inicioFormato} al {$finFormato}]";

        $periodoAnterior = Periodo::whereDate('inicio', '<=', $inicio)->whereDate('fin', '<=', $fin)->where('id', '!=', $id)->latest()->first();
        $inicioAnterior = $periodoAnterior->inicio ?? null;
        $finAnterior = $periodoAnterior->fin ?? null;

        // Rango de fechas de registro en base al periodo
        $inicio = \Carbon\Carbon::parse($inicio)->startOfDay();
        $fin = \Carbon\Carbon::parse($fin)->endOfDay();

        // Estadísticas de cantidad
        $materias = Materia::creadoEntre([$inicio, $fin])->get();
        $estudiantesRegistrados = Estudiante::creadoEntre([$inicio, $fin])->get();
        $profesores = Profesor::creadoEntre([$inicio, $fin])->get();
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

        foreach ($trayectos as $trayecto) {
            $acreditable = $trayecto->num_trayecto;

            array_push($estudiantesTrayecto, count($trayecto->creadoEntre([$inicio, $fin])->get()));
            array_push($numeroTrayecto, $acreditable);

            if (!$materias->isEmpty()) {
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

        if (!$materias->isEmpty()) {
            foreach ($materiaMasDemandadaPorTrayecto as $nroTrayecto => $trayecto) {
    
                foreach ($trayecto as $pnf => $materia) {
    
                    $materiaDemandada = ['materia' => null, 'cantidad' => 0];
    
                    foreach ($materia as $acreditable => $cantidadEstudiantes) {
    
                        if ($materiaDemandada['cantidad'] < $cantidadEstudiantes) {
                            $materiaDemandada['materia'] = $acreditable;
                            $materiaDemandada['cantidad'] = $cantidadEstudiantes;
                        }
                    }
    
                    $listadoMateriasDemandadasPNF[$nroTrayecto][$pnf] = $materiaDemandada;
                }
            }
        }

        foreach ($pnfs as $pnf) {
            array_push($estudiantesAnteriorPNF, count($pnf->creadoEntre([$inicioAnterior, $finAnterior])->get()));
            array_push($estudiantesPNF, count($pnf->creadoEntre([$inicio, $fin])->get()));
            array_push($nombrePNF, $pnf->nom_pnf);
        }

        foreach ($materias as $materia) {
            $cantidad = count($materia->estudiantes);
            $nombre = $materia->nom_materia;

            $acreditable = $materia->infoAcreditable();
            $estudiantes = $materia->estudiantes;

            array_push($estudiantesMateria, $cantidad);
            array_push($nombreMaterias, $nombre);
        }

        return view('estadisticas.show', compact('periodoActual', 'periodoFormateado', 'listadoMateriasDemandadasPNF', 'inscritos', 'materias', 'estudiantesRegistrados', 'profesores', 'pnfs', 'trayectos', 'periodos', 'nombreMaterias', 'estudiantesMateria', 'estudiantesPNF', 'estudiantesAnteriorPNF', 'nombrePNF', 'estudiantesTrayecto', 'numeroTrayecto'));
    }
}
