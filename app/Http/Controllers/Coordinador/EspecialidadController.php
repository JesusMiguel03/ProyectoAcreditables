<?php

namespace App\Http\Controllers\Coordinador;

use App\Models\Profesor\Especialidad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especialidades = Especialidad::all();
        return view('coordinador.especialidad.index', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:50']
        ]);

        if ($validador->fails())
        {
            return redirect('especialidad/create')->withErrors($validador)->withInput();
        }

        if (Especialidad::where('nombre', '=', $request->get('nombre'))->first())
        {
            return redirect('especialidad')->with('error', 'categoria existente');
        }


        $especialidad = new Especialidad();
        $especialidad->nombre = request('nombre');
        $especialidad->save();

        return redirect('especialidad')->with('creado', 'La categoria fue creada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        return view('coordinador.especialidad.edit', compact('especialidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $informacion = request()->except(['_token', '_method']);
        Especialidad::where('id', '=', $id)->update($informacion);
        return redirect('especialidad')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
