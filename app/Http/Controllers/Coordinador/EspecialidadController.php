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
        return view('aside.principal.conocimiento.index', compact('especialidades'));
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
            'nom_especialidad' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:50'],
            'desc_especialidad' => ['required', 'string', 'max:255']
        ], [
            'desc_especialidad.required' => 'El campo descripción es necesario.',
            'nom_especialidad.required' => 'El campo nombre es necesario.',
            'desc_especialidad.string' => 'El campo descripción debe ser una oración.',
            'nom_especialidad.string' => 'El campo nombre debe ser una oración.',
            'desc_especialidad.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_especialidad.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_especialidad.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado)->withInput()->with('error', 'error');
        }

        if (Especialidad::where('nom_especialidad', '=', $request->get('nom_especialidad'))->first()) {
            return redirect('conocimiento')->with('error', 'categoria existente');
        }


        $especialidad = new Especialidad();
        $especialidad->nom_especialidad = request('nom_especialidad');
        $especialidad->desc_especialidad = request('desc_especialidad');
        $especialidad->save();

        return redirect('conocimiento')->with('creado', 'La categoria fue creada exitosamente');
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
        return view('aside.principal.conocimiento.edit', compact('especialidad'));
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
            'nom_especialidad' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:50'],
            'desc_especialidad' => ['required', 'string', 'max:255']
        ], [
            'desc_especialidad.required' => 'El campo descripción es necesario.',
            'nom_especialidad.required' => 'El campo nombre es necesario.',
            'desc_especialidad.string' => 'El campo descripción debe ser una oración.',
            'nom_especialidad.string' => 'El campo nombre debe ser una oración.',
            'desc_especialidad.regex' => 'El campo nombre solo puedo contener letras y espacios.',
            'nom_especialidad.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_especialidad.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);

        if ($validado->fails()) {
            return redirect()->back()->withErrors($validado)->withInput()->with('error', 'error');
        }

        $informacion = request()->except(['_token', '_method']);
        Especialidad::where('id', '=', $id)->update($informacion);
        return redirect('conocimiento')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
