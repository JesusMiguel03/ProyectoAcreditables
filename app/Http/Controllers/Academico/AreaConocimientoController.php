<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\AreaConocimiento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaConocimientoController extends Controller
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
        permiso('materias.modificar');

        // Lista todas las áreas de conocimiento
        $conocimientos = AreaConocimiento::all();

        return view('academico.conocimiento.index', compact('conocimientos'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_conocimiento' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.conocimiento.nombre')],
            'desc_conocimiento' => ['required', 'string', 'max:' . config('variables.conocimiento.descripcion')]
        ], [
            'desc_conocimiento.required' => 'El campo descripción es necesario.',
            'nom_conocimiento.required' => 'El campo nombre es necesario.',
            'desc_conocimiento.string' => 'El campo descripción debe ser una oración.',
            'nom_conocimiento.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nom_conocimiento.string' => 'El campo nombre debe ser una oración.',
            'desc_conocimiento.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nom_conocimiento.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_conocimiento.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            AreaConocimiento::where('nom_conocimiento', '=', $request->get('nom_conocimiento'))
        );

        // Guarda el área de conocimiento
        AreaConocimiento::create([
            'nom_conocimiento' => $request->get('nom_conocimiento'),
            'desc_conocimiento' => $request->get('desc_conocimiento'),
        ]);

        return redirect('conocimientos')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        // Busca el área de conocimiento respectivamente
        $conocimiento = AreaConocimiento::find($id);

        // Valida que exista
        existe($conocimiento);
        $periodo = periodoActual();

        return view('academico.conocimiento.edit', compact('conocimiento', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_conocimiento' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.conocimiento.nombre')],
            'desc_conocimiento' => ['required', 'string', 'max:' . config('variables.conocimiento.descripcion')]
        ], [
            'desc_conocimiento.required' => 'El campo descripción es necesario.',
            'nom_conocimiento.required' => 'El campo nombre es necesario.',
            'desc_conocimiento.string' => 'El campo descripción debe ser una oración.',
            'nom_conocimiento.string' => 'El campo nombre debe ser una oración.',
            'desc_conocimiento.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_conocimiento.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_conocimiento.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            AreaConocimiento::where('nom_conocimiento', '=', $request->get('nom_conocimiento'))
        );

        // Busca y actualiza
        AreaConocimiento::updateOrCreate(
            ['id' => $id],
            [
                'nom_conocimiento' => $request->get('nom_conocimiento'),
                'desc_conocimiento' => $request->get('desc_conocimiento')
            ]
        );

        return redirect('conocimientos')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        AreaConocimiento::find($id)->delete();
        return redirect()->back()->with('borrado', 'borrado');
    }
}
