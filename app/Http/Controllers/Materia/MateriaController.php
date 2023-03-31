<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Academico\Profesor;
use App\Models\Academico\Trayecto;
use App\Models\Informacion\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Materia\Materia;
use App\Models\Materia\Categoria;
use App\Models\Materia\Informacion_materia;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MateriaController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación.
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        $usuario = Auth::user();

        // Valida si tiene el permiso.
        permiso(['materias.principal', 'materias.estudiante']);

        // Coordinador
        if (rol('Coordinador')) {
            $materias = Materia::all();
            $trayectos = Trayecto::all();

            // Actualiza los cupos disponibles
            $materias->map(function ($materia) {
                $materia->actualizarCupos();
            });

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Se actualizaron los cupos disponibles de todas las acreditables exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);

            return view('materias.acreditables.index', compact('materias', 'trayectos'));
        }

        // Profesor
        if (rol('Profesor')) {
            $profesor = $usuario->profesor;

            // Perfil de profesor e imparte materias
            if ($profesor) {
                $materiasImpartidasProfesor = [];

                foreach ($profesor->imparteMateria as $materia) {
                    array_push($materiasImpartidasProfesor, $materia->id);
                }

                $materias = Materia::whereIn('informacion_id', $materiasImpartidasProfesor)->get();

                // Actualiza los cupos disponibles
                $materias->map(function ($materia) {
                    $materia->actualizarCupos();
                });

                Bitacora::create([
                    'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                    'accion' => "Se actualizaron los cupos disponibles de las acreditables impartidas por este profesor exitosamente",
                    'estado' => 'success',
                    'periodo_id' => periodo('modelo')->id ?? null
                ]);

                return view('materias.acreditables.index', compact('materias'));
            }

            // Si no imparte mterias
            $materias = [];

            return view('materias.acreditables.index', compact('materias'));
        }

        // Estudiante
        if (rol('Estudiante')) {
            $estudiante = $usuario->estudiante;

            // Datos académicos.
            $trayecto = $estudiante->trayecto->id ?? null;
            $perfilAcademico = empty($estudiante->pnf) && empty($estudiante->trayecto);

            // Última inscripción del estudiante.
            $estudianteInscrito = !empty($estudiante->inscrito) ? $estudiante->inscrito->last() : null;
            $ultimaInscripcion = $estudianteInscrito;

            // Si ya se inscribió busca el periodo en que lo hizo.
            $periodoUltimaInscripcion = null;

            if ($estudianteInscrito) {
                $periodoUltimaInscripcion = $estudianteInscrito->periodoInscripcion()->formato();
            }

            // No tiene perfil academico (Pnf y trayecto registrado).
            if ($perfilAcademico) {
                $mostrar = 'noPerfilAcademico';

                return view('materias.acreditables.index', compact('mostrar'));

                // Está inscrito y el periodo de inscripcion es el actual
            } elseif (!$perfilAcademico && $periodoUltimaInscripcion === periodo()) {

                $materias = Materia::find($estudianteInscrito->materia_id ?? null);
                $materias->actualizarCupos();

                $mostrar = 'inscrito';

                Bitacora::create([
                    'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                    'accion' => "Se actualizaron los cupos disponibles de la acreditable ({$materias->nom_materia}) exitosamente",
                    'estado' => 'success',
                    'periodo_id' => periodo('modelo')->id ?? null
                ]);

                return view('materias.acreditables.index', compact('materias', 'mostrar'));

                /**
                 *  Si el periodo actual y el periodo de la ultima inscripcion son diferentes muestra todas las materias.
                 * 
                 *  Aplica para mostrar todas las materias si no esta inscrito, puede cursar la siguiente acreditable o debe repetir.
                 * 
                 *  EJ:
                 *  periodoActual = 'I-2020'
                 *  periodoUltimaInscripcion = 'III-2019'
                 * 
                 *  periodoActual !== periodoUltimaInscripcion -> true
                 */
            } elseif ($periodoUltimaInscripcion !== periodo()) {

                // Materias disponibles (Activas o finalizadas)
                $materias = Materia::where('trayecto_id', '=', $trayecto)
                    ->where(function ($query) {
                        $query->where('estado_materia', '=', 'Activo')
                            ->orWhere('estado_materia', '=', 'En progreso')
                            ->orWhere('estado_materia', '=', 'Finalizado');
                    })->get();

                // Actualiza los cupos disponibles
                $materias->map(function ($materia) {
                    $materia->actualizarCupos();
                });

                Bitacora::create([
                    'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                    'accion' => "Se actualizaron los cupos disponibles de todas las acreditables del trayecto ({$trayecto}) exitosamente",
                    'estado' => 'success',
                    'periodo_id' => periodo('modelo')->id ?? null
                ]);

                $mostrarTabla = count($materias) >= config('variables.carrusel');

                $mostrar = 'noInscrito';

                $materiaCursando = null;
                $link = null;

                if ($ultimaInscripcion) {
                    $materiaCursando = $ultimaInscripcion->materia->nom_materia . ' ' . $ultimaInscripcion->materia->trayecto->num_trayecto;
                    $link = $ultimaInscripcion->materia->id;
                }

                return view('materias.acreditables.index', compact('materias', 'mostrarTabla', 'mostrar', 'materiaCursando', 'link'));
            }
        }
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $usuario = auth()->user();

        $validador = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:' . config('variables.materias.nombre')],
            'cupos' => ['required', 'numeric', 'max:' . config('variables.materias.cupos')],
            'desc_materia' => ['required', 'string', 'max:' . config('variables.materias.descripcion')],
            'trayecto' => ['required', 'numeric', 'max:4', 'not_in:0'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'nom_materia.required' => 'El nombre es necesario.',
            'nom_materia.string' => 'El nombre debe ser una oración.',
            'nom_materia.max' => 'El nombre no debe tener más de :max caracteres.',
            'trayecto.not_in' => 'El número de acreditable seleccionado es inválido.',
            'trayecto.numeric' => 'El número de acreditable debe ser un número.',
            'trayecto.required' => 'El número de la acreditable es necesario.',
            'trayecto.max' => 'El número de la acreditable no debe ser mayor a :max.',
            'cupos.required' => 'Los cupos son necesarios.',
            'cupos.numeric' => 'Los cupos deben ser un número.',
            'cupos.max' => 'Los cupos no deben ser mayor a :max',
            'desc_materia.required' => 'La descripción es necesaria.',
            'desc_materia.string' => 'La descripción debe ser una oración.',
            'desc_materia.max' => 'La descripción no debe ser mayor a :max caracteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador, 'error', 'Materia');

        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request['nom_materia'] . '.jpg', 'public');

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Subió una imagen de acreditable ({$request['nom_materia']}) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);
        }

        Materia::create([
            'informacion_id' => null,
            'nom_materia' => $request['nom_materia'],
            'cupos' => $request['cupos'],
            'cupos_disponibles' => $request['cupos'],
            'desc_materia' => $request['desc_materia'],
            'trayecto_id' => $request['trayecto'],
            'imagen_materia' => $imagen,
            'estado_materia' => 'Activo',
        ]);

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró la acreditable ({$request['nom_materia']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('materias')->with('creado', 'Curso creado exitosamente');
    }

    public function show($id)
    {
        // Valida si tiene el permiso
        permiso(['materias.principal', 'materias.estudiante']);

        // Busca el id del curso
        $materia = Materia::find($id);
        $periodos = Periodo::all();

        // Valida que exista
        existe($materia);

        $usuario = auth()->user();
        $estudiante = $usuario->estudiante;

        if (!rol('Coordinador') && $materia->estado_materia === 'Inactivo' || $materia->estado_materia === 'Descontinuado') {
            return redirect()->back()->with('inactivo', 'La acreditable que desea buscar no se encuentra activa.');
        }

        // if (rol('Profesor') && $materia->profesor->id !== $usuario->profesor->id) {
        //     return redirect()->back()->with('noDictaAcreditable', 'La acreditable que desea buscar no se imparte por usted.');
        // }

        if (rol('Estudiante')) {
            if (!($usuario->estudiante)) {
                return redirect()->back()->with('perfilIncompleto', 'No puede cursar ninguna acreditable hasta que se registre su perfil académico. Comuníquese con el coodinador para actualizar su perfil.');
            }

            // Evita que el estudiante vea las materias que no coinciden con su trayecto
            if ($materia->trayecto_id !== $usuario->estudiante->trayecto->id) {
                return redirect()->back();
            }
        }

        $estudianteInscrito = !empty($estudiante->inscrito) ? $estudiante->inscrito->last() : null;

        // Trae a todos los estudiantes inscritos
        $inscritos = $materia->estudiantesPeriodoActual();

        $materia->actualizarCupos();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Se actualizaron los cupos disponibles de la acreditable ({$materia->nom_materia}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        // En caso de que no se complete la materia se colocan valores por defecto
        $validacion = [];
        $datos_materia = ['Metodología', 'Categoria', 'Horario'];

        // Valida si existe la relacion y asigna en caso de que si
        if (!$materia->informacion_id) {
            $validacion = ['Sin asignar'];
        }

        return view('materias.acreditables.show', compact('materia', 'validacion', 'datos_materia', 'inscritos', 'periodos'));
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        // Busca todos los valores necesarios para editar un curso
        $materia = Materia::find($id);

        $categorias = Categoria::all();
        $profesores = Profesor::all();
        $trayectos = Trayecto::all();

        // Valida que exista
        existe($materia);

        return view('materias.acreditables.edit', compact('materia', 'categorias', 'profesores', 'trayectos'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $usuario = auth()->user();

        $validador = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:' . config('variables.materias.nombre')],
            'cupos' => ['required', 'numeric', 'max:' . config('variables.materias.cupos')],
            'desc_materia' => ['required', 'string', 'max:' . config('variables.materias.descripcion')],
            'trayecto' => ['required', 'numeric', 'not_in:0'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
            'estado_materia' => ['required'],
        ], [
            'nom_materia.required' => 'El nombre es necesario.',
            'nom_materia.string' => 'El nombre debe ser una oración.',
            'nom_materia.max' => 'El nombre no debe tener más de :max caracteres.',
            'trayecto.not_in' => 'El número de acreditable seleccionado es inválido.',
            'trayecto.numeric' => 'El número de acreditable debe ser un número.',
            'trayecto.required' => 'El número de la acreditable es necesario.',
            'trayecto.max' => 'El número de la acreditable no debe ser mayor a :max.',
            'cupos.required' => 'Los cupos son necesarios.',
            'cupos.numeric' => 'Los cupos deben ser un número.',
            'cupos.max' => 'Los cupos no deben ser mayor a :max',
            'desc_materia.required' => 'La descripción es necesaria.',
            'desc_materia.string' => 'La descripción debe ser una oración.',
            'desc_materia.max' => 'La descripción no debe ser mayor a :max caracteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
            'estado_materia.digits_between' => 'El estado de la materia debe ser alguno de la lista.',
        ]);
        validacion($validador, 'error', 'Materia');

        // Busca la relacion curso - informacion
        $informacion = Informacion_materia::updateOrCreate(
            ['id' =>  $id],
            [
                'metodologia' => $request['metodologia'] === '0' ? 'Sin asignar' : $request['metodologia'],
                'categoria_id' => $request['categoria'] === '0' ? null : $request['categoria'],
                'profesor_id' => $request['profesor'] === '0' ? null : $request['profesor'],
                'horario_id' => $request['horario'] === '0' ? null : $request['horario'],
            ],
        );

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró la información adicional de la acreditable ({$request['nom_materia']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        // Busca la imagen, si hay la actualiza borrando la anterior
        $materia = Materia::find($id);
        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            Storage::delete('public/' . $materia->imagen_materia);

            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request['nom_materia'] . '.jpg', 'public');

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Actualizó la imagen de la acreditable ({$request['nom_materia']}) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);
        }

        // Actualiza los cupos disponibles
        if ($materia->cupos !== $request['cupos']) {
            $materia->cupos > $request['cupos'] ?
                $materia->cupos_disponibles -= intval($materia->cupos) - $request['cupos'] : $materia->cupos_disponibles += $request['cupos'] - intval($materia->cupos);

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Se actualizaron los cupos y cupos disponibles de la acreditable ({$request['nom_materia']}) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);
        }

        // Actualiza los campos
        $materia->update([
            'nom_materia' => $request['nom_materia'],
            'cupos' => $request['cupos'],
            'trayecto_id' => $request['trayecto'],
            'desc_materia' => $request['desc_materia'],
            'imagen_materia' => $imagen ? $imagen : $materia->imagen_materia,
            'estado_materia' => $request['estado_materia'],
            'informacion_id' => $informacion->id,
        ]);

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó la acreditable ({$request['nom_materia']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('materias')->with('actualizado', 'Curso actualizado exitosamente');
    }

    public function pdf($materiaID, $periodoID)
    {
        rol('Coordinador');

        try {
            $materia = Materia::findOrFail($materiaID);
            $periodo = Periodo::findOrFail($periodoID);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('solicitudInvalida', 'La acreditable o periodo no son válidos');
        }

        $periodoID = $periodo->id;
        $estudiantes = $materia->estudiantesPeriodo($periodoID);

        if (count($estudiantes) < 1) {
            return redirect()->back()->with('noEstudiantes', "No hubo estudiantes inscritos en la materia durante el periodo {$periodo->formato()}");
        }

        $pdf = Pdf::loadView('materias.acreditables.pdf', ['materia' => $materia, 'periodo' => $periodo, 'estudiantes' => $estudiantes]);

        // Pie de página
        $canvas = $pdf->getCanvas();
        $x = $canvas->get_width() / 6;
        $y = $canvas->get_height() - 35;

        $canvas->page_text($x, $y, "Av. Universidad (al lado del Comando FAN-peaje) y Av. Ricaurte, Urb. Industrial SOCIO (frente MAVIPLANCA).", 'times-roman', 8, array(0, 0, 0));

        $canvas->page_text($x + 20, $y + 10, "Telefax (0244) 3217054 / 3222822 / 3211478. Apartado 109. Código Postal 2121 Rif: G-20009565-2", 'times-roman', 8, array(0, 0, 0));

        return $pdf->stream('Comprobante de inscripcion.pdf');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $materia = Materia::find($id);
        $materia->delete();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Borró la acreditable ({$materia->nom_materia}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
