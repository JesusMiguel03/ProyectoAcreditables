<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Profesor;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Materia\Materia;
use App\Models\Materia\Categoria;
use App\Models\Materia\Informacion_materia;
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
        // Valida si tiene el permiso.
        permiso(['materias.principal', 'materias.estudiante']);

        // Si es un estudiante y está inscrito.
        if (datosUsuario(auth()->user(), 'Estudiante', 'materia')) {
            $materias = Materia::find(datosUsuario(auth()->user(), 'Estudiante', 'materia'));

            return view('materias.acreditables.index', compact('materias'));
        }

        // Si es un profesor y tiene perfil.
        if (rol('Profesor') && auth()->user()->profesor) {
            $materiasImpartidasProfesor = [];

            foreach (auth()->user()->profesor->imparteMateria as $materia) {
                array_push($materiasImpartidasProfesor, $materia->id);
            }

            $materias = Materia::whereIn('informacion_id', $materiasImpartidasProfesor)->get();

            return view('materias.acreditables.index', compact('materias'));
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
            'num_acreditable' => ['required', 'numeric', 'max:4', 'not_in:0'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'num_acreditable.not_in' => 'El número de acreditable seleccionado es inválido.',
            'num_acreditable.required' => 'El número de la acreditable es necesario.',
            'num_acreditable.max' => 'El número de la acreditable no debe ser mayor a :max.',
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
            'num_acreditable' => $request['num_acreditable'],
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
        $horarios = Horario::all();

        // Valida que exista
        existe($materia);

        return view('materias.acreditables.edit', compact('materia', 'categorias', 'profesores', 'horarios'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $validador = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:' . config('variables.materias.nombre')],
            'cupos' => ['required', 'numeric', 'max:' . config('variables.materias.cupos')],
            'desc_materia' => ['required', 'string', 'max:' . config('variables.materias.descripcion')],
            'num_acreditable' => ['required', 'numeric', 'not_in:0'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
            'estado_materia' => ['required'],
        ], [
            'num_acreditable.not_in' => 'El número de acreditable seleccionado es inválido.',
            'num_acreditable.required' => 'El número de la acreditable es necesario.',
            'num_acreditable.max' => 'El número de la acreditable no debe ser mayor a :max.',
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
            'num_acreditable' => $request['num_acreditable'],
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
