<?php

namespace App\Http\Controllers;

use App\Models\DatosAcademicos\Pnf;
use App\Models\DatosAcademicos\Trayecto;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('profile.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trayectos = Trayecto::all();
        $pnfs = Pnf::all();

        $estudiante = Estudiante::find($id);

        return view('profile.edit', compact('trayectos', 'pnfs', 'estudiante'));
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
        $user = Estudiante::find($id);
        
        if (!Estudiante::find($id)) {
            $user = new Estudiante();
        }
        
        $user->pnf_id = Pnf::find(request('pnf'))->id;
        $user->trayecto_id = Trayecto::find(request('trayecto'))->id;
        $user->usuario_id = $id;
        $user->save();

        return redirect('perfil')->with('actualizado', 'Curso actualizado exitosamente');
    }
}
