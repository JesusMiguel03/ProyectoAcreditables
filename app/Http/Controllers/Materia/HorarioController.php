<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Materia\Horario;
use App\Models\Materia\Materia;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horarios = Horario::all();
        $materias = Materia::all();
        return view('materias.informacion.horario.index', compact('horarios', 'materias'));
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
            'descripcion' => ['required', 'string', 'max:255'],
            'start' => ['required'],
            'end' => ['required'],
            'aula' => ['numeric', 'max:12'],
            'espacio' => ['required', 'string', 'max:50'],
            'materia_id' => ['required'],
        ]);

        if ($validador->fails()) {
            dd($validador->errors()->getMessages());
            return redirect()->back()->withErrors($validador)->withInput();
        }

        $horario = new Horario();
        $horario->descripcion = $request->get('descripcion');
        $horario->start = $request->get('start');
        $horario->end = $request->get('end');
        $horario->aula = $request->get('aula');
        $horario->espacio = $request->get('espacio');
        $horario->materia_id = $request->get('materia_id');
        // dd($horario);
        $horario->save();

        // $tiempo = explode(' ', request('hora'));
        // $hora = $tiempo[0];
        // $dia_noche = $tiempo[1];

        // if ($validador->fails()) {
        //     return redirect('horario/create')->withErrors($validador)->withInput();
        // }

        // $horario = new Horario();
        // $horario->dia = request('dia');
        // $horario->hora = $hora;
        // $horario->dia_noche = $dia_noche;
        // $horario->save();

        return redirect('horario')->with('creado', 'El tipo fue creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $horario = Horario::all();
        return response()->json($horario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $horario = Horario::findOrFail($id);
        return view('materias.informacion.horario.edit', compact('horario'));
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
        $tiempo = explode(' ', request('hora'));
        $hora = $tiempo[0];
        $dia_noche = $tiempo[1];

        Horario::where('id', '=', $id)->update([
            'dia' => $request->get('dia'),
            'hora' => $hora,
            'dia_noche' => $dia_noche
        ]);
        return redirect('horario')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
