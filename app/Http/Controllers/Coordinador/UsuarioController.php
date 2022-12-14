<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
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
        // Busca a todos los estudiantes
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $usuarios = User::all();
        $estudiantes = [];

        foreach ($usuarios as $usuario) {
            if ($usuario->getRoleNames()[0] === 'Estudiante') {
                array_push($estudiantes, $usuario);
            }
        }

        return view('aside.principal.usuarios.index', compact('estudiantes', 'periodo'));
    }

    public function edit($id)
    {
        // Busca al usurio, pnfs y trayectos
        $periodo = Periodo::orderBy('inicio', 'desc')->first();
        $usuario = User::find($id);
        $pnfs = Pnf::all();
        $trayectos = Trayecto::all();

        // PNF's no vistos en la institución
        $pnfsNoDisponibles = ['Administración', 'Agroalimentación', 'Contaduría Pública', 'Mecánica'];

        return view('aside.principal.usuarios.edit', compact('usuario', 'pnfs', 'trayectos', 'pnfsNoDisponibles', 'periodo'));
    }

    public function update(Request $request, $id)
    {
        // Actualizar rol
        $usuario = User::find($id);
        Estudiante::updateOrCreate(
            ['usuario_id' => $usuario->id],
            [
                'trayecto_id' => $request->get('trayecto'),
                'pnf_id' => $request->get('pnf')
            ]
        );

        return redirect('usuarios')->with('creado', 'Roles añadidos exitosamente');
    }
}
