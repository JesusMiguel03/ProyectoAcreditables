<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
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
                'usuario' => 'Materias',
                'accion' => 'Los cupos disponibles han sido actualizados exitosamente',
                'estado' => 'success'
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
                    'usuario' => "Materias impartidas por {$profesor->nombreProfesor()}",
                    'accion' => 'Los cupos disponibles han sido actualizados exitosamente',
                    'estado' => 'success'
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
            $trayecto = $estudiante->trayecto->id;
            $perfilAcademico = empty($estudiante->pnf) && empty($estudiante->trayecto);

            // Última inscripción del estudiante.
            $estudianteInscrito = $estudiante->inscrito->last();

            // Si ya se inscribió busca el periodo en que lo hizo.
            $periodoUltimaInscripcion = null;

            if ($estudianteInscrito) $periodoUltimaInscripcion = $estudianteInscrito->periodoInscripcion()->formato();

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
                    'usuario' => "Materia - ({$materias->nom_materia})",
                    'accion' => 'Los cupos disponibles han sido actualizados exitosamente',
                    'estado' => 'success'
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
                            ->orWhere('estado_materia', '=', 'Finalizado');
                    })->get();

                // Actualiza los cupos disponibles
                $materias->map(function ($materia) {
                    $materia->actualizarCupos();
                });

                Bitacora::create([
                    'usuario' => "Materias de trayecto {$trayecto}",
                    'accion' => 'Los cupos disponibles han sido actualizados exitosamente',
                    'estado' => 'success'
                ]);

                $mostrarTabla = count($materias) >= config('variables.carrusel');

                $mostrar = 'noInscrito';

                return view('materias.acreditables.index', compact('materias', 'mostrarTabla', 'mostrar'));
            }
        }
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $validador = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:' . config('variables.materias.nombre')],
            'cupos' => ['required', 'numeric', 'max:' . config('variables.materias.cupos')],
            'desc_materia' => ['required', 'string', 'max:' . config('variables.materias.descripcion')],
            'trayecto' => ['required', 'numeric', 'max:4', 'not_in:0'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'trayecto.not_in' => 'El número de acreditable seleccionado es inválido.',
            'trayecto.required' => 'El número de la acreditable es necesario.',
            'trayecto.max' => 'El número de la acreditable no debe ser mayor a :max.',
            'cupos.max' => 'Los cupos no deben ser mayor a :max',
            'desc_materia.max' => 'La descripción no debe ser mayor a :max caracteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador, 'error', 'Materia');

        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request['nom_materia'] . '.jpg', 'public');

            Bitacora::create([
                'usuario' => "Materia - ({$request['nom_materia']})",
                'accion' => 'Se ha guardado la imagen exitosamente',
                'estado' => 'success'
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
            'usuario' => "Materia - ({$request['nom_materia']})",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
        ]);

        return redirect('materias')->with('creado', 'Curso creado exitosamente');
    }

    public function show($id)
    {
        // Valida si tiene el permiso
        permiso(['materias.principal', 'materias.estudiante']);

        // Busca el id del curso
        $materia = Materia::find($id);

        // Valida que exista
        existe($materia);

        if (!rol('Coordinador') && $materia->estado_materia === 'Inactivo' || $materia->estado_materia === 'Descontinuado') {
            return redirect()->back()->with('inactivo', 'La acreditable que desea buscar no se encuentra activa.');
        }

        // Evita que el estudiante vea las materias que no coinciden con su trayecto
        if (rol('Estudiante') && $materia->trayecto_id !== Auth::user()->estudiante->trayecto->id) {
            return redirect()->back();
        }

        // Trae a todos los estudiantes inscritos
        $inscritos = $materia->estudiantesPeriodoActual();

        $materia->actualizarCupos();

        Bitacora::create([
            'usuario' => "Materia - ({$materia->nom_materia})",
            'accion' => 'Se ha actualizado los cupos disponibles exitosamente',
            'estado' => 'success'
        ]);

        // En caso de que no se complete la materia se colocan valores por defecto
        $validacion = [];
        $datos_materia = ['Metodología', 'Categoria', 'Horario'];

        // Valida si existe la relacion y asigna en caso de que si
        if (!$materia->informacion_id) {
            $validacion = ['Sin asignar'];
        }

        return view('materias.acreditables.show', compact('materia', 'validacion', 'datos_materia', 'inscritos'));
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

        $validador = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:' . config('variables.materias.nombre')],
            'cupos' => ['required', 'numeric', 'max:' . config('variables.materias.cupos')],
            'desc_materia' => ['required', 'string', 'max:' . config('variables.materias.descripcion')],
            'trayecto' => ['required', 'numeric', 'not_in:0'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
            'estado_materia' => ['required'],
        ], [
            'trayecto.not_in' => 'El número de acreditable seleccionado es inválido.',
            'trayecto.required' => 'El número de la acreditable es necesario.',
            'trayecto.max' => 'El número de la acreditable no debe ser mayor a :max.',
            'cupos.max' => 'Los cupos no deben ser mayor a :max',
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
            'usuario' => "Materia - ({$request['nom_materia']})",
            'accion' => 'Se ha actualizado la información extra exitosamente',
            'estado' => 'success'
        ]);

        // Busca la imagen, si hay la actualiza borrando la anterior
        $materia = Materia::find($id);
        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            Storage::delete('public/' . $materia->imagen_materia);

            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request['nom_materia'] . '.jpg', 'public');

            Bitacora::create([
                'usuario' => "Materia - ({$request['nom_materia']})",
                'accion' => 'Se ha actualizado la imagen exitosamente',
                'estado' => 'success'
            ]);
        }

        // Actualiza los cupos disponibles
        if ($materia->cupos !== $request['cupos']) {
            $materia->cupos > $request['cupos'] ?
                $materia->cupos_disponibles -= intval($materia->cupos) - $request['cupos'] : $materia->cupos_disponibles += $request['cupos'] - intval($materia->cupos);

            Bitacora::create([
                'usuario' => "Materia - ({$request['nom_materia']})",
                'accion' => 'Se ha actualizado los cupos disponibles exitosamente',
                'estado' => 'success'
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
            'usuario' => "Materia - ({$request['nom_materia']})",
            'accion' => 'Se ha actualizado la acreditable exitosamente',
            'estado' => 'success'
        ]);

        return redirect('materias')->with('actualizado', 'Curso actualizado exitosamente');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $materia = Materia::find($id);
        $materia->delete();

        Bitacora::create([
            'usuario' => "Materia - ({$materia->nom_materia})",
            'accion' => 'Ha sido borrada',
            'estado' => 'warning'
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
