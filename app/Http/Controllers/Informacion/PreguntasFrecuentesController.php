<?php

namespace App\Http\Controllers\Informacion;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Preguntas_frecuentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreguntasFrecuentesController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $preguntas = Preguntas_frecuentes::all();
        return view('aside.informacion.preguntas.index', compact('preguntas'));
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
            'titulo' => ['required', 'string', 'max:30'],
            'explicacion' => ['required', 'string', 'max:255'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        $pregunta = new Preguntas_frecuentes();
        $pregunta->titulo = request('titulo');
        $pregunta->explicacion = request('explicacion');
        $pregunta->save();

        return redirect('preguntas-frecuentes')->with('creado', 'El aula fue encontrada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pregunta = Preguntas_frecuentes::find($id);
        return view('aside.informacion.preguntas.edit', compact('pregunta'));
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
            'titulo' => ['required', 'string', 'max:30'],
            'explicacion' => ['required', 'string', 'max:255'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        $informacion = request()->except(['_token', '_method']);
        Preguntas_frecuentes::where('id', '=', $id)->update($informacion);
        return redirect('preguntas-frecuentes')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
