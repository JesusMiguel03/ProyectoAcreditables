<?php

namespace App\Http\Controllers\Informacion;

use App\Models\Informacion\Noticia;
use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $noticias = Noticia::all();

        return view('informacion.noticias.index', compact('noticias'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        $noticia = 'Encabezado: ' . $request['titulo'] . ' | Descripción: ' . $request['desc_noticia'];

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => [
                'required', 'string', 'max:' . config('variables.noticias.titulo'),
                    Rule::unique('noticias')->where(function ($query) use ($request) {
                        return $query->where('titulo', $request['titulo'])->where('desc_noticia', $request['desc_noticia']);
                    })
                ],
            'desc_noticia' => ['required', 'string', 'max:' . config('variables.noticias.descripcion')],
            'activo' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'titulo.required' => "El título es necesario.",
            'titulo.string' => "El título debe ser una oración.",
            'titulo.max' => "El título no debe tener más de :max caracteres.",
            'titulo.unique' => "La noticia ($noticia) ya se ha registrado.",
            'activo.not_in' => 'El campo mostrar es inválido.',
            'activo.required' => 'El campo mostrar es necesiario.',
            'activo.max' => 'El campo mostrar debe ser si o no.',
            'desc_noticia.required' => 'La descripcion es necesaria.',
            'desc_noticia.string' => 'La descripcion debe ser una oración.',
            'desc_noticia.max' => 'La descripcion no debe ser mayor a :max caracteres.',
            'imagen_noticia.image' => 'La imagen debe ser una imagen.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador, 'error', 'Noticia');

        $imagen = '';

        $usuario = auth()->user();

        // Busca la imagen y la guarda
        if ($request->hasFile('imagen_noticia')) {
            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp . '-noticia.jpg', 'public');

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Subió una imagen de noticia ({$request['titulo']}) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);

        } else {
            $imagen = null;
        }

        Noticia::create([
            'titulo' => $request['titulo'],
            'desc_noticia' => $request['desc_noticia'],
            'imagen_noticia' => $imagen,
            'activo' => $request['activo'],
        ]);

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró la noticia ({$request['titulo']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
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

        $noticia = 'Encabezado: ' . $request['titulo'] . ' | Descripción: ' . $request['desc_noticia'];

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.noticias.titulo'),
                Rule::unique('noticias')->where(function ($query) use ($request) {
                    return $query->where('titulo', $request['titulo'])->where('desc_noticia', $request['desc_noticia']);
                })->ignore($id)
            ],
            'desc_noticia' => ['required', 'string', 'max:' . config('variables.noticias.descripcion')],
            'activo' => ['required', 'max:2', 'not_in:0'],
            'imagen_noticia' => ['image', 'mimes:jpg', 'max:1024'],
        ], [
            'titulo.required' => "El título es necesario.",
            'titulo.string' => "El título debe ser una oración.",
            'titulo.max' => "El título no debe tener más de :max caracteres.",
            'titulo.unique' => "La noticia ($noticia) ya se ha registrado.",
            'activo.not_in' => 'El campo mostrar es inválido.',
            'activo.required' => 'El campo mostrar es necesiario.',
            'activo.max' => 'El campo mostrar debe ser si o no.',
            'desc_noticia.required' => 'La descripcion es necesaria.',
            'desc_noticia.string' => 'La descripcion debe ser una oración.',
            'desc_noticia.max' => 'La descripcion no debe ser mayor a :max caracteres.',
            'imagen_noticia.image' => 'La imagen debe ser una imagen.',
            'imagen_noticia.max' => 'La imagen no debe pesar más de 1 MB.',
            'imagen_noticia.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);
        validacion($validador, 'error', 'Noticia');

        $noticia = Noticia::find($id);
        $imagen = null;

        $usuario = auth()->user();

        // Busca la imagen, la borra y sube la nueva
        if ($request->hasFile('imagen_noticia')) {
            Storage::delete('public/' . $noticia->imagen_noticia);

            $imagen = $request->file('imagen_noticia')->storeAs('uploads', \Carbon\Carbon::now()->timestamp . '-noticia.jpg', 'public');

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Actulizó la imagen de la noticia ({$request['titulo']}) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);
        }

        // Actualiza la noticia
        $noticia->update([
            'titulo' => $request['titulo'],
            'desc_noticia' => $request['desc_noticia'],
            'activo' => $request['activo'],
            'imagen_noticia' => $imagen ? $imagen : $noticia->imagen_noticia,
        ]);

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó la noticia ({$request['titulo']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('noticias')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('noticias');

        $noticia = Noticia::find($id);
        $noticia->delete();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Borró la noticia ({$noticia->titulo}) exitosamente",
            'estado' => 'warning',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
