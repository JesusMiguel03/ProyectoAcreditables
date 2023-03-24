<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\Trayecto;
use App\Http\Controllers\Controller;
use App\Models\Informacion\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrayectoController extends Controller
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
        permiso('academico');

        // Lista todos los trayectos
        $trayectos = Trayecto::all();

        return view('academico.trayecto.index', compact('trayectos'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('academico');

        $trayectoBorrado = Trayecto::withTrashed()->find($request['num_trayecto']) ?? null;

        if ($trayectoBorrado) {
            return redirect()->back()->with('elementoBorrado', 'El trayecto que intenta registrar se encuentra como elemento borrado, si lo requiere proceda a recuperarlo');
        }

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'num_trayecto' => ['required', 'min:1', 'max:10', 'integer', 'unique:trayectos,num_trayecto,' . $request['num_trayecto']],
        ], [
            'num_trayecto.required' => 'El número es necesario.',
            'num_trayecto.unique' => 'El trayecto (' . $request['num_trayecto'] . ') ya ha sido registrado.',
            'num_trayecto.integer' => 'El número debe ser un número.',
            'num_trayecto.min' => 'El número debe ser mayor a 1.',
            'num_trayecto.max' => 'El número debe ser menor a 10.',
        ]);
        validacion($validador, 'error', 'Trayecto');

        // Guarda el trayecto
        Trayecto::create(['num_trayecto' => $request['num_trayecto']]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró el trayecto ({$request['num_trayecto']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('trayectos')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Trae el trayecto correspondiente
        $trayecto = Trayecto::find($id);

        // Valida que existe
        existe($trayecto);

        return view('academico.trayecto.edit', compact('trayecto'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'num_trayecto' => ['required','min:1', 'max:10', 'integer', 'unique:trayectos,num_trayecto,' . $id],
        ], [
            'num_trayecto.required' => 'El número es necesario.',
            'num_trayecto.unique' => 'El trayecto (' . $request['num_trayecto'] . ') ya ha sido registrado.',
            'num_trayecto.integer' => 'El número debe ser un número.',
            'num_trayecto.min' => 'El número debe ser mayor a 1.',
            'num_trayecto.max' => 'El número debe ser menor a 10.',
        ]);
        validacion($validador, 'error', 'Trayecto');

        Trayecto::find($id)->update(['num_trayecto' => $request['num_trayecto']]);

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Actualizó el trayecto ({$request['num_trayecto']}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect('trayectos')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        $trayecto = Trayecto::find($id);
        $trayecto->delete();

        $usuario = auth()->user();

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Borró el trayecto ({$trayecto->num_trayecto}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);
        
        return redirect()->back()->with('borrado', 'borrado');
    }
}
