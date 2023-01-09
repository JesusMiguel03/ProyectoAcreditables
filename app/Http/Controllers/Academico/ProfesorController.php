<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\AreaConocimiento;
use App\Models\Academico\Profesor;
use App\Models\Academico\Pnf;
use App\Http\Controllers\Controller;
use App\Models\Materia\Informacion_materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfesorController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Lista profesores, usuarios, áreas de conocimiento y departamentos
        $profesores = Profesor::all();
        $usuarios = User::all();
        $conocimientos = AreaConocimiento::all();
        $departamentos = Pnf::all();
        $periodo = periodoActual();

        return view('academico.profesores.index', compact('profesores', 'usuarios', 'conocimientos', 'departamentos', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'usuarios' => ['required', 'not_in:0'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{' . (config('variables.profesores.telefono') - 4) . '}$/'],
            'conocimiento' => ['required'],
            'casa' => ['required', 'string', 'max:' . config('variables.profesores.casa')],
            'calle' => ['required', 'string', 'max:' . config('variables.profesores.calle')],
            'urb' => ['required', 'string', 'max:' . config('variables.profesores.urb')],
            'ciudad' => ['required', 'string', 'max:' . config('variables.profesores.ciudad')],
            'estado' => ['required', 'string', 'max:' . config('variables.profesores.estado')],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
            'departamento' => ['required'],
        ], [
            'usuarios.not_in' => 'El usuario seleccionado es inválido.',
            'telefono.regex' => 'El número de teléfono debe tener ' . (config('variables.profesores.telefono') - 4) . ' números.',
            'conocimiento.required' => 'El área de conocimiento es requerida',
            'casa.required' => 'El campo de casa es requerida',
            'casa.max' => 'El campo de casa no debe contener más de :max carácteres',
            'calle.required' => 'El campo de calle es requerida',
            'calle.max' => 'El campo de calle no debe contener más de :max carácteres',
            'urb.required' => 'El campo de urbanización es requerida',
            'urb.max' => 'El campo de urbanización no debe contener más de :max carácteres',
            'ciudad.required' => 'El campo de ciudad es requerida',
            'ciudad.max' => 'El campo de ciudad no debe contener más de :max carácteres',
            'estado.required' => 'El campo de estado es requerida',
            'estado.max' => 'El campo de estado no debe contener más de :max carácteres',
        ]);
        validacion($validador);

        // Guarda un profesor
        Profesor::create([
            'usuario_id' => $request->get('usuarios'),
            'conocimiento_id' => $request->get('conocimiento'),
            'departamento_id' => $request->get('departamento'),
            'telefono' => $request->get('codigo') . $request->get('telefono'),
            'casa' => $request->get('casa'),
            'calle' => $request->get('calle'),
            'urb' => $request->get('urb'),
            'ciudad' => $request->get('ciudad'),
            'estado' => $request->get('estado'),
            'fecha_de_nacimiento' => $request->get('fecha_de_nacimiento'),
            'fecha_ingreso_institucion' => $request->get('fecha_ingreso_institucion'),
            'estado_profesor' => 1
        ])->save();

        return redirect('profesores')->with('creado', 'creado');
    }

    public function show($id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        $materias = [];

        $materiasImpartidas = Informacion_materia::where('profesor_id', '=', $id)->get();
        if (!empty($materiasImpartidas)) {
            foreach ($materiasImpartidas as $materiaImpartida) {
                array_push($materias, array($materiaImpartida->materia->nom_materia, $materiaImpartida->materia->id));
            }
        }

        // Muestra al profesor específico
        $profesor = Profesor::find($id);
        $periodo = periodoActual();

        return view('academico.profesores.show', compact('profesor', 'periodo', 'materias'));
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Lista las áreas de conocimiento y al profesor
        $conocimientos = AreaConocimiento::all();
        $profesor = Profesor::find($id);
        $periodo = periodoActual();

        return view('academico.profesores.edit', compact('profesor', 'conocimientos', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');
        
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'telefono' => ['required', 'string', 'regex:/^[0-9]{' . config('variables.profesores.telefono') . '}$/'],
            'conocimiento' => ['required'],
            'casa' => ['required', 'string', 'max:' . config('variables.profesores.casa')],
            'calle' => ['required', 'string', 'max:' . config('variables.profesores.calle')],
            'urb' => ['required', 'string', 'max:' . config('variables.profesores.urb')],
            'ciudad' => ['required', 'string', 'max:' . config('variables.profesores.ciudad')],
            'estado' => ['required', 'string', 'max:' . config('variables.profesores.estado')],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
            'estado_profesor' => ['required', 'not_in:0'],
        ], [
            'usuarios.not_in' => 'El usuario seleccionado es inválido.',
            'telefono.regex' => 'El número de teléfonod debe tener ' . config('variables.profesores.telefono') . ' números.',
            'conocimiento.required' => 'El área de conocimiento es requerida',
            'casa.required' => 'El campo de casa es requerida',
            'casa.max' => 'El campo de casa no debe contener más de :max carácteres',
            'calle.required' => 'El campo de calle es requerida',
            'calle.max' => 'El campo de calle no debe contener más de :max carácteres',
            'urb.required' => 'El campo de urbanización es requerida',
            'urb.max' => 'El campo de urbanización no debe contener más de :max carácteres',
            'ciudad.required' => 'El campo de ciudad es requerida',
            'ciudad.max' => 'El campo de ciudad no debe contener más de :max carácteres',
            'estado.required' => 'El campo de estado es requerida',
            'estado.max' => 'El campo de estado no debe contener más de :max carácteres',
            'estado_profesor.not_in' => 'El estado del profesor es inválido.'
        ]);

        validacion($validador);

        // Busca y actualiza
        Profesor::updateOrCreate(
            ['id' => $id],
            [
                'telefono' => $request->get('codigo') . $request->get('telefono'),
                'conocimiento_id' => $request->get('conocimiento'),
                'casa' => $request->get('casa'),
                'calle' => $request->get('calle'),
                'urb' => $request->get('urb'),
                'ciudad' => $request->get('ciudad'),
                'estado' => $request->get('estado'),
                'fecha_de_nacimiento' => $request->get('fecha_de_nacimiento'),
                'fecha_ingreso_institucion' => $request->get('fecha_ingreso_institucion'),
                'estado_profesor' => $request->get('estado_profesor'),
            ]
        );

        return redirect('profesores')->with('actualizado', 'actualizado');
    }
}
