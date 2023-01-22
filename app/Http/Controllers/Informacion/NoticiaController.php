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
        $noticias = Noticia::where('activo', '=', 1)->get();

        return view('informacion.noticias.index', compact('noticias'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.noticias.titulo')],
            'desc_noticia' => ['required', 'string', 'max:' . config('variables.noticias.descripcion')],
            'activo' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'activo.not_in' => 'El campo activo noticia es inválido.',
            'activo.required' => 'El campo activo noticia es necesiario.',
            'activo.max' => 'El campo activo noticia debe ser si o no.',
            'desc_noticia.max' => 'La descripcion no debe ser mayor a :max caracteres.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador, 'error');

        $imagen = '';

        // Busca la imagen y la guarda
        $request->hasFile('imagen_noticia') ?
            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp . '-noticia.jpg', 'public') :
            $imagen = null;

        Noticia::create([
            'titulo' => $request['titulo'],
            'desc_noticia' => $request['desc_noticia'],
            'imagen_noticia' => $imagen,
            'activo' => $request['activo'],
        ]);

        return redirect('noticias')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Trae la noticia correspondiente
        $noticia = Noticia::find($id);

        // Valida que exista
        existe($noticia);

        return view('informacion.noticias.edit', compact('noticia'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.noticias.titulo')],
            'desc_noticia' => ['required', 'string', 'max:' . config('variables.noticias.descripcion')],
            'activo' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'desc_noticia.max' => 'La descripcion no debe ser mayor a :max caracteres.',
            'activo.not_in' => 'El campo activo noticia es inválido.',
            'activo.required' => 'El campo activo noticia es necesiario.',
            'activo.max' => 'El campo activo noticia debe ser si o no.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador, 'error');

        $noticia = Noticia::find($id);
        $imagen = null;

        // Busca la imagen, la borra y sube la nueva
        if ($request->hasFile('imagen_noticia')) {
            Storage::delete('public/' . $noticia->imagen_noticia);

            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp . '-noticia.jpg', 'public');
        }

        // Actualiza la noticia
        $noticia->update([
            'titulo' => $request['titulo'],
            'desc_noticia' => $request['desc_noticia'],
            'activo' => $request['activo'],
            'imagen_noticia' => $imagen ? $imagen : $noticia->imagen_noticia,
        ]);

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
