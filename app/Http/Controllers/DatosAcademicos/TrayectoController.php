<?php

namespace App\Http\Controllers\DatosAcademicos;

use App\Models\DatosAcademicos\Trayecto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrayectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:trayecto');
    }

    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $trayectos = Trayecto::all();
        return view('aside.academico.trayecto.index', compact('trayectos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validador = Validator::make($request->all(), [
    //         'num_trayecto' => ['required', 'integer', 'max:4'],
    //     ]);

    //     if ($validador->fails()) {
    //         return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
    //     }

    //     if (Trayecto::where('num_trayecto', '=', $request->get('num_trayecto'))->first()) {
    //         return redirect('trayecto')->with('registrada', 'Aula ocupada');
    //     }

    //     $trayecto = new Trayecto();
    //     $trayecto->num_trayecto = request('num_trayecto');
    //     $trayecto->save();

    //     return redirect('trayecto')->with('creado', 'El aula fue encontrada exitosamente');
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trayecto = Trayecto::find($id);
        return view('aside.academico.trayecto.edit', compact('trayecto'));
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
            'num_trayecto' => ['required', 'number', 'max:4'],
        ], [
            'num_trayecto.required' => 'El campo número es necesario.',
            'num_trayecto.number' => 'El campo número debe ser un número.',
            'num_trayecto.max' => 'El campo número no debe ser mayor a :max.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        if (Trayecto::where('num_trayecto', '=', $request->get('num_trayecto'))->first()) {
            return redirect('trayecto')->with('registrada', 'Aula ocupada');
        }

        $informacion = request()->except(['_token', '_method']);
        Trayecto::where('id', '=', $id)->update($informacion);
        return redirect('trayecto')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
