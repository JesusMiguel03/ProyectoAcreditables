<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Academico\Pnf;
use App\Models\Academico\Trayecto;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
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

    /**
     *  Muestra a todos los estudiantes
     */
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

    /**
     *  Crea perfil académico del estudiante.
     */
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
            'trayecto' => ['required', 'not_in:0', 'digits_between:1,' . Pnf::find($request['pnf'])->trayectos],
            'pnf' => ['required', 'not_in:0'],
        ], [
            'trayecto.not_in' => 'El trayecto seleccionado es inválido.',
            'pnf.not_in' => 'El PNF seleccionado es inválido.',
        ]);
        validacion($validador, 'error');

        $pnfTrayectos = Pnf::find($request['pnf'])->trayectos;
        $pnfNombre = Pnf::find($request['pnf'])->nom_pnf;

        if ($request['trayecto'] > Pnf::find($request['pnf'])->trayectos) {
            return redirect()->back()->with('pnfLimite', "El PNF {$pnfNombre} cursa hasta trayecto {$pnfTrayectos}");
        }

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

    public function aprobar($id)
    {
        if (rol('Estudiante')) return redirect()->back();

        $estudiante = Estudiante_materia::find($id);

        if ($estudiante->materia->estado_materia !== 'Finalizado') {
            return redirect()
                ->back()
                ->with('noFinalizado', "La aprobación del estudiante no puede ser realizada, en vista de que la acreditable aún no ha finalizado");
        }

        $aprobado = $estudiante->aprobado();

        $alert = [
            'icono' => null,
            'titulo' => null,
            'html' => null,
            'color' => null
        ];

        if ($aprobado) {
            $estudiante->update(['aprobado' => 1]);

            $alert['icono'] = 'success';
            $alert['titulo'] = 'Estudiante aprobado';
            $alert['html'] = 'El estudiante ha sido aprobado, podrá cursar su siguiente acreditable el siguiente año';
            $alert['color'] = 'success';

            return redirect()->back()->with('aprobar', $alert);

        } else {
            $estudiante->update(['aprobado' => 0]);

            $alert['icono'] = 'error';
            $alert['titulo'] = 'Estudiante reprobado';
            $alert['html'] = 'El estudiante no ha sido aprobado, tendrá que cursar acreditable de nuevo el siguiente periodo';
            $alert['color'] = 'danger';

            return redirect()->back()->with('aprobar', $alert);
        }
    }
}
