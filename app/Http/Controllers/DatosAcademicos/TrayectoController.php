<?php

namespace App\Http\Controllers\DatosAcademicos;

use App\Models\DatosAcademicos\Trayecto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrayectoController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $trayectos = Trayecto::all();
        return view('academico.trayecto.index', compact('trayectos'));
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
            'numero' => ['required', 'integer', 'max:4'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        if (Trayecto::where('numero', '=', $request->get('numero'))->first()) {
            return redirect('trayecto')->with('registrada', 'Aula ocupada');
        }

        $trayecto = new Trayecto();
        $trayecto->numero = request('numero');
        $trayecto->save();

        return redirect('trayecto')->with('creado', 'El aula fue encontrada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trayecto = Trayecto::find($id);
        return view('academico.trayecto.edit', compact('trayecto'));
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
            'numero' => ['required', 'integer', 'max:4'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        if (Trayecto::where('numero', '=', $request->get('numero'))->first()) {
            return redirect('trayecto')->with('registrada', 'Aula ocupada');
        }

        $informacion = request()->except(['_token', '_method']);
        Trayecto::where('id', '=', $id)->update($informacion);
        return redirect('trayecto')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
