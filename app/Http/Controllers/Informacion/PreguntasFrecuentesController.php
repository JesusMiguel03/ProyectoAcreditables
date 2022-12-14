<?php

namespace App\Http\Controllers\Informacion;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Informacion\Preguntas_frecuentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreguntasFrecuentesController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación y los permisos
        $this->middleware('auth');
        $this->middleware('can:noticias.create')->except('index');
    }

    public function index()
    {
        // Lista todas las preguntas
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $preguntas = Preguntas_frecuentes::all();
        return view('aside.informacion.preguntas.index', compact('preguntas', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:30'],
            'explicacion' => ['required', 'string', 'max:255'],
        ], [
            'titulo.required' => 'El campo pregunta es necesario.',
            'explicacion.required' => 'El campo respuesta es necesario.',
            'titulo.string' => 'El campo pregunta debe ser una oración.',
            'explicacion.string' => 'El campo respuesta debe ser una oración.',
            'titulo.max' => 'El campo pregunta no debe ser mayor a :max carácteres.',
            'explicacion.max' => 'El campo respuesta no debe ser mayor a :max carácteres.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Evita duplicidad
        if (Preguntas_frecuentes::where('titulo', '=', $request->get('titulo'))->first()) {
            return redirect('preguntas-frecuentes')->with('registrado', 'registrado');
        }

        // Guarda la pregunta
        Preguntas_frecuentes::create([
            'titulo' => $request->get('titulo'),
            'explicacion' => $request->get('explicacion')
        ]);

        return redirect('preguntas-frecuentes')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Trae la pregunta correspondiente
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $pregunta = Preguntas_frecuentes::find($id);
        return view('aside.informacion.preguntas.edit', compact('pregunta', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'titulo' => ['required', 'string', 'max:30'],
            'explicacion' => ['required', 'string', 'max:255'],
        ], [
            'titulo.required' => 'El campo pregunta es necesario.',
            'explicacion.required' => 'El campo respuesta es necesario.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Busca y actualiza
        Preguntas_frecuentes::find($id)->update([
            'titulo' => $request->get('titulo'),
            'explicacion' => $request->get('explicacion')
        ]);

        return redirect('preguntas-frecuentes')->with('actualizado', 'actualizado');
    }
}
