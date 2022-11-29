<?php

namespace App\Http\Controllers\Coordinador;

use App\Models\Profesor\Especialidad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:perfiles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especialidades = Especialidad::all();
        return view('aside.principal.especialidad.index', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validado = Validator::make($request->all(), [
            'nom_especialidad' => ['required', 'string', 'alpha', 'between:10,50']
        ], [
            'nom_especialidad.required' => 'El campo nombre es necesario.',
            'nom_especialidad.string' => 'El campo nombre debe ser una oración.',
            'nom_especialidad.between' => 'El campo nombre debe estar entre :min y :max.',
            'nom_especialidad.between' => 'El campo nombre solo puede contener letras.'
        ]);

        if ($validado->fails())
        {
            return redirect()->back()->withErrors($validado)->withInput()->with('error', 'error');
        }

        if (Especialidad::where('nom_especialidad', '=', $request->get('nom_especialidad'))->first())
        {
            return redirect('especialidad')->with('error', 'categoria existente');
        }


        $especialidad = new Especialidad();
        $especialidad->nom_especialidad = request('nom_especialidad');
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
        return view('aside.principal.especialidad.edit', compact('especialidad'));
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
        $validado = Validator::make($request->all(), [
            'nom_especialidad' => ['required', 'string', 'alpha', 'between:10,50']
        ], [
            'nom_especialidad.required' => 'El campo nombre es necesario.',
            'nom_especialidad.string' => 'El campo nombre debe ser una oración.',
            'nom_especialidad.between' => 'El campo nombre debe estar entre :min y :max.',
            'nom_especialidad.between' => 'El campo nombre solo puede contener letras.'
        ]);

        if ($validado->fails())
        {
            return redirect()->back()->withErrors($validado)->withInput()->with('error', 'error');
        }

        $informacion = request()->except(['_token', '_method']);
        Especialidad::where('id', '=', $id)->update($informacion);
        return redirect('especialidad')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
