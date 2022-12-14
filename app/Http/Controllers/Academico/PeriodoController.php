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
        // Validación de autenticación y permiso
        $this->middleware('auth');
        $this->middleware('can:materias.gestion');
    }

    public function index()
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $periodos = Periodo::all();
        return view('aside.principal.periodo.index', compact('periodos', 'periodo'));
    }

    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'fase' => ['required', 'numeric', 'max:3'],
            'inicio' => ['required', 'date'],
            'fin' => ['required', 'date'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        Periodo::create([
            'fase' => $request->get('fase'),
            'inicio' => $request->get('inicio'),
            'fin' => $request->get('fin'),
        ]);

        return redirect()->back()->with('creado', 'creado');
    }

    public function edit($id)
    {
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $periodoEditar = Periodo::find($id);
        return view('aside.principal.periodo.edit', compact('periodoEditar', 'periodo'));
    }

    public function update(Request $request)
    {
        Periodo::updateOrCreate(
            ['id' => $request->get('id')],
            [
                'fase' => $request->get('fase'),
                'inicio' => $request->get('inicio'),
                'fin' => $request->get('fin'),
            ]
        );
        
        return redirect('periodo')->with('actualizado', 'actualizado');
    }
}
