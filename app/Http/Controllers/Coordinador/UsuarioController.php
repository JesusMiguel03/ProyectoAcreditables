<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\DatosAcademicos\Pnf;
use App\Models\DatosAcademicos\Trayecto;
use App\Models\Estudiante;
use App\Models\Profesor\Especialidad;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function __construct()
    {
        /**
         * Medidas de seguridad.
         *
         * @param auth // Debe estar autenticado / logueado
         * @param can // Debe posee el permiso de interactuar en la carpeta 'perfiles'
         */
        $this->middleware('auth');
        $this->middleware('can:perfiles');
    }

    public function index()
    {
        // Busca a todos los usuarios
        $usuarios = User::all();
        return view('aside.principal.usuarios.index', compact('usuarios'));
    }

    public function edit($id)
    {
        // Busca al usuario y demás modelos (roles - Spatie, especialidades)
        $usuario = User::find($id);
        $roles = Role::all();
        $especialidades = Especialidad::all();
        $relacion = [];
        $pnfs = Pnf::all();
        $trayectos = Trayecto::all();

        // Si tiene especialidades las retorna en el arreglo $relacion
        if (!empty($usuario->profesor->especialidades)) {
            foreach ($usuario->profesor->especialidades as $prof) {
                array_push($relacion, $prof->pivot->especialidad_id);
            }
        }

        return view('aside.principal.usuarios.edit', compact('usuario', 'roles', 'especialidades', 'relacion', 'pnfs', 'trayectos'));
    }

    public function update(Request $request, $id)
    {
        $validador = Validator::make($request->all(), [
            'roles[]' => ['required', 'not_in:0'],
        ], [
            'roles[].required' => 'El campo rol es necesario.',
            'roles[].not_in' => 'El rol seleccionado es inválido.'
        ]);

        if ($validador->fails())
        {
            return redirect()->back()->withErrors($validador)->withInput()->with('error', 'error');
        }

        // Actualizar rol
        $usuario = User::find($id);
        $rol = $usuario->getRoleNames()[0];
        $usuario->roles()->sync($request->roles);

        // Array con las especialidades
        $especialidades = request('especialidades');

        // Actualiza solo si es profesor
        if ($rol === 'Profesor') {
            if (empty($usuario->profesor->especialidades)) {
                return redirect('usuarios')->with('incorrecto', 'categoria existente');
            }
            $usuario->profesor->especialidades()->sync($especialidades);
        } else if ($rol === 'Estudiante') {
            // dd($usuario->estudiante);
            $estudiante = Estudiante::updateOrCreate(
                ['usuario_id' => $usuario->id],
                [
                    'trayecto_id' => $request->get('trayecto'),
                    'pnf_id' => $request->get('pnf')
                ]
            );
        }

        return redirect('usuarios')->with('creado', 'Roles añadidos exitosamente');
    }
}
