<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
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

        $categoriaBorrada = Categoria::withTrashed()->where('nom_categoria', '=', $request['nom_categoria'])->where('deleted_at', '!=', null)->first() ?? null;

        if ($categoriaBorrada) {
            return redirect()->back()->with('elementoBorrado', 'El PNF que intenta registrar se encuentra como elemento borrado, si lo requiere proceda a recuperarlo');
        }

        $validador = Validator::make($request->all(), [
            'nom_categoria' => ['required', 'string', 'regex: /[A-zÀ-ÿ0-9\s]+/', 'max:' . config('variables.categorias.nombre'), 'unique:categorias,nom_categoria,' . $request['nom_categoria']]
        ], [
            'nom_categoria.required' => 'La categoría es necesario.',
            'nom_categoria.string' => 'La categoría debe ser una oración.',
            'nom_categoria.regex' => 'El nombre solo puedo contener letras y espacios.',
            'nom_categoria.max' => 'La categoría debe contener mas de :max caracteres.',
            'nom_categoria.unique' => 'La categoría (' . $request['nom_categoria'] .  ') ya ha sido registrada.',
        ]);
        validacion($validador, 'error', 'Categoría');

        Categoria::create(['nom_categoria' => $request->get('nom_categoria')]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró la categoría ({$request['nom_categoria']}) asistencia exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

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
        validacion($validador, 'error', 'Categoría');

        Categoria::find($id)->update(['nom_categoria' => $request->get('nom_categoria')]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó la categoría ({$request['nom_categoria']}) asistencia exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('categorias')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('categorias');

        $categoria = Categoria::find($id);
        $categoria->delete();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Borró la categoría ({$categoria->nom_categoria}) asistencia exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
