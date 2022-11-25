<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Profesor\Especialidad;
use App\Models\Profesor\Profesor;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('coordinador.users', compact('usuarios'));
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        $roles = Role::all();
        $especialidades = Especialidad::all();
        $profesor = Profesor::find($id);
        $relacion = [];

        foreach ($profesor->especialidad as $prof) {
            array_push($relacion, $prof->pivot->especialidad_id);
        }
        
        return view('coordinador.edit', compact('usuario', 'roles', 'especialidades', 'profesor', 'relacion'));
    }

    public function update(Request $request, $id)
    {
        // Busca al prof a editar
        $profesor = Profesor::find($id);

        // Actualizar rol
        $usuario = User::find($id);
        $usuario->roles()->sync($request->roles);

        // Array con las especialidades
        $especialidades = request('especialidades');

        $profesor->especialidad()->sync($especialidades);

        // Modelo relacion
        // foreach ($especialidades as $especialidad) {
            
        // }
        // $relacion = new Profesor_especialidad();
        // $relacion->especialidad_id = $especialidades;
        // $relacion->usuario_id = $profesor->id;
        // dd($relacion);
        // $relacion->save();

        // $profesor->usuario_id = $id;

        // if (request('especialidad')) {
        //     $profesor->especialidad();
        //     dd($profesor);
        // }

        // $profesor->especialidad_id = request('especialidad')[count(request('especialidad')) - 1];
        // dd(count(request('especialidad')) > 1 ? count(request('especialidad')) - 1 : count(request('especialidad')));
        // dd($profesor->especialidad_id);
        // foreach (request('especialidad') as $especialidad) {
        //     $profesor_especialidad = new Profesor();
        //     $profesor_especialidad->usuario_id = $profesor;
        //     $profesor_especialidad->especialidad_id = $especialidad;
        //     $profesor_especialidad->save();
        // }
        // dd(json_encode(request('especialidad')));
        // dd(request('especialidad'));
        // dd(implode(',', request('especialidad')));
        // $profesor->especialidad_id = implode(',',request('especialidad')); // = request('especialidad');
        // $profesor->save();

        return redirect('usuarios')->with('creado', 'Roles añadidos exitosamente');
    }
}
