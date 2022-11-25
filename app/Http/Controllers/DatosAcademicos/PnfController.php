<?php

namespace App\Http\Controllers\DatosAcademicos;

use App\Models\DatosAcademicos\Pnf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PnfController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $pnfs = Pnf::all();
        return view('academico.pnf.index', compact('pnfs'));
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
            'nombre' => ['required', 'string', 'max:40'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        if (Pnf::where('nombre', '=', $request->get('nombre'))->first()) {
            return redirect('pnf')->with('registrada', 'Aula ocupada');
        }

        $pnf = new Pnf();
        $pnf->nombre = request('nombre');
        $pnf->save();

        return redirect('pnf')->with('creado', 'El aula fue encontrada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pnf = Pnf::find($id);
        return view('academico.pnf.edit', compact('pnf'));
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
        $validador = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:40'],
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        if (Pnf::where('nombre', '=', $request->get('nombre'))->first()) {
            return redirect('pnf')->with('registrada', 'Aula ocupada');
        }

        $informacion = request()->except(['_token', '_method']);
        Pnf::where('id', '=', $id)->update($informacion);
        return redirect('pnf')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
