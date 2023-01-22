<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Academico\Pnf;
use App\Models\Academico\Trayecto;
use App\Models\Academico\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación.
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso.
        permiso('registrar.usuario');

        // Busca a todos los estudiantes.
        $usuarios = User::all();
        $estudiantes = [];

        // Guarda solo a los estudiantes.
        foreach ($usuarios as $usuario) {
            if ($usuario->getRoleNames()[0] === 'Estudiante') {
                array_push($estudiantes, $usuario);
            }
        }

        return view('academico.estudiantes.index', compact('estudiantes'));
    }

    public function edit($id)
    {
        // Valida si tiene el permiso.
        permiso('registrar.usuario');
        
        // Busca al usurio, pnfs y trayectos.
        $usuario = User::find($id);
        $pnfs = Pnf::all();
        $trayectos = Trayecto::all();

        // PNF's no que no ven acreditables.
        $pnfsNoDisponibles = ['Administración', 'Agroalimentación', 'Contaduría Pública', 'Mecánica'];

        return view('academico.estudiantes.edit', compact('usuario', 'pnfs', 'trayectos', 'pnfsNoDisponibles'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso.
        permiso('registrar.usuario');

        // Valida que se haya elegido un trayecto y pnf.
        $validador = Validator::make($request->all(), [
            'trayecto' => ['required', 'not_in:0'],
            'pnf' => ['required', 'not_in:0'],
        ], [
            'trayecto.not_in' => 'El trayecto seleccionado es inválido.',
            'pnf.not_in' => 'El PNF seleccionado es inválido.',
        ]);
        validacion($validador, 'error');

        // Actualiza el perfil académico
        $usuario = User::find($id);

        Estudiante::updateOrCreate(
            ['usuario_id' => $usuario->id],
            [
                'trayecto_id' => $request['trayecto'],
                'pnf_id' => $request['pnf']
            ]
        );

        return redirect('estudiantes')->with('academico', 'academico');
    }
}
