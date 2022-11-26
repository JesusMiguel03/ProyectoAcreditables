<?php

namespace App\Http\Controllers\DatosAcademicos;

use App\Models\DatosAcademicos\Pnf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PnfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:pnf');
    }

    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $pnfs = Pnf::all();
        return view('aside.academico.pnf.index', compact('pnfs'));
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
            'nom_pnf' => ['required', 'string', 'max:40'],
        ], [
            'nom_pnf.required' => 'El campo nombre del pnf es necesario.',
            'nom_pnf.string' => 'El campo nombre del pnf debe ser texto.',
            'nom_pnf.max' => 'El campo nombre del pnf no puede contener mas de :values carácteres.'
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        if (Pnf::where('nom_pnf', '=', $request->get('nom_pnf'))->first()) {
            return redirect('pnf')->with('registrada', 'Aula ocupada');
        }

        $pnf = new Pnf();
        $pnf->nom_pnf = request('nom_pnf');
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
        return view('aside.academico.pnf.edit', compact('pnf'));
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
            'nom_pnf' => ['required', 'string', 'max:40'],
        ], [
            'nom_pnf.required' => 'El campo nombre del pnf es necesario.',
            'nom_pnf.string' => 'El campo nombre del pnf debe ser texto.',
            'nom_pnf.max' => 'El campo nombre del pnf no puede contener mas de :values carácteres.'
        ]);

        if ($validador->fails()) {
            return redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput();
        }

        $informacion = request()->except(['_token', '_method']);
        Pnf::where('id', '=', $id)->update($informacion);
        return redirect('pnf')->with('actualizado', 'Aula actualizada exitosamente');
    }
}
