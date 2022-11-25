<?php

namespace App\Http\Controllers\Materia;

// Controladores, ayudas
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

// Modelos
use App\Models\Materia\Materia;
use App\Models\Materia\Categoria;
use App\Models\Materia\Informacion_materia;
use App\Models\Profesor\Profesor;

class MateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:gestionar.materias')->only('create', 'edit', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:40'],
            'cupos' => ['required', 'numeric', 'max:50'],
            'desc_materia' => ['required', 'string', 'max:255'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'cupos.max' => 'El campo cupos no debe ser mayor a :max',
            'desc_materia.max' => 'El campo descripción no debe ser mayor a :max carácteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);

        $materia = new Materia();

        if ($validator->fails()) {
            return redirect('materias/create')->withErrors($validator)->withInput();
        };

        if ($request->hasFile('imagen_materia')) {
            $imagen = $request->file('imagen_materia')->storeAs('uploads', date('Y-m-d') . $request->get('nom_materia') . '.jpg', 'public');
            $materia->imagen_materia = $imagen;
        } else {
            $materia->imagen_materia = null;
        }

        $materia->nom_materia = $request->get('nom_materia');
        $materia->cupos = $request->get('cupos');
        $materia->cupos_disponibles = $materia->cupos;
        $materia->desc_materia = $request->get('desc_materia');
        $materia->estado_materia = 'Inactivo';
        $materia->informacion_id = null;

        $materia->save();

        return redirect('materias')->with('creado', 'Curso creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Busca la id del curso y crea una variable con valores por defecto
        $materia = Materia::find($id);

        $validacion = [];
        $datos_materia = ['Tipo', 'Categoria', 'Horario'];

        // Valida si existe la relacion y asigna en caso de que si
        if (!$materia->informacion_id) {
            $validacion = ['Sin asignar'];
        }

        return view('materias.show', compact('materia', 'validacion', 'datos_materia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Busca todos los valores necesarios para editar un curso
        $materia = Materia::find($id);
        // $horarios = Horario::all();
        $categorias = Categoria::all();
        $profesores = Profesor::all();

        return view('materias.edit', compact('materia', 'categorias', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validador = Validator::make($request->all(), [
            'nom_materia' => ['required', 'string', 'max:40'],
            'cupos' => ['required', 'numeric', 'max:50'],
            'desc_materia' => ['required', 'string', 'max:255'],
            'imagen_materia' => ['image', 'mimes:jpg', 'max:1024'],
            'estado_materia' => ['required'],
            'categoria' => ['required'],
            'tipo' => ['required'],
            'profesor' => ['required'],
        ], [
            'cupos.max' => 'El campo cupos no debe ser mayor a :max',
            'desc_materia.max' => 'El campo descripción no debe ser mayor a :max carácteres',
            'imagen_materia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_materia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
            'estado_materia.digits_between' => 'El valor del campo estado debe ser alguno de la lista.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput();
        }

        // Busca la relacion curso <-> informacion
        $informacion = Informacion_materia::updateOrCreate(
            ['id' =>  $id],
            [
                'metodologia_aprendizaje' => $request->get('tipo'),
                'categoria_id' => $request->get('categoria'),
                'profesor_id' => $request->get('profesor'),
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
        $materia->cupos = $request->get('cupos');
        $materia->desc_materia = $request->get('desc_materia');
        $materia->imagen_materia = $imagen ? $imagen : $materia->imagen_materia;
        $materia->estado_materia = $request->get('estado_materia');
        $materia->informacion_id = $informacion->id;
        $materia->save();


        return redirect('materias')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
