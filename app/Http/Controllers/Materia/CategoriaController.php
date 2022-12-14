<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Materia\Categoria;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:categorias');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $categorias = Categoria::all();
        return view('aside.materias.categorias.index', compact('categorias', 'periodo'));
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
            'nom_categoria' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:50']
        ], [
            'nom_categoria.required' => 'El campo categoria es necesario.',
            'nom_categoria.string' => 'El campo categoria debe ser una oración.',
            'nom_categoria.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'El campo categoria debe contener mas de :max carácteres.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        if (Categoria::where('nom_categoria', '=', $request->get('nom_categoria'))->first()) {
            return redirect('categoria')->with('existente', 'categoria existente');
        }


        $categoria = new Categoria();
        $categoria->nom_categoria = request('nom_categoria');
        $categoria->save();

        return redirect('categoria')->with('creado', 'La categoria fue creada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $categoria = Categoria::findOrFail($id);
        return view('aside.materias.categorias.edit', compact('categoria', 'periodo'));
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
            'nom_categoria' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:50']
        ], [
            'nom_categoria.required' => 'El campo categoria es necesario.',
            'nom_categoria.string' => 'El campo categoria debe ser una oración.',
            'nom_categoria.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'El campo categoria debe contener mas de :max carácteres.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        $informacion = request()->except(['_token', '_method']);
        Categoria::where('id', '=', $id)->update($informacion);
        return redirect('categoria')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
