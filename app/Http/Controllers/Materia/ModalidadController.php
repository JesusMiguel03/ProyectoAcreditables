<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Materia\Modalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modalidades = Modalidad::all();
        return view('cursos.informacion.modalidad.index', compact('modalidades'));
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
            'nombre' => ['required', 'string', 'max:20']
        ]);

        if ($validador->fails()) {
            return redirect('modalidad/create')->withErrors($validador)->withInput();
        }

        if (Modalidad::where('nombre', '=', $request->get('nombre'))->first()) {
            return redirect('modalidad')->with('error', 'modalidad existente');
        }

        $modalidad = new Modalidad();
        $modalidad->nombre = request('nombre');
        $modalidad->save();

        return redirect('modalidad')->with('creado', 'El modalidad fue creada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modalidad = Modalidad::findOrFail($id);
        return view('cursos.informacion.modalidad.edit', compact('modalidad'));
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
        Modalidad::where('id', '=', $id)->update($informacion);
        return redirect('modalidad')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
