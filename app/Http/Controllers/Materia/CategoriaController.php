<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Materia\Categoria;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('categorias');

        $categorias = Categoria::all();

        return view('materias.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('categorias');

        $validador = Validator::make($request->all(), [
            'nom_categoria' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.categorias.nombre'), 'unique:categorias,nom_categoria,' . $request['nom_categoria']]
        ], [
            'nom_categoria.required' => 'La categoría es necesario.',
            'nom_categoria.string' => 'La categoría debe ser una oración.',
            'nom_categoria.regex' => 'El nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'La categoría debe contener mas de :max caracteres.',
            'nom_categoria.unique' => 'La categoría (' . $request['nom_categoria'] .  ') ya ha sido registrada.',
        ]);
        validacion($validador, 'error');

        Categoria::create(['nom_categoria' => $request->get('nom_categoria')]);

        return redirect('categorias')->with('creado', 'La categoria fue creada exitosamente');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('categorias');

        $categoria = Categoria::find($id);

        // Valida que exista
        existe($categoria);

        return view('materias.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('categorias');
        
        $validador = Validator::make($request->all(), [
            'nom_categoria' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.categorias.nombre'), 'unique:categorias,nom_categoria,' . $id]
        ], [
            'nom_categoria.required' => 'La categoría es necesario.',
            'nom_categoria.string' => 'La categoría debe ser una oración.',
            'nom_categoria.regex' => 'El nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'La categoría debe contener mas de :max caracteres.',
            'nom_categoria.unique' => 'La categoría (' . $request['nom_categoria'] .  ') ya ha sido registrada.',
        ]);
        validacion($validador, 'error');

        Categoria::find($id)->update(['nom_categoria' => $request->get('nom_categoria')]);

        return redirect('categorias')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('categorias');

        Categoria::find($id)->delete();
        return redirect()->back()->with('borrado', 'borrado');
    }
}
