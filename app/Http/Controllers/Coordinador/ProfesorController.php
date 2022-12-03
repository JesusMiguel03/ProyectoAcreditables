<?php

namespace App\Http\Controllers\Coordinador;

use App\Models\Profesor\Profesor;
use App\Http\Controllers\Controller;
use App\Models\DatosAcademicos\Pnf;
use App\Models\Profesor\Especialidad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfesorController extends Controller
{
    public function __construct()
    {
        // Valida autenticación y permisos
        $this->middleware('auth');
        $this->middleware('can:perfiles');
    }

    public function index()
    {
        // Lista profesores, usuarios, áreas de conocimiento y departamentos
        $profesores = Profesor::all();
        $usuarios = User::all();
        $conocimientos = Especialidad::all();
        $departamentos = Pnf::all();

        return view('aside.principal.profesores.index', compact('profesores', 'usuarios', 'conocimientos', 'departamentos'));
    }

    public function store(Request $request)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'usuarios' => ['required', 'not_in:0'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{7}$/'],
            'conocimiento' => ['required'],
            'casa' => ['required', 'string', 'max:10'],
            'calle' => ['required', 'string', 'max:20'],
            'urb' => ['required', 'string', 'max:20'],
            'ciudad' => ['required', 'string', 'max:30'],
            'estado' => ['required', 'string', 'max:16'],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
            'departamento' => ['required'],
        ], [
            'usuarios.not_in' => 'El usuario seleccionado es inválido.',
        ]);

        if ($validador->fails())
        {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Guarda un profesor
        Profesor::create([
            'usuario_id' => $request->get('usuarios'),
            'telefono' => $request->get('codigo') . $request->get('telefono'),
            'conocimiento_id' => $request->get('conocimiento'),
            'casa' => $request->get('casa'),
            'calle' => $request->get('calle'),
            'urb' => $request->get('urb'),
            'ciudad' => $request->get('ciudad'),
            'estado' => $request->get('estado'),
            'fecha_de_nacimiento' => $request->get('fecha_de_nacimiento'),
            'fecha_ingreso_institucion' => $request->get('fecha_ingreso_institucion'),
            'departamento_id' => $request->get('departamento'),
            'estado_profesor' => 1
        ])->save();

        return redirect('profesores')->with('creado', 'creado');
    }

    public function show($id)
    {
        // Muestra al profesor específico
        $profesor = Profesor::find($id);

        return view('aside.principal.profesores.show', compact('profesor'));
    }

    public function edit($id)
    {
        // Lista las áreas de conocimiento y al profesor
        $conocimientos = Especialidad::all();
        $profesor = Profesor::find($id);
        return view('aside.principal.profesores.edit', compact('profesor', 'conocimientos'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'telefono' => ['required', 'string', 'regex:/^[0-9]{7}$/'],
            'conocimiento' => ['required'],
            'casa' => ['required', 'string', 'max:10'],
            'calle' => ['required', 'string', 'max:20'],
            'urb' => ['required', 'string', 'max:20'],
            'ciudad' => ['required', 'string', 'max:30'],
            'estado' => ['required', 'string', 'max:16'],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
            'estado_profesor' => ['required', 'not_in:0'],
        ], [
            'usuarios.not_in' => 'El usuario seleccionado es inválido.',
            'estado_profesor.not_in' => 'El estado del profesor es inválido.'
        ]);

        if ($validador->fails())
        {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

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
