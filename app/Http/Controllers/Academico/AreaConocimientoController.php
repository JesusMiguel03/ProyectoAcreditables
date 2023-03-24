<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\AreaConocimiento;
use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
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
            'nom_conocimiento' => ['required', 'string', 'regex:' . config('variables.regex.alfanumespacio'), 'max:' . config('variables.conocimiento.nombre')],
            'desc_conocimiento' => ['required', 'string', 'max:' . config('variables.conocimiento.descripcion')]
        ], [
            'nom_conocimiento.required' => 'El nombre es necesario.',
            'nom_conocimiento.string' => 'El nombre debe ser una oración.',
            'nom_conocimiento.regex' => 'El nombre  solo puede contener caracteres alfanuméricos.',
            'nom_conocimiento.max' => 'El nombre no debe tener más de :max caracteres.',
            'desc_conocimiento.required' => 'La descripción es necesario.',
            'desc_conocimiento.string' => 'La descripción debe ser una oración.',
            'desc_conocimiento.max' => 'La descripción no debe tener más de :max caracteres.',
        ]);
        validacion($validador, 'error', 'Área de conocimiento');

        // Guarda el área de conocimiento
        AreaConocimiento::create([
            'nom_conocimiento' => $request['nom_conocimiento'],
            'desc_conocimiento' => $request['desc_conocimiento'],
        ]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró el área de conocimiento ({$request['nom_conocimiento']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
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

        return view('academico.conocimiento.edit', compact('conocimiento'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'nom_conocimiento' => ['required', 'string', 'regex:' . config('variables.regex.alfaespacio'), 'max:' . config('variables.conocimiento.nombre')],
            'desc_conocimiento' => ['required', 'string', 'max:' . config('variables.conocimiento.descripcion')]
        ], [
            'nom_conocimiento.required' => 'El nombre es necesario.',
            'nom_conocimiento.string' => 'El nombre debe ser una oración.',
            'nom_conocimiento.regex' => 'El nombre  solo puede contener caracteres alfanuméricos.',
            'nom_conocimiento.max' => 'El nombre no debe tener más de :max caracteres.',
            'desc_conocimiento.required' => 'La descripción es necesario.',
            'desc_conocimiento.string' => 'La descripción debe ser una oración.',
            'desc_conocimiento.max' => 'La descripción no debe tener más de :max caracteres.',
        ]);
        validacion($validador, 'error', 'Área de conocimiento');

        // Busca y actualiza
        AreaConocimiento::find($id)->update([
            'nom_conocimiento' => $request['nom_conocimiento'],
            'desc_conocimiento' => $request['desc_conocimiento']
        ]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó el área de conocimiento ({$request['nom_conocimiento']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('conocimientos')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('materias.modificar');

        $area = AreaConocimiento::find($id);
        $area->delete();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Borró el área de conocimiento ({$area->nom_conocimiento}) exitosamente",
            'estado' => 'warning',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('borrado', 'borrado');
    }
}
