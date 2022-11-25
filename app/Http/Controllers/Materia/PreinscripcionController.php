<?php

namespace App\Http\Controllers\Materia;

use App\Http\Controllers\Controller;
use App\Models\Materia\Estudiante_curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PreinscripcionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validador = Validator::make($request->all(), [
        //     'user_id' => ['required', 'string', 'max:50']
        // ]);

        // if ($validador->fails()) {
        //     return redirect('tipo/create')->withErrors($validador)->withInput();
        // }

        // if (Estudiante_en_curso::where('id', '=', $request->get('nombre'))->first()) {
        //     return redirect('curso')->with('error', 'tipo existente');
        // }


        $estudiante = new Estudiante_curso();
        $estudiante->calificacion = 0;
        $estudiante->codigo = Str::random(20);;
        $estudiante->estudiante_id = request('usuario_id');
        $estudiante->curso_id = request('curso_id');
        $estudiante->save();

        return redirect('tipo')->with('creado', 'El tipo fue creada exitosamente');
    }
}
