<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $periodo = periodoActual();
        return view('academico.periodo.index', compact('periodos', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('periodo');

        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3'],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date'],
        ], [
            'fase.max' => 'El número no debe ser mayor a :max.'
        ]);
        validacion($validador);

        /**
         * Evita la duplicidad
         * 
         * ! Revisar
         */
        // duplicado(
        //     Periodo::where(
        //         ['fase', '=', $request->get('fase')],
        //         ['inicio', '=', $request->get('inicio')],
        //         ['fin', '=', $request->get('fin')]
        //     )
        // );

        Periodo::create([
            'fase' => $request->get('fase'),
            'inicio' => $request->get('inicio'),
            'fin' => $request->get('fin'),
        ]);

        return redirect()->back()->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('periodo');

        $periodoEditar = Periodo::find($id);
        $periodo = periodoActual();
        
        existe($periodoEditar);

        return view('academico.periodo.edit', compact('periodoEditar', 'periodo'));
    }

    public function update(Request $request)
    {
        // Valida si tiene el permiso
        permiso('periodo');

        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3'],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date'],
        ], [
            'fase.max' => 'El número no debe ser mayor a :max.'
        ]);
        validacion($validador);

        /**
         * Evita la duplicidad
         * 
         * ! Revisar
         */
        // duplicado(
        //     Periodo::where(
        //         ['fase', '=', $request->get('fase')],
        //         ['inicio', '=', $request->get('inicio')],
        //         ['fin', '=', $request->get('fin')]
        //     )
        // );

        Periodo::updateOrCreate(
            ['id' => $request->get('id')],
            [
                'fase' => $request->get('fase'),
                'inicio' => $request->get('inicio'),
                'fin' => $request->get('fin'),
            ]
        );

        return redirect('periodos')->with('actualizado', 'actualizado');
    }

    // public function delete($id)
    // {
    //     permiso('periodo');

    //     Periodo::find($id)->delete();
    //     return redirect()->back()->with('borrado', 'borrado');
    // }
}
