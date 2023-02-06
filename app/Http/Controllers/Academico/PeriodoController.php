<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
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
        $periodo = $conversor[$request['fase']] . '-' . \Carbon\Carbon::parse($request['inicio'])->format('Y');

        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3',
                Rule::unique('periodos')->where(function ($query) use ($request) {
                    return $query->where('fase', $request['fase'])->where('inicio', $request['inicio'])->where('fin', $request['fin']);
                })],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date'],
        ], [
            'fase.max' => 'El número debe estar entre 1 y 3.',
            'fase.unique' => "El periodo ($periodo) ya ha sido registrado."
        ]);
        validacion($validador, 'error');

        Periodo::create([
            'fase' => $request['fase'],
            'inicio' => $request['inicio'],
            'fin' => $request['fin'],
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
        $periodo = $conversor[$request['fase']] . '-' . \Carbon\Carbon::parse($request['inicio'])->format('Y');

        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3',
                Rule::unique('periodos')->where(function ($query) use ($request) {
                    return $query->where('fase', $request['fase'])->where('inicio', $request['inicio'])->where('fin', $request['fin']);
                })->ignore($id)
            ],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date'],
        ], [
            'fase.max' => 'El número debe estar entre 1 y 3.',
            'fase.unique' => "El periodo ($periodo) ya ha sido registrado."
        ]);
        validacion($validador, 'error');

        Periodo::find($id)->update([
            'fase' => $request['fase'],
            'inicio' => $request['inicio'],
            'fin' => $request['fin'],
        ]);

        return redirect('periodos')->with('actualizado', 'actualizado');
    }
}
