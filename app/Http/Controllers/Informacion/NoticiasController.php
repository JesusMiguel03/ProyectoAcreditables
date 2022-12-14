<?php

namespace App\Http\Controllers\Informacion;

use App\Models\Informacion\Noticia;
use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $noticias = Noticia::all();
        return view('aside.informacion.noticias.index', compact('noticias', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'encabezado' => ['required', 'string', 'max:25'],
            'desc_noticia' => ['required', 'string', 'max:150'],
            'mostrar' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'desc_noticia.max' => 'La descripcion no debe ser mayor a 150 carácteres.',
            'mostrar.not_in' => 'El campo mostrar noticia es inválido.',
            'mostrar.required' => 'El campo mostrar noticia es necesiario.',
            'mostrar.max' => 'El campo mostrar noticia solo puede ser si o no.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Evita duplicidad
        // if (Noticia::where('desc_noticia', '=', $request->get('desc_noticia'))->first()) {
        //     return redirect('noticias')->with('registrado', 'registrado');
        // }

        $noticia = New Noticia();

        if ($request->hasFile('imagen_noticia')) {
            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp. '-noticia.jpg', 'public');
            $noticia->imagen_noticia = $imagen;
        } else {
            $noticia->imagen_noticia = null;
        }

        // Guarda la noticia
        $noticia->encabezado = $request->get('encabezado');
        $noticia->desc_noticia = $request->get('desc_noticia');
        $noticia->mostrar = $request->get('mostrar');
        $noticia->save();

        return redirect('noticias')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Trae la noticia correspondiente
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $noticia = Noticia::find($id);
        return view('aside.informacion.noticias.edit', compact('noticia', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'encabezado' => ['required', 'string', 'max:25'],
            'desc_noticia' => ['required', 'string', 'max:150'],
            'mostrar' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'desc_noticia.max' => 'La descripcion no debe ser mayor a 150 carácteres.',
            'mostrar.not_in' => 'El campo mostrar noticia es inválido.',
            'mostrar.required' => 'El campo mostrar noticia es necesiario.',
            'mostrar.max' => 'El campo mostrar noticia solo puede ser si o no.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        $noticia = Noticia::find($id);
        $imagen = null;

        if ($request->hasFile('imagen_noticia')) {
            Storage::delete('public/' . $noticia->imagen_noticia);

            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp. '-noticia.jpg', 'public');
        }

        // Actualiza la noticia
        $noticia->encabezado = $request->get('encabezado');
        $noticia->desc_noticia = $request->get('desc_noticia');
        $noticia->mostrar = $request->get('mostrar');
        $noticia->imagen_noticia = $imagen ? $imagen : $noticia->imagen_noticia;
        $noticia->save();

        return redirect('noticias')->with('actualizado', 'actualizado');
    }
}
