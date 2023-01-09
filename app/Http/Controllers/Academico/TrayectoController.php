<?php

namespace App\Http\Controllers\Academico;

use App\Models\Academico\Trayecto;
use App\Http\Controllers\Controller;
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
        $periodo = periodoActual();

        return view('academico.trayecto.index', compact('trayectos', 'periodo'));
    }

    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'num_trayecto' => ['required', 'integer', 'unique:trayectos'],
        ], [
            'num_trayecto.required' => 'El campo número es necesario.',
            'num_trayecto.unique' => 'El trayecto ' . $request->get('num_trayecto') . ' ya ha sido registrado.',
            'num_trayecto.integer' => 'El campo número debe ser un número.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            Trayecto::where('num_trayecto', '=', $request->get('num_trayecto'))
        );

        // Guarda el trayecto
        Trayecto::create(['num_trayecto' => $request->get('num_trayecto')]);

        return redirect('trayectos')->with('creado', 'creado');
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Trae el trayecto correspondiente
        $trayecto = Trayecto::find($id);
        $periodo = periodoActual();

        // Valida que existe
        existe($trayecto);

        return view('academico.trayecto.edit', compact('trayecto', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'num_trayecto' => ['required', 'integer', 'unique:trayectos'],
        ], [
            'num_trayecto.required' => 'El campo número es necesario.',
            'num_trayecto.unique' => 'El trayecto ' . $request->get('num_trayecto') . ' ya ha sido registrado.',
            'num_trayecto.integer' => 'El campo número debe ser un número.',
        ]);
        validacion($validador);

        // Evita duplicidad
        duplicado(
            Trayecto::where('num_trayecto', '=', $request->get('num_trayecto'))
        );

        // Busca y actualiza
        Trayecto::updateOrCreate(
            ['id' => $id],
            ['num_trayecto' => $request->get('num_trayecto')]
        );

        return redirect('trayectos')->with('actualizado', 'actualizado');
    }

    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('academico');

        Trayecto::find($id)->delete();
        
        return redirect()->back()->with('borrado', 'borrado');
    }
}
