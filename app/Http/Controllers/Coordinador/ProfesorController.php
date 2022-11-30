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
            'usuarios' => ['required', 'not_in:0'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{7}$/'],
            'titulo' => ['required', 'string', 'max:50'],
            'casa' => ['required', 'string', 'max:10'],
            'calle' => ['required', 'string', 'max:20'],
            'urb' => ['required', 'string', 'max:20'],
            'ciudad' => ['required', 'string', 'max:30'],
            'estado' => ['required', 'string', 'max:16'],
            'fecha_de_nacimiento' => ['required', 'date'],
            'fecha_ingreso_institucion' => ['required', 'date'],
        ], [
            'usuarios.not_in' => 'El usuario seleccionado es inválido.'
        ]);

        if ($validador->fails())
        {
            dd($validador->errors()->getMessages());
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        if (Profesor::where('usuario_id', '=', request('usuarios'))->first())
        {
            return redirect()->back()->with('existente', 'categoria existente');
        }
        
        Profesor::create([
            'usuario_id' => $request->get('usuarios'),
            'telefono' => $request->get('codigo') . $request->get('telefono'),
            'titulo' => $request->get('titulo'),
            'casa' => $request->get('casa'),
            'calle' => $request->get('calle'),
            'urb' => $request->get('urb'),
            'ciudad' => $request->get('ciudad'),
            'estado' => $request->get('estado'),
            'fecha_de_nacimiento' => $request->get('fecha_de_nacimiento'),
            'fecha_ingreso_institucion' => $request->get('fecha_ingreso_institucion'),
            'estado_profesor' => 1
        ])->save();

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
        $validador = Validator::make($request->all(), [
            'telefono' => ['required', 'string', 'regex:/^[0-9]{7}$/'],
            'titulo' => ['required', 'string', 'max:50'],
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

        Profesor::updateOrCreate(
            ['id' => $id],
            [
                'telefono' => $request->get('codigo') . $request->get('telefono'),
                'titulo' => $request->get('titulo'),
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

        return redirect('profesores')->with('actualizado', 'Datos actualizados');
    }
}
