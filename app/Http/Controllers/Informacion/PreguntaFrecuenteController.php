<?php

namespace App\Http\Controllers\Informacion;

use App\Http\Controllers\Controller;
use App\Models\Informacion\Pregunta_frecuente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $periodo = periodoActual();

        return view('informacion.preguntas.index', compact('preguntas', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.preguntas.titulo')],
            'explicacion' => ['required', 'string', 'max:' . config('variables.preguntas.explicacion')],
        ], [
            'titulo.required' => 'El campo pregunta es necesario.',
            'explicacion.required' => 'El campo respuesta es necesario.',
            'titulo.string' => 'El campo pregunta debe ser una oración.',
            'explicacion.string' => 'El campo respuesta debe ser una oración.',
            'titulo.max' => 'El campo pregunta no debe ser mayor a :max carácteres.',
            'explicacion.max' => 'El campo respuesta no debe ser mayor a :max carácteres.',
        ]);
        validacion($validador);
        
        // Evita duplicidad
        duplicado(
            Pregunta_frecuente::where([['titulo', '=', $request->get('titulo')], ['explicacion', '=', $request->get('explicacion')]])
        );
        
        // Guarda la pregunta
        Pregunta_frecuente::create([
            'titulo' => $request->get('titulo'),
            'explicacion' => $request->get('explicacion')
        ]);
        
        return redirect('preguntas-frecuentes')->with('creado', 'creado');
    }
    
    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');
        
        // Trae la pregunta correspondiente
        $pregunta = Pregunta_frecuente::find($id);
        $periodo = periodoActual();

        existe($pregunta);
        
        return view('informacion.preguntas.edit', compact('pregunta', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');
        
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:' . config('variables.preguntas.titulo')],
            'explicacion' => ['required', 'string', 'max:' . config('variables.preguntas.explicacion')],
        ], [
            'titulo.required' => 'El campo pregunta es necesario.',
            'explicacion.required' => 'El campo respuesta es necesario.',
            'titulo.string' => 'El campo pregunta debe ser una oración.',
            'explicacion.string' => 'El campo respuesta debe ser una oración.',
            'titulo.max' => 'El campo pregunta no debe ser mayor a :max carácteres.',
            'explicacion.max' => 'El campo respuesta no debe ser mayor a :max carácteres.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            Pregunta_frecuente::where([['titulo', '=', $request->get('titulo')], ['explicacion', '=', $request->get('explicacion')]])
        );

        // Busca y actualiza
        Pregunta_frecuente::updateOrCreate(
            ['id' => $id],
            [
                'titulo' => $request->get('titulo'),
                'explicacion' => $request->get('explicacion')
            ]
        );

        return redirect('preguntas-frecuentes')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('preguntas.modificar');

        Pregunta_frecuente::find($id)->delete();
        return redirect()->back()->with('borrado', 'borrado');
    }
}
