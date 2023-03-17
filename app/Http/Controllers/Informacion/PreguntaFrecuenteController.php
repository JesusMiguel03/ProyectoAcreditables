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

        Bitacora::create([
            'usuario' => "Pregunta - ({$request['titulo']})",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
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

        Bitacora::create([
            'usuario' => "Pregunta - ({$request['titulo']})",
            'accion' => 'Se ha actualizado exitosamente',
            'estado' => 'success'
        ]);

        return redirect('preguntas-frecuentes')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        $pregunta = Pregunta_frecuente::find($id);
        $pregunta->delete();

        Bitacora::create([
            'usuario' => "Pregunta - ({$pregunta->titulo})",
            'accion' => 'Ha sido borrada',
            'estado' => 'warning'
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
