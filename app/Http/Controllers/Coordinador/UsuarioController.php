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
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:perfiles');
    }

    public function index()
    {
        $usuarios = User::all();
        return view('aside.principal.usuarios.index', compact('usuarios'));
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
        
        return view('aside.principal.usuarios.edit', compact('usuario', 'roles', 'especialidades', 'profesor', 'relacion'));
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

        return redirect('usuarios')->with('creado', 'Roles añadidos exitosamente');
    }
}
