<?php

namespace App\Http\Controllers\Informacion;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
use App\Models\Informacion\Pregunta_frecuente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Str;

class PreguntaFrecuenteController extends Controller
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
        permiso('preguntas.principal');

        // Lista todas las preguntas
        $preguntas = Pregunta_frecuente::all();

        return view('informacion.preguntas.index', compact('preguntas'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        $preguntaBorrada = Pregunta_frecuente::withTrashed()->where('titulo', '=', $request['titulo'])->where('deleted_at', '!=', null)->first() ?? null;

        if ($preguntaBorrada) {
            return redirect()->back()->with('elementoBorrado', 'La pregunta frecuente que intenta registrar se encuentra como elemento borrado, si lo requiere proceda a recuperarlo');
        }

        $descripcionCorta = Str::length($request['explicacion']) > 40
            ? Str::limit($request['explicacion'], 40)
            : $request['explicacion'];

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.preguntas.titulo'), 'unique:preguntas_frecuentes,titulo'],
            'explicacion' => ['required', 'string', 'max:' . config('variables.preguntas.explicacion'), 'unique:preguntas_frecuentes,explicacion'],
        ], [
            'titulo.required' => 'La pregunta es necesaria.',
            'titulo.string' => 'La pregunta debe ser una oración.',
            'titulo.max' => 'La pregunta no debe ser mayor a :max caracteres.',
            'titulo.unique' => "La pregunta ($request[titulo]) ya ha sido registrada.",
            'explicacion.required' => 'La respuesta es necesaria.',
            'explicacion.string' => 'La respuesta debe ser una oración.',
            'explicacion.max' => 'La respuesta no debe ser mayor a :max caracteres.',
            'explicacion.unique' => "La respuesta ($descripcionCorta) ya ha sido registrada.",
        ]);
        validacion($validador, 'error', 'Pregunta frecuente');

        // Guarda la pregunta
        Pregunta_frecuente::create([
            'titulo' => $request['titulo'],
            'explicacion' => $request['explicacion']
        ]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró la pregunta ({$request['titulo']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('preguntas-frecuentes')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        // Trae la pregunta correspondiente
        $pregunta = Pregunta_frecuente::find($id);

        // Valida que exista
        existe($pregunta);

        return view('informacion.preguntas.edit', compact('pregunta'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        $descripcionCorta = Str::length($request['explicacion']) > 40
            ? Str::limit($request['explicacion'], 40)
            : $request['explicacion'];

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.preguntas.titulo'), 'unique:preguntas_frecuentes,titulo,' . $id],
            'explicacion' => ['required', 'string', 'max:' . config('variables.preguntas.explicacion'), 'unique:preguntas_frecuentes,explicacion,' . $id],
        ], [
            'titulo.required' => 'La pregunta es necesaria.',
            'titulo.string' => 'La pregunta debe ser una oración.',
            'titulo.max' => 'La pregunta no debe ser mayor a :max caracteres.',
            'titulo.unique' => "La pregunta ($request[titulo]) ya ha sido registrada.",
            'explicacion.required' => 'La respuesta es necesaria.',
            'explicacion.string' => 'La respuesta debe ser una oración.',
            'explicacion.max' => 'La respuesta no debe ser mayor a :max caracteres.',
            'explicacion.unique' => "La respuesta ($descripcionCorta) ya ha sido registrada.",
        ]);
        validacion($validador, 'error', 'Pregunta frecuente');

        // Actualiza la pregunta
        Pregunta_frecuente::find($id)->update([
            'titulo' => $request['titulo'],
            'explicacion' => $request['explicacion']
        ]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó la pregunta ({$request['titulo']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('preguntas-frecuentes')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        $pregunta = Pregunta_frecuente::find($id);
        $pregunta->delete();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Borró la pregunta ({$pregunta->titulo}) exitosamente",
            'estado' => 'warning',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
