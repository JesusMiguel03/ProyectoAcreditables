<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Profesor;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Trayecto;
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

            foreach ($materias as $materia) {
                $materia->update([
                    'cupos_disponibles' => $materia->cupos - count($materia->estudiantes)
                ]);
            }
            $trayectos = Trayecto::all();

            return view('materias.acreditables.index', compact('materias', 'trayectos'));
        }

        // Profesor
        if (rol('Profesor')) {

            // Perfil de profesor
            if ($usuario->profesor) {
                $materiasImpartidasProfesor = [];
        
                foreach ($usuario->profesor->imparteMateria as $materia) {
                    array_push($materiasImpartidasProfesor, $materia->id);
                }
        
                $materias = Materia::whereIn('informacion_id', $materiasImpartidasProfesor)->get();

                if (!empty($materias)) {
                    foreach ($materias as $materia) {
                        $materia->update([
                            'cupos_disponibles' => $materia->cupos - count($materia->estudiantes)
                        ]);
                    }
                }

                return view('materias.acreditables.index', compact('materias'));
            }

            $materias = [];

            return view('materias.acreditables.index', compact('materias'));
        }

        // Estudiante
        if (rol('Estudiante')) {

            // No tiene perfil academico
            if (empty($usuario->estudiante->pnf) && empty($usuario->estudiante->trayecto)) {
                return view('materias.acreditables.index');
            }

            // Está inscrito.
            if ($usuario->estudiante->inscrito) {
                $materias = Materia::find($usuario->estudiante->inscrito->materia_id ?? null);

                $materias->update([
                    'cupos_disponibles' => $materias->cupos - count($materias->estudiantes)
                ]);
                
                return view('materias.acreditables.index', compact('materias'));

            } else {

                // Materias disponibles
                $materias = Materia::where([
                    ['trayecto_id', '=', $usuario->estudiante->trayecto->id], ['estado_materia', '=', 'Activo']
                ])->get();

                foreach ($materias as $materia) {
                    $materia->update([
                        'cupos_disponibles' => $materia->cupos - count($materia->estudiantes)
                    ]);
                }

                $mostrarTabla = count($materias) >= config('variables.carrusel');
                
                return view('materias.acreditables.index', compact('materias', 'mostrarTabla'));
            }
        }
        
        // Trae las materias activas y disponibles
        $materias = Materia::where([['estado_materia', '=', 'Activo'], ['cupos_disponibles', '>', 0]])->get();

        return view('materias.acreditables.index', compact('materias'));
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
        validacion($validador, 'error');

        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request['nom_materia'] . '.jpg', 'public');
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
        $inscritos = Estudiante_materia::where('materia_id', '=', $id)->get();

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
        validacion($validador, 'error');

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

        // Busca la imagen, si hay la actualiza borrando la anterior
        $materia = Materia::find($id);
        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            Storage::delete('public/' . $materia->imagen_materia);

            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request['nom_materia'] . '.jpg', 'public');
        }

        // Actualiza los cupos disponibles
        if ($materia->cupos !== $request['cupos']) {
            $materia->cupos > $request['cupos'] ?
                $materia->cupos_disponibles -= intval($materia->cupos) - $request['cupos'] : $materia->cupos_disponibles += $request['cupos'] - intval($materia->cupos);
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

        return redirect('materias')->with('actualizado', 'Curso actualizado exitosamente');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        Materia::find($id)->delete();

        return redirect()->back()->with('borrado', 'borrado');
    }
}
