<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\AreaConocimiento;
use App\Models\Academico\Profesor;
use App\Models\Academico\PNF;
use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
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

        // Busca solamente a los usuarios registrados con rol de profesor
        $usuarios = User::whereHas('roles', function ($q) {
            $q->where('name', 'Profesor');
        })->get();

        $conocimientos = AreaConocimiento::all();
        $departamentos = PNF::all();

        return view('academico.profesores.index', compact('profesores', 'usuarios', 'conocimientos', 'departamentos'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Si el area de conocimiento esta vacia
        if ($request['vacio'] === '0') {
            return redirect()->back();
        }

        $request->merge(['codigoTelefono' => $request->codigo . $request->telefono]);
        $codigoTelefono = $request->codigo . $request->telefono;

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'usuarios' => ['required', 'not_in:0', 'unique:profesores,usuario_id'],
            'departamento' => ['required', 'not_in:0'],
            'conocimiento' => ['required', 'not_in:0'],
            'casa' => ['required', 'string', 'max:' . config('variables.profesores.casa')],
            'calle' => ['required', 'string', 'max:' . config('variables.profesores.calle')],
            'urb' => ['required', 'string', 'max:' . config('variables.profesores.urb')],
            'ciudad' => ['required', 'string', 'regex: ' . config('variables.regex.alfaespacio'), 'max:' . config('variables.profesores.ciudad')],
            'estado' => ['required', 'string', 'regex: ' . config('variables.regex.alfaespacio'), 'max:' . config('variables.profesores.estado')],
            'codigo' => ['required', 'not_in:0'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{7}$/'],
            'codigoTelefono' => ['unique:profesores,telefono'],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
        ], [
            'usuarios.required' => 'El usuario es necesario.',
            'usuarios.not_in' => 'El usuario seleccionado es inválido.',
            'usuarios.unique' => 'El usuario ya ha sido registrado.',
            'departamento.required' => 'El departamento es necesario.',
            'departamento.not_in' => 'El departamento seleccionado es inválido.',
            'codigo.required' => 'El código es necesario.',
            'codigo.not_in' => 'El código seleccionado es inválido.',
            'conocimiento.not_in' => 'El conocimiento seleccionado es inválido.',
            'conocimiento.required' => 'El área de conocimiento es necesario.',
            'telefono.regex' => 'El número de teléfono debe tener ' . (config('variables.profesores.telefono') - 4) . ' números.',
            'codigoTelefono.unique' => "El número de teléfono ($codigoTelefono) ya ha sido registrado.",
            'casa.required' => 'La casa es necesaria.',
            'casa.string' => 'La casa solo debe contener letras.',
            'casa.max' => 'La casa no debe contener más de :max caracteres.',
            'calle.required' => 'La calle es necesaria.',
            'calle.string' => 'La calle solo debe contener letras.',
            'calle.max' => 'La calle no debe contener más de :max caracteres.',
            'urb.required' => 'La urbanización es necesaria.',
            'urb.string' => 'La urbanización solo debe contener letras.',
            'urb.max' => 'La urbanización no debe contener más de :max caracteres.',
            'ciudad.required' => 'La ciudad es necesaria.',
            'ciudad.string' => 'La ciudad solo debe contener letras.',
            'ciudad.max' => 'La ciudad no debe contener más de :max caracteres.',
            'estado.required' => 'El estado es necesario.',
            'estado.string' => 'El estado solo debe contener letras.',
            'estado.max' => 'El estado no debe contener más de :max caracteres.',
            'fecha_de_nacimiento.required' => 'La fecha de nacimiento es necesaria.',
            'fecha_de_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha.',
            'fecha_ingreso_institucion.required' => 'La fecha de ingreso es necesaria.',
            'fecha_ingreso_institucion.date' => 'La fecha de ingreso debe ser una fecha.',
        ]);
        validacion($validar, 'error', 'Profesor');

        // Guarda un profesor
        $profesor = Profesor::create([
            'usuario_id' => $request['usuarios'],
            'conocimiento_id' => $request['conocimiento'],
            'departamento_id' => $request['departamento'],
            'telefono' => $request['codigo'] . $request['telefono'],
            'casa' => $request['casa'],
            'calle' => $request['calle'],
            'urb' => $request['urb'],
            'ciudad' => $request['ciudad'],
            'estado' => $request['estado'],
            'fecha_de_nacimiento' => $request['fecha_de_nacimiento'],
            'fecha_ingreso_institucion' => $request['fecha_ingreso_institucion'],
            'activo' => 1
        ]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró el perfil profesional de  ({$profesor->nombreProfesor()}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

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

        return view('academico.profesores.show', compact('profesor', 'materias'));
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Lista las áreas de conocimiento y al profesor
        $conocimientos = AreaConocimiento::all();
        $departamentos = PNF::all();
        $profesor = Profesor::find($id);

        return view('academico.profesores.edit', compact('profesor', 'conocimientos', 'departamentos'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        $request->merge(['codigoTelefono' => $request->codigo . $request->telefono]);
        $codigoTelefono = $request->codigo . $request->telefono;

        $CImin = config('variables.usuarios.cedula')[0];
        $CImax = config('variables.usuarios.cedula')[1];

        // Busca y actualiza
        $profesor = Profesor::find($id);
        $usuarioActualizar = User::where('id', '=', $profesor->usuario_id)->first();

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'not_in:0', 'string'],
            'cedula' => ['required', 'numeric', 'digits_between:' . $CImin . ',' . $CImax, 'unique:users,cedula,' . $usuarioActualizar->id],
            'departamento' => ['required', 'not_in:0'],
            'conocimiento' => ['required', 'not_in:0'],
            'activo' => ['required', 'not_in:0'],
            'casa' => ['required', 'string', 'max:' . config('variables.profesores.casa')],
            'calle' => ['required', 'string', 'max:' . config('variables.profesores.calle')],
            'urb' => ['required', 'string', 'max:' . config('variables.profesores.urb')],
            'ciudad' => ['required', 'string', 'regex: ' . config('variables.regex.alfaespacio'), 'max:' . config('variables.profesores.ciudad')],
            'estado' => ['required', 'string', 'regex: ' . config('variables.regex.alfaespacio'), 'max:' . config('variables.profesores.estado')],
            'codigo' => ['required', 'not_in:0'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{7}$/'],
            'codigoTelefono' => ["unique:profesores,telefono,$id"],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
        ], [
            'nombre.required' => 'El nombre es necesario.',
            'nombre.string' => 'El nombre debe ser una oración.',
            'nombre.regex' => 'El nombre solo puede contener letras.',
            'nombre.max' => 'El nombre no debe tener más de :max caracteres.',
            'apellido.required' => 'El apellido es necesario.',
            'apellido.string' => 'El apellido debe ser una oración.',
            'apellido.regex' => 'El apellido solo puede contener letras.',
            'apellido.max' => 'El apellido no debe tener más de :max caracteres.',
            'nacionalidad.required' => 'La nacionalidad es necesaria.',
            'nacionalidad.not_in' => 'La nacionalidad debe ser una de la lista.',
            'cedula.required' => 'La cédula es necesaria.',
            'cedula.numeric' => 'La cédula debe ser un número.',
            'cedula.unique' => 'La cédula debe ser única.',
            'cedula.digits_between' => 'La cedula debe estar entre los ' . $CImin . ' y ' . $CImax . ' dígitos.',
            'activo.required' => 'El estado del profesor es necesario.',
            'activo.not_in' => 'El estado del profesor seleccionado es inválido.',
            'departamento.required' => 'El departamento es necesario.',
            'departamento.not_in' => 'El departamento seleccionado es inválido.',
            'codigo.required' => 'El código es necesario.',
            'codigo.not_in' => 'El código seleccionado es inválido.',
            'conocimiento.not_in' => 'El conocimiento seleccionado es inválido.',
            'conocimiento.required' => 'El área de conocimiento es necesario.',
            'telefono.regex' => 'El número de teléfono debe tener ' . (config('variables.profesores.telefono') - 4) . ' números.',
            'codigoTelefono.unique' => "El número de teléfono ($codigoTelefono) ya ha sido registrado.",
            'casa.required' => 'La casa es necesaria.',
            'casa.string' => 'La casa solo debe contener letras.',
            'casa.max' => 'La casa no debe contener más de :max caracteres.',
            'calle.required' => 'La calle es necesaria.',
            'calle.string' => 'La calle solo debe contener letras.',
            'calle.max' => 'La calle no debe contener más de :max caracteres.',
            'urb.required' => 'La urbanización es necesaria.',
            'urb.string' => 'La urbanización solo debe contener letras.',
            'urb.max' => 'La urbanización no debe contener más de :max caracteres.',
            'ciudad.required' => 'La ciudad es necesaria.',
            'ciudad.string' => 'La ciudad solo debe contener letras.',
            'ciudad.max' => 'La ciudad no debe contener más de :max caracteres.',
            'ciudad.regex' => 'La ciudad solo puede contener letras y/o espacios.',
            'estado.required' => 'El estado es necesario.',
            'estado.regex' => 'El estado solo puede contener letras y/o espacios.',
            'estado.string' => 'El estado solo debe contener letras.',
            'estado.max' => 'El estado no debe contener más de :max caracteres.',
            'fecha_de_nacimiento.required' => 'La fecha de nacimiento es necesaria.',
            'fecha_de_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha.',
            'fecha_ingreso_institucion.required' => 'La fecha de ingreso es necesaria.',
            'fecha_ingreso_institucion.date' => 'La fecha de ingreso debe ser una fecha.',
        ]);
        validacion($validar, 'error', 'Profesor');

        $usuarioActualizar->update([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'nacionalidad' => $request->get('nacionalidad'),
            'cedula' => $request->get('cedula'),
        ]);

        $profesor->update([
            'telefono' => $request['codigo'] . $request['telefono'],
            'departamento_id' => $request['departamento'],
            'conocimiento_id' => $request['conocimiento'],
            'casa' => $request['casa'],
            'calle' => $request['calle'],
            'urb' => $request['urb'],
            'ciudad' => $request['ciudad'],
            'estado' => $request['estado'],
            'fecha_de_nacimiento' => $request['fecha_de_nacimiento'],
            'fecha_ingreso_institucion' => $request['fecha_ingreso_institucion'],
            'activo' => $request['activo'],
        ]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó el perfil profesional de  ({$profesor->nombreProfesor()}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('profesores')->with('actualizado', 'actualizado');
    }
}
