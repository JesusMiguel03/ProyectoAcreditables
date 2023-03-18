<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Informacion\Bitacora;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PeriodoController extends Controller
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
        permiso('periodo');

        $periodos = Periodo::all();
        return view('academico.periodo.index', compact('periodos'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('periodo');

        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
        $periodo = $conversor[$request['fase']] . '-' . Carbon::parse($request['inicio'])->format('Y');

        $fechaInicio = Carbon::parse($request['inicio']);
        $fechaFinMin = $fechaInicio->addDays(90)->format('Y-m-d');
        $fechaFinMax = $fechaInicio->addDays(16)->format('Y-m-d');

        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3',
                Rule::unique('periodos')->where(function ($query) use ($request) {
                    return $query->where('fase', $request['fase'])->where('inicio', $request['inicio'])->where('fin', $request['fin']);
                })],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date', 'after_or_equal:' . $fechaFinMin, 'before_or_equal:' . $fechaFinMax],
        ], [
            'fase.required' => 'La fase es necesaria.',
            'fase.max' => 'El número debe estar entre 1 y 3.',
            'fase.unique' => "El periodo ($periodo) ya ha sido registrado.",
            'inicio.required' => 'La fecha de inicio es necesaria.',
            'inicio.date' => 'El campo fecha inicio debe ser una fecha.',
            'fin.required' => 'La fecha de inicio es necesaria.',
            'fin.date' => 'El campo fecha fin debe ser una fecha.',
            'fin.after_or_equal' => "La fecha de fin debe ser mayor o igual a 90 días. Ej: {$fechaFinMin}",
            'fin.before_or_equal' => "La fecha de fin debe ser menor o igual a 106 días. Ej: {$fechaFinMax}",
        ]);
        validacion($validador, 'error', 'Periodo');

        $periodo = Periodo::create([
            'fase' => $request['fase'],
            'inicio' => $request['inicio'],
            'fin' => $request['fin'],
        ]);

        Bitacora::create([
            'usuario' => "Periodo - ({$periodo->formato()})",
            'accion' => 'Se ha registrado exitosamente',
            'estado' => 'success'
        ]);

        return redirect()->back()->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('periodo');

        $periodoEditar = Periodo::find($id);

        // Valida que exista
        existe($periodoEditar);

        return view('academico.periodo.edit', compact('periodoEditar'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('periodo');

        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
        $periodo = $conversor[$request['fase']] . '-' . Carbon::parse($request['inicio'])->format('Y');

        $fechaInicio = Carbon::parse($request['inicio']);
        $fechaFinMin = $fechaInicio->addDays(90)->format('Y-m-d');
        $fechaFinMax = $fechaInicio->addDays(16)->format('Y-m-d');

        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3',
                Rule::unique('periodos')->where(function ($query) use ($request) {
                    return $query->where('fase', $request['fase'])->where('inicio', $request['inicio'])->where('fin', $request['fin']);
                })->ignore($id)
            ],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date', 'after_or_equal:' . $fechaFinMin, 'before_or_equal:' . $fechaFinMax],
        ], [
            'fase.required' => 'La fase es necesaria.',
            'fase.max' => 'El número debe estar entre 1 y 3.',
            'fase.unique' => "El periodo ($periodo) ya ha sido registrado.",
            'inicio.required' => 'La fecha de inicio es necesaria.',
            'inicio.date' => 'El campo fecha inicio debe ser una fecha.',
            'fin.required' => 'La fecha de inicio es necesaria.',
            'fin.date' => 'El campo fecha fin debe ser una fecha.',
            'fin.after_or_equal' => "La fecha de fin debe ser mayor o igual a 90 días. Ej: {$fechaFinMin}",
            'fin.before_or_equal' => "La fecha de fin debe ser menor o igual a 106 días. Ej: {$fechaFinMax}",
        ]);
        validacion($validador, 'error', 'Periodo');

        $periodo = Periodo::find($id);

        $periodo->update([
            'fase' => $request['fase'],
            'inicio' => $request['inicio'],
            'fin' => $request['fin'],
        ]);

        Bitacora::create([
            'usuario' => "Periodo - ({$periodo->formato()})",
            'accion' => 'Se ha actualizado exitosamente',
            'estado' => 'success'
        ]);

        return redirect('periodos')->with('actualizado', 'actualizado');
    }
}
