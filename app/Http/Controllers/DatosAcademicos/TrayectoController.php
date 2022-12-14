<?php

namespace App\Http\Controllers\DatosAcademicos;

use App\Models\DatosAcademicos\Trayecto;
use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrayectoController extends Controller
{
    public function __construct()
    {
        // Validación de autenticación y permiso
        $this->middleware('auth');
        $this->middleware('can:trayecto');
    }

    public function index()
    {
        // Lista todos los trayectos
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $trayectos = Trayecto::all();
        return view('aside.academico.trayecto.index', compact('trayectos', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'num_trayecto' => ['required', 'integer'],
        ], [
            'num_trayecto.required' => 'El campo número es necesario.',
            'num_trayecto.number' => 'El campo número debe ser un número.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        if (Trayecto::where('num_trayecto', '=', $request->get('num_trayecto'))->first()) {
            return redirect('trayecto')->with('registrado', 'registrado');
        }

        // Guarda el trayecto
        Trayecto::create(['num_trayecto' => $request->get('num_trayecto')]);

        return redirect('trayecto')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Trae el trayecto correspondiente
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $trayecto = Trayecto::find($id);
        return view('aside.academico.trayecto.edit', compact('trayecto', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida los campos
        $validador = Validator::make($request->all(), [
            'num_trayecto' => ['required', 'integer'],
        ], [
            'num_trayecto.required' => 'El campo número es necesario.',
            'num_trayecto.integer' => 'El campo número debe ser un número.',
        ]);

        if ($validador->fails()) {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Busca y actualiza
        Trayecto::find($id)->update([
            'num_trayecto' => $request->get('num_trayecto')
        ]);

        return redirect('trayecto')->with('actualizado', 'actualizado');
    }
}
