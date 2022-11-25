<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Materia\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('materias.informacion.categoria.index', compact('categorias'));
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
            'nom_categoria' => ['required', 'string', 'max:50']
        ]);

        if ($validador->fails())
        {
            return redirect('categoria/create')->withErrors($validador)->withInput();
        }

        if (Categoria::where('nom_categoria', '=', $request->get('nom_categoria'))->first())
        {
            return redirect('categoria')->with('error', 'categoria existente');
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
        $categoria = Categoria::findOrFail($id);
        return view('materias.informacion.categoria.edit', compact('categoria'));
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
        $informacion = request()->except(['_token', '_method']);
        Categoria::where('id', '=', $id)->update($informacion);
        return redirect('categoria')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
