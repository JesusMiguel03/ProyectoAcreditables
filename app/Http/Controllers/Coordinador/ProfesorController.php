<?php

namespace App\Http\Controllers\Coordinador;

use App\Models\Profesor\Profesor;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfesorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:perfiles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = Profesor::all();
        $usuarios = User::all();
        return view('aside.principal.profesores.index', compact('profesores', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'usuarios' => ['required'],
            'titulo' => ['required', 'string', 'max:50'],
            'direccion' => ['required', 'string', 'max:50'],
            'ciudad' => ['required', 'string', 'max:50'],
            'estado' => ['required', 'string', 'max:50'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
            'fecha_de_nacimiento' => ['required', 'string'],
            'fecha_ingreso_plantel' => ['required', 'string'],
        ]);

        if ($validador->fails())
        {
            return redirect('profesores')->withErrors($validador)->withInput();
        }

        if (Profesor::where('usuario_id', '=', request('usuarios'))->first())
        {
            return redirect('profesores')->with('existente', 'categoria existente');
        }
        
        $profesor = Profesor::create([
            'usuario_id' => request('usuarios'),
            'titulo' => request('titulo'),
            'direccion' => request('direccion'),
            'ciudad' => request('ciudad'),
            'estado' => request('estado'),
            'telefono' => request('telefono'),
            'fecha_de_nacimiento' => request('fecha_de_nacimiento'),
            'fecha_ingreso_plantel' => request('fecha_ingreso_plantel'),
            'estado_profesor' => 1
        ]);
        $profesor->save();

        return redirect('profesores')->with('creado', 'La categoria fue creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profesor = Profesor::find($id);

        return view('aside.principal.profesores.show', compact('profesor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profesor = Profesor::find($id);
        return view('aside.principal.profesores.edit', compact('profesor'));
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
        $profesor = Profesor::find($id);
        $profesor->usuario_id = $id;
        $profesor->titulo = request('titulo');
        $profesor->direccion = request('direccion');
        $profesor->ciudad = request('ciudad');
        $profesor->estado = request('estado');
        $profesor->fecha_de_nacimiento = request('fecha_de_nacimiento');
        $profesor->fecha_ingreso_plantel = request('fecha_ingreso_plantel');
        $profesor->estado_profesor = request('estado_profesor');
        $profesor->save();

        return redirect('profesores')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
