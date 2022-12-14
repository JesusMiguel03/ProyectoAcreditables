<?php

namespace App\Http\Controllers\Coordinador;

use App\Models\Profesor\Especialidad;
use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación y los permisos
        $this->middleware('auth');
        $this->middleware('can:perfiles');
    }

    public function index()
    {
        // Lista todas las áreas de conocimiento
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $especialidades = Especialidad::all();
        return view('aside.principal.conocimiento.index', compact('especialidades', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida los campos
        $validado = Validator::make($request->all(), [
            'nom_especialidad' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:50'],
            'desc_especialidad' => ['required', 'string', 'max:255']
        ], [
            'desc_especialidad.required' => 'El campo descripción es necesario.',
            'nom_especialidad.required' => 'El campo nombre es necesario.',
            'desc_especialidad.string' => 'El campo descripción debe ser una oración.',
            'nom_especialidad.string' => 'El campo nombre debe ser una oración.',
            'desc_especialidad.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_especialidad.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_especialidad.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado)->withInput()->with('error', 'error');
        }

        // Evita duplicidad
        if (Especialidad::where('nom_especialidad', '=', $request->get('nom_especialidad'))->first()) {
            return redirect('conocimiento')->with('error', 'error');
        }

        // Guarda el área de conocimiento
        Especialidad::create([
            'nom_especialidad' => $request->get('nom_especialidad'),
            'desc_especialidad' => $request->get('desc_especialidad'),
        ]);

        return redirect('conocimiento')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Busca el área de conocimiento respectivamente
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $especialidad = Especialidad::find($id);
        return view('aside.principal.conocimiento.edit', compact('especialidad', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
        $validado = Validator::make($request->all(), [
            'nom_especialidad' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:50'],
            'desc_especialidad' => ['required', 'string', 'max:255']
        ], [
            'desc_especialidad.required' => 'El campo descripción es necesario.',
            'nom_especialidad.required' => 'El campo nombre es necesario.',
            'desc_especialidad.string' => 'El campo descripción debe ser una oración.',
            'nom_especialidad.string' => 'El campo nombre debe ser una oración.',
            'desc_especialidad.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_especialidad.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_especialidad.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado)->withInput()->with('error', 'error');
        }

        // Busca y actualiza
        Especialidad::find($id)->update([
            'nom_especialidad' => $request->get('nom_especialidad'),
            'desc_especialidad' => $request->get('desc_especialidad'),
        ]);

        return redirect('conocimiento')->with('actualizado', 'actualizado');
    }
}
