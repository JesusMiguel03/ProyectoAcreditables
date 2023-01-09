<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Horario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HorarioController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $horarios = Horario::all();
        return view('academico.horarios.index', compact('horarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'espacio' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio')],
            'edificio_numero' => ['nullable', 'numeric', 'max:' . config('variables.horarios.edificio_numero')],
            'dia' => ['required', 'numeric', 'digits_between:1,5'],
            'hora' => ['required', 'date_format:g:i a'],
        ], [
            'hora.date_format' => 'El campo hora no coincide con el formato 00:00 AM',
            'desc_conocimiento.required' => 'El campo descripción es necesario.',
            'nom_conocimiento.required' => 'El campo nombre es necesario.',
            'desc_conocimiento.string' => 'El campo descripción debe ser una oración.',
            'nom_conocimiento.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nom_conocimiento.string' => 'El campo nombre debe ser una oración.',
            'desc_conocimiento.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nom_conocimiento.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_conocimiento.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);
        validacion($validador);

        Horario::create([
            'espacio' => $request->get('espacio'),
            'edificio_numero' => $request->get('edificio_numero'),
            'dia' => $request->get('dia'),
            'hora' => Carbon::parse($request->get('hora'))->format('Y-m-d H:i:s'),
        ]);
        return redirect()->back()->with('creado', 'creado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Academico\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        $horario = Horario::find($id);

        // Valida que exista
        existe($horario);
        return view('academico.horarios.edit', compact('horario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Academico\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'espacio' => ['required', 'string', 'regex: /[a-zA-Z\s]+/', 'max:' . config('variables.horarios.espacio')],
            'edificio_numero' => ['numeric', 'max:' . config('variables.horarios.edificio_numero')],
            'dia' => ['required', 'numeric', 'digits_between:1,5'],
            'hora' => ['required', 'date_format:h:i a'],
        ], [
            'hora.date_format' => 'El campo hora no coincide con el formato 00:00 AM',
            'desc_conocimiento.required' => 'El campo descripción es necesario.',
            'nom_conocimiento.required' => 'El campo nombre es necesario.',
            'desc_conocimiento.string' => 'El campo descripción debe ser una oración.',
            'nom_conocimiento.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nom_conocimiento.string' => 'El campo nombre debe ser una oración.',
            'desc_conocimiento.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nom_conocimiento.max' => 'El campo nombre no debe tener más de :max carácteres.',
            'desc_conocimiento.max' => 'El campo descripción no debe tener más de :max carácteres.',
        ]);
        validacion($validador);

        Horario::updateOrCreate(
            ['id' => $id],
            [
                'espacio' => $request->get('espacio'),
                'edificio_numero' => $request->get('edificio_numero'),
                'dia' => $request->get('dia'),
                'hora' => Carbon::parse($request->get('hora'))->format('Y-m-d H:i:s'),
            ]
        );
        return redirect('horarios')->with('actualizado', 'actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Academico\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Valida si tiene el permiso
        permiso('horarios');

        Horario::find($id)->delete();
        return redirect()->back()->with('borrado', 'borrado');
    }
}
