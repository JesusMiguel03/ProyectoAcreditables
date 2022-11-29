<?php

namespace App\Http\Controllers\Informacion;

use App\Models\Informacion\Noticia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticiasController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $noticias = Noticia::all();
        return view('aside.informacion.noticias.index', compact('noticias'));
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
            'encabezado' => ['required', 'string', 'max:25'],
            'desc_noticia' => ['required', 'string', 'max:150'],
            'mostrar' => ['required', 'max:2', 'not_in:0'],
        ], [
            'desc_noticia.max' => 'La descripcion no debe ser mayor a 150 carácteres.',
            'mostrar.not_in' => 'El campo mostrar noticia es inválido.',
            'mostrar.required' => 'El campo mostrar noticia es necesiario.',
            'mostrar.max' => 'El campo mostrar noticia solo puede ser si o no.'
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Sin uso [valida que no se repita]
        // if (Noticia::where('', '=', $request->get(''))->first()) {
        //     return redirect('trayecto')->with('registrada', 'Aula ocupada');
        // }

        $noticia = new Noticia();
        $noticia->encabezado = request('encabezado');
        $noticia->desc_noticia = request('desc_noticia');
        $noticia->mostrar = request('mostrar');
        $noticia->save();

        return redirect('noticias')->with('creado', 'El aula fue encontrada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noticia = Noticia::find($id);
        return view('aside.informacion.noticias.edit', compact('noticia'));
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
            'encabezado' => ['required', 'string', 'max:25'],
            'desc_noticia' => ['required', 'string', 'max:150'],
            'mostrar' => ['required', 'max:2', 'not_in:0'],
        ], [
            'desc_noticia.max' => 'La descripcion no debe ser mayor a 150 carácteres.',
            'mostrar.not_in' => 'El campo mostrar noticia es inválido.',
            'mostrar.required' => 'El campo mostrar noticia es necesiario.',
            'mostrar.max' => 'El campo mostrar noticia solo puede ser si o no.'
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        $informacion = request()->except(['_token', '_method']);
        Noticia::where('id', '=', $id)->update($informacion);
        return redirect('noticias')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
