<?php

namespace App\Http\Controllers\Informacion;

use App\Models\Informacion\Noticia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Lista todas las noticias
        $noticias = Noticia::where('mostrar', '=', 1)->get();
        $periodo = periodoActual();

        return view('informacion.noticias.index', compact('noticias', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'encabezado' => ['required', 'string', 'max:' . config('variables.noticias.encabezado')],
            'desc_noticia' => ['required', 'string', 'max:' . config('variables.noticias.descripcion')],
            'mostrar' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'mostrar.not_in' => 'El campo mostrar noticia es inválido.',
            'mostrar.required' => 'El campo mostrar noticia es necesiario.',
            'mostrar.max' => 'El campo mostrar noticia solo puede ser si o no.',
            'desc_noticia.max' => 'La descripcion no debe ser mayor a :max carácteres.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            Noticia::where([['encabezado', '=', $request->get('encabezado')], ['desc_noticia', '=', $request->get('desc_noticia')]])
        );

        $imagen = '';

        $request->hasFile('imagen_noticia') ?
            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp . '-noticia.jpg', 'public') :
            $imagen = null;

        Noticia::create([
            'encabezado' => $request->get('encabezado'),
            'desc_noticia' => $request->get('desc_noticia'),
            'imagen_noticia' => $imagen,
            'mostrar' => $request->get('mostrar'),
        ]);

        return redirect('noticias')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Trae la noticia correspondiente
        $noticia = Noticia::find($id);
        $periodo = periodoActual();

        // Valida que exista
        existe($noticia);

        return view('informacion.noticias.edit', compact('noticia', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'encabezado' => ['required', 'string', 'max:' . config('variables.noticias.encabezado')],
            'desc_noticia' => ['required', 'string', 'max:' . config('variables.noticias.descripcion')],
            'mostrar' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'desc_noticia.max' => 'La descripcion no debe ser mayor a :max carácteres.',
            'mostrar.not_in' => 'El campo mostrar noticia es inválido.',
            'mostrar.required' => 'El campo mostrar noticia es necesiario.',
            'mostrar.max' => 'El campo mostrar noticia solo puede ser si o no.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            Noticia::where([['encabezado', '=', $request->get('encabezado')], ['desc_noticia', '=', $request->get('desc_noticia')]])
        );

        $noticia = Noticia::find($id);
        $imagen = null;

        if ($request->hasFile('imagen_noticia')) {
            Storage::delete('public/' . $noticia->imagen_noticia);

            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp . '-noticia.jpg', 'public');
        }

        // Actualiza la noticia
        $noticia->encabezado = $request->get('encabezado');
        $noticia->desc_noticia = $request->get('desc_noticia');
        $noticia->mostrar = $request->get('mostrar');
        $noticia->imagen_noticia = $imagen ? $imagen : $noticia->imagen_noticia;
        $noticia->save();

        return redirect('noticias')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        Noticia::find($id)->delete();
        return redirect()->back()->with('borrado', 'borrado');
    }
}
