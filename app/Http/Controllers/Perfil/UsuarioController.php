<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
use App\Models\Academico\Pnf;
use App\Models\Academico\Trayecto;
use App\Models\Academico\Estudiante;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        // Busca a todos los estudiantes
        $usuarios = User::all();
        $estudiantes = [];

        // Guarda solo a los estudiantes
        foreach ($usuarios as $usuario) {
            if ($usuario->getRoleNames()[0] === 'Estudiante') {
                array_push($estudiantes, $usuario);
            }
        }

        return view('academico.estudiantes.index', compact('estudiantes', ['periodo' => periodoActual()]));
    }

    public function edit($id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');
        
        // Busca al usurio, pnfs y trayectos
        $usuario = User::find($id);
        $pnfs = Pnf::all();
        $trayectos = Trayecto::all();

        // PNF's no vistos en la institución
        $pnfsNoDisponibles = ['Administración', 'Agroalimentación', 'Contaduría Pública', 'Mecánica'];

        return view('academico.estudiantes.edit', compact('usuario', 'pnfs', 'trayectos', 'pnfsNoDisponibles', ['periodo' => periodoActual()]));
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

        return redirect('/estudiantes')->with('academico', 'academico');
    }
}
