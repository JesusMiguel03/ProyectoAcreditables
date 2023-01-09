<?php

namespace App\Http\Controllers\Materia;


use App\Http\Controllers\Controller;
use App\Models\Academico\Profesor;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Materia\Materia;
use App\Models\Materia\Categoria;
use App\Models\Materia\Informacion_materia;
use Illuminate\Support\Facades\DB;

class MateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso(['materias.principal', 'materias.estudiante']);

        $periodo = periodoActual();

        if (estudiante(auth()->user(), 'materia')) {
            $materias = Materia::find(estudiante(auth()->user(), 'materia'));

            return view('materias.acreditables.index', compact('materias', 'periodo'));
        }

        if (rol('Profesor') && profesor()) {
            $materiasImpartidasProfesor = [];
            foreach (profesor()->imparteMateria as $materia) {
                array_push($materiasImpartidasProfesor, $materia->id);
            }

            $materias = Materia::whereIn('informacion_id', $materiasImpartidasProfesor)->get();

            return view('materias.acreditables.index', compact('materias', 'periodo'));
        }

        $materias = Materia::where([['estado_materia', '=', 'Activo'], ['cupos_disponibles', '>', 0]])->get();

        return view('materias.acreditables.index', compact('materias', 'periodo'));
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
            'num_acreditable.not_in' => 'El campo número de la acreditable es inválido.',
            'num_acreditable.required' => 'El campo número de la acreditable es necesario.',
            'num_acreditable.max' => 'El campo número de la acreditable no debe ser mayor a :max.',
            'cupos.max' => 'El campo cupos no debe ser mayor a :max',
            'desc_materia.max' => 'El campo descripción no debe ser mayor a :max carácteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador);

        /**
         * ! Campo (cupos) acepta letra e y no muestra mensaje de error.
         */

        /**
         *  Evita duplicidad
         * 
         *  ! Revisar
         */
        // duplicado(
        //     Materia::where([['nom_materia', '=', $request->get('nom_materia')], ['num_acreditable', '=', $request->get('num_acreditable')]])
        // );

        $imagen = '';

        $request->hasFile('imagen_materia') ?
            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request->get('nom_materia') . '.jpg', 'public') :
            $imagen = null;

        Materia::create([
            'informacion_id' => null,
            'nom_materia' => $request->get('nom_materia'),
            'cupos' => $request->get('cupos'),
            'cupos_disponibles' => $request->get('cupos'),
            'desc_materia' => $request->get('desc_materia'),
            'num_acreditable' => $request->get('num_acreditable'),
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
        $periodo = periodoActual();

        existe($materia);

        // Trae a todos los estudiantes inscritos
        $inscritos = Estudiante_materia::where('materia_id', '=', $id)->get();

        // En caso de que no se complete la materia se colocan valores por defecto
        $validacion = [];
        $datos_materia = ['Tipo', 'Categoria', 'Horario'];

        // Valida si existe la relacion y asigna en caso de que si
        if (!$materia->informacion_id) {
            $validacion = ['Sin asignar'];
        }

        return view('materias.acreditables.show', compact('materia', 'validacion', 'datos_materia', 'inscritos', 'periodo'));
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
        $periodo = periodoActual();

        // Valida que exista
        existe($materia);

        return view('materias.acreditables.edit', compact('materia', 'categorias', 'profesores', 'horarios', 'periodo'));
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
            'num_acreditable.not_in' => 'El campo número de la acreditable es inválido.',
            'num_acreditable.required' => 'El campo número de la acreditable es necesario.',
            'cupos.max' => 'El campo cupos no debe ser mayor a :max',
            'desc_materia.max' => 'El campo descripción no debe ser mayor a :max carácteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
            'estado_materia.digits_between' => 'El valor del campo estado debe ser alguno de la lista.',
        ]);
        validacion($validador);

        /**
         *  Evita duplicidad
         * 
         *  ! Revisar
         */
        // duplicado(
        //     Materia::where([['nom_materia', '=', $request->get('nom_materia')], ['num_acreditable', '=', $request->get('num_acreditable')]])
        // );

        // Busca la relacion curso - informacion
        $informacion = Informacion_materia::updateOrCreate(
            ['id' =>  $id],
            [
                'metodologia_aprendizaje' => $request->get('tipo') === '0' ? 'Sin asignar' : $request->get('tipo'),
                'categoria_id' => $request->get('categoria') === '0' ? null : $request->get('categoria'),
                'profesor_id' => $request->get('profesor') === '0' ? null : $request->get('profesor'),
                'horario_id' => $request->get('horario') === '0' ? null : $request->get('horario'),
            ],
        );

        // Busca la imagen, si hay la actualiza borrando la anterior
        $materia = Materia::find($id);
        $imagen = null;

        if ($request->hasFile('imagen_materia')) {
            Storage::delete('public/' . $materia->imagen_materia);

            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request->get('nom_materia') . '.jpg', 'public');
        }

        // Actualiza los campos
        $materia->nom_materia = $request->get('nom_materia');

        if ($materia->cupos !== $request->get('cupos')) {
            $materia->cupos > $request->get('cupos') ?
                $materia->cupos_disponibles -= intval($materia->cupos) - $request->get('cupos') : $materia->cupos_disponibles += $request->get('cupos') - intval($materia->cupos);
        }
        $materia->cupos = $request->get('cupos');


        $materia->desc_materia = $request->get('desc_materia');
        $materia->imagen_materia = $imagen ? $imagen : $materia->imagen_materia;
        $materia->estado_materia = $request->get('estado_materia');
        $materia->informacion_id = $informacion->id;
        $materia->save();


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
