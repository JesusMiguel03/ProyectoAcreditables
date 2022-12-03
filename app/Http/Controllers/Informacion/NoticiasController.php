<?php

namespace App\Http\Controllers\Informacion;

use App\Models\Informacion\Noticia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticiasController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación y los permisos
        $this->middleware('auth');
        $this->middleware('can:noticias.create');
    }

    public function index()
    {
        // Lista todas las noticias
        $noticias = Noticia::all();
        return view('aside.informacion.noticias.index', compact('noticias'));
    }

    public function store(Request $request)
    {
        // Valida los campos
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

        // Evita duplicidad
        // if (Noticia::where('desc_noticia', '=', $request->get('desc_noticia'))->first()) {
        //     return redirect('noticias')->with('registrado', 'registrado');
        // }

        // Guarda el trayecto
        Noticia::create([
            'encabezado' => $request->get('encabezado'),
            'desc_noticia' => $request->get('desc_noticia'),
            'mostrar' => $request->get('mostrar'),
        ]);

        return redirect('noticias')->with('creado', 'El aula fue encontrada exitosamente');
    }

    public function edit($id)
    {
        // Trae la noticia correspondiente
        $noticia = Noticia::find($id);
        return view('aside.informacion.noticias.edit', compact('noticia'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
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

        // Busca y actualiza
        Noticia::find($id)->update([
            'encabezado' => $request->get('encabezado'),
            'desc_noticia' => $request->get('desc_noticia'),
            'mostrar' => $request->get('mostrar'),
        ]);

        return redirect('noticias')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
