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
        $periodo = periodoActual();

        return view('materias.categorias.index', compact('categorias', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('categorias');

        $validador = Validator::make($request->all(), [
            'nom_categoria' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.categorias.nombre'), 'unique:categorias']
        ], [
            'nom_categoria.required' => 'El campo categoría es necesario.',
            'nom_categoria.string' => 'El campo categoría debe ser una oración.',
            'nom_categoria.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'El campo categoría debe contener mas de :max carácteres.',
            'nom_categoria.unique' => 'La categoría debe ser única.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            Categoria::where('nom_categoria', '=', $request->get('nom_categoria'))
        );

        Categoria::create(['nom_categoria' => $request->get('nom_categoria')]);

        return redirect('categorias')->with('creado', 'La categoria fue creada exitosamente');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('categorias');

        $categoria = Categoria::find($id);
        $periodo = periodoActual();

        // Valida que exista
        existe($categoria);

        return view('materias.categorias.edit', compact('categoria', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('categorias');
        
        $validador = Validator::make($request->all(), [
            'nom_categoria' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.categorias.nombre')]
        ], [
            'nom_categoria.required' => 'El campo categoria es necesario.',
            'nom_categoria.string' => 'El campo categoria debe ser una oración.',
            'nom_categoria.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'El campo categoria debe contener mas de :max carácteres.',
        ]);
        validacion($validador);

        /**
         * Evita la duplicidad
         * 
         * ! Al guardar tira error de duplicado
         * 
         * duplicado(
         *   Categoria::where('nom_categoria', '=', $request->get('nom_categoria'))
         * );
         */

        Categoria::updateOrCreate(
            ['id' => $id],
            [
                'nom_categoria' => $request->get('nom_categoria'),
            ]
        );

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
