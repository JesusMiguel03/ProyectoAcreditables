<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\Periodo;
use App\Models\Academico\Pnf;
use App\Models\Academico\Trayecto;
use App\Models\Informacion\Bitacora;
use App\Models\Materia\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
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
        $usuariosRegistrados = User::all();
        $usuarios = [];

        // Lista solo a los estudiantes.
        foreach ($usuariosRegistrados as $usuario) {
            if (count($usuario->getRoleNames()) > 0 && $usuario->getRoleNames()[0] === 'Estudiante') {
                array_push($usuarios, $usuario);
            }
            // if ($usuario->getRoleNames()[0] === 'Estudiante') {
            //     array_push($usuarios, $usuario);
            // }
        }

        return view('academico.estudiantes.index', compact('usuarios'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso
        permiso('registrar.usuario');

        $pnf = Pnf::find($request['pnf']);

        $pnfTrayectos = $pnf->trayectos;
        $pnfNombre = $pnf->nom_pnf;

        if ($request['trayecto'] > Pnf::find($request['pnf'])->trayectos) {
            return redirect()->back()->with('pnfLimite', "El PNF {$pnfNombre} cursa hasta trayecto {$pnfTrayectos}");
        }

        $CImin = config('variables.usuarios.cedula')[0];
        $CImax = config('variables.usuarios.cedula')[1];

        // Valida los campos
        $validar = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.nombre')],
            'apellido' => ['required', 'string', 'regex: /[A-zÀ-ÿ]+/', 'max:' . config('variables.usuarios.apellido')],
            'nacionalidad' => ['required', 'not_in:0', 'string'],
            'cedula' => ['required', 'numeric', 'digits_between:' . $CImin . ',' . $CImax, 'unique:users,cedula,' . $id],
            'trayecto' => ['required', 'not_in:0', 'integer'],
            'pnf' => ['required', 'not_in:0', 'integer'],
        ], [
            'nombre.required' => 'El nombre es necesario.',
            'nombre.string' => 'El nombre debe ser una oración.',
            'nombre.regex' => 'El nombre solo puede contener letras.',
            'nombre.max' => 'El nombre no debe tener más de :max caracteres.',
            'apellido.required' => 'El apellido es necesario.',
            'apellido.string' => 'El apellido debe ser una oración.',
            'apellido.regex' => 'El apellido solo puede contener letras.',
            'apellido.max' => 'El apellido no debe tener más de :max caracteres.',
            'nacionalidad.required' => 'La nacionalidad es necesaria.',
            'nacionalidad.not_in' => 'La nacionalidad debe ser una de las opciones de la lista.',
            'nacionalidad.string' => 'La nacionalidad seleccionada es inválida.',
            'cedula.required' => 'La cédula es necesaria.',
            'cedula.numeric' => 'La cédula debe ser un número.',
            'cedula.unique' => 'La cédula debe ser única.',
            'cedula.digits_between' => 'La cedula debe estar entre los ' . $CImin . ' y ' . $CImax . ' dígitos.',
            'trayecto.required' => 'El trayecto es necesario.',
            'trayecto.not_in' => 'El trayecto debe ser una de las opciones de la lista.',
            'trayecto.integer' => 'El trayecto seleccionado es inválido.',
            'pnf.required' => 'El PNF es necesario.',
            'pnf.not_in' => 'El PNF debe ser una de las opciones de la lista.',
            'pnf.integer' => 'El PNF seleccionado es inválido.',
        ]);
        validacion($validar, 'error', 'Actualizar perfil académico');

        $usuario = auth()->user();

        $estudiante = Estudiante::updateOrCreate(
            ['usuario_id' => $id],
            [
                'trayecto_id' => $request['trayecto'],
                'pnf_id' => $request['pnf']
            ]
        );

        Bitacora::create([
            'usuario' => "{$usuario->nombre} {$usuario->apellido}",
            'accion' => "Registró el perfil académico de ({$estudiante->nombreEstudiante()}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        $usuarioEstudiante = User::find($estudiante->usuario_id);
        $actualizacionPerfil = false;

        $datosAnteriores = [
            'nombre' => $usuarioEstudiante->nombre,
            'apellido' => $usuarioEstudiante->apellido,
            'nacionalidad' => $usuarioEstudiante->nacionalidad,
            'cedula' => $usuarioEstudiante->cedula
        ];

        // Actualiza nombre, apellido, nacionalidad o cedula si es diferente al guardado
        if ($usuarioEstudiante->nombre !== $request['nombre']) {
            $usuarioEstudiante->update(['nombre' => $request['nombre']]);
            $actualizacionPerfil = true;
        }
        if ($usuarioEstudiante->apellido !== $request['apellido']) {
            $usuarioEstudiante->update(['apellido' => $request['apellido']]);
            $actualizacionPerfil = true;
        }
        if ($usuarioEstudiante->nacionalidad !== $request['nacionalidad']) {
            $usuarioEstudiante->update(['nacionalidad' => $request['nacionalidad']]);
            $actualizacionPerfil = true;
        }
        if ($usuarioEstudiante->cedula !== $request['cedula']) {
            $usuarioEstudiante->update(['cedula' => $request['cedula']]);
            $actualizacionPerfil = true;
        }

        $nombreAnterior = "{$datosAnteriores['nombre']} {$datosAnteriores['apellido']}";
        $nombreActual = "{$usuarioEstudiante['nombre']} {$usuarioEstudiante['apellido']}";

        if ($actualizacionPerfil) {
            // Si actualizó el nombre o apellido
            if ($datosAnteriores['nombre'] !== $request['nombre'] || $datosAnteriores['apellido'] !== $request['apellido']) {
                Bitacora::create([
                    'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                    'accion' => "Actualizó el perfil de ({$nombreAnterior}) a ({$nombreActual}) exitosamente",
                    'estado' => 'success',
                    'periodo_id' => periodo('modelo')->id ?? null
                ]);

                // Si actualizó la nacionalidad o cedula
            } else {
                Bitacora::create([
                    'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                    'accion' => "Actualizó el perfil de ({$usuarioEstudiante->nombre} {$usuarioEstudiante->apellido}) exitosamente",
                    'estado' => 'success',
                    'periodo_id' => periodo('modelo')->id ?? null
                ]);
            }
        }

        return redirect()->to(route('estudiantes.index'))->with('academico', 'academico');
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

    // public function update(Request $request, $id)
    // {
    //     // Valida si tiene el permiso.
    //     permiso('registrar.usuario');

    //     // Valida que se haya elegido un trayecto y pnf.
    //     $validador = Validator::make($request->all(), [
    //         'trayecto' => ['required', 'not_in:0', 'digits_between:1,' . Pnf::find($request['pnf'])->trayectos],
    //         'pnf' => ['required', 'not_in:0'],
    //     ], [
    //         'trayecto.not_in' => 'El trayecto seleccionado es inválido.',
    //         'pnf.not_in' => 'El PNF seleccionado es inválido.',
    //     ]);
    //     validacion($validador, 'error', 'Perfil académico');

    //     $usuario = auth()->user();
    //     $estudiante = User::find($id);

    //     $pnfTrayectos = Pnf::find($request['pnf'])->trayectos;
    //     $pnfNombre = Pnf::find($request['pnf'])->nom_pnf;

    //     if ($request['trayecto'] > Pnf::find($request['pnf'])->trayectos) {

    //         Bitacora::create([
    //             'usuario' => "{$usuario->nombre} {$usuario->apellido}",
    //             'accion' => "Intentó asignar un trayecto superior al registrado en el PNF ({$pnfNombre})",
    //             'estado' => 'danger',
    //             'periodo_id' => periodo('modelo')->id ?? null
    //         ]);

    //         return redirect()->back()->with('pnfLimite', "El PNF {$pnfNombre} cursa hasta trayecto {$pnfTrayectos}");
    //     }

    //     // Actualiza el perfil académico
    //     Bitacora::create([
    //         'usuario' => "{$usuario->nombre} {$usuario->apellido}",
    //         'accion' => "Actualizó el perfil académico de ({$estudiante->nombre} {$estudiante->apellido}) exitosamente",
    //         'estado' => 'success',
    //         'periodo_id' => periodo('modelo')->id ?? null
    //     ]);

    //     Estudiante::updateOrCreate(
    //         ['usuario_id' => $estudiante->id],
    //         [
    //             'trayecto_id' => $request['trayecto'],
    //             'pnf_id' => $request['pnf']
    //         ]
    //     );

    //     return redirect('estudiantes')->with('academico', 'academico');
    // }

    public function aprobar($id)
    {
        if (rol('Estudiante')) {
            return redirect()->back();
        }

        $usuario = auth()->user();
        $estudiante = Estudiante_materia::find($id);

        if ($estudiante->materia->estado_materia !== 'Finalizado') {
            return redirect()->back()->with('noFinalizado', "La aprobación del estudiante no puede ser realizada, en vista de que la acreditable aún no ha finalizado");
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

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Validó la aprobación del estudiante ({$estudiante->inscritoNombre()}) - (Aprobado) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);

            $alert['icono'] = 'success';
            $alert['titulo'] = 'Estudiante aprobado';
            $alert['html'] = 'El estudiante ha sido aprobado, podrá cursar su siguiente acreditable el siguiente año';
            $alert['color'] = 'success';

            return redirect()->back()->with('aprobar', $alert);
        } else {
            $estudiante->update(['aprobado' => 0]);

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Validó la aprobación del estudiante ({$estudiante->inscritoNombre()}) - (Reprobado) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);

            $alert['icono'] = 'error';
            $alert['titulo'] = 'Estudiante reprobado';
            $alert['html'] = 'El estudiante no ha sido aprobado, tendrá que cursar acreditable de nuevo el siguiente periodo';
            $alert['color'] = 'danger';

            return redirect()->back()->with('aprobar', $alert);
        }
    }

    public function comprobante($id, $nroComprobante = '')
    {
        // Si es profesor no puede ver el comprobante
        if (rol('Profesor')) return redirect()->back();

        // Busca al estudiante y carga sus datos
        $estudiante = Estudiante::find($id);

        // Si intenta buscar un comprobante inferior a 1 redirige con mensaje de error.
        if ($nroComprobante && $nroComprobante < 1) return redirect()->back()->with('comprobanteError', 'No existe el comprobante a buscar.');

        // Si se busca por un ID se muestra el comprobante, caso contrario muestra el último.
        !empty($nroComprobante)
            ? $estudiante = $estudiante->inscripcion($nroComprobante)
            : $estudiante = $estudiante->ultimaInscripcion;

        // Si el estudiante no tiene comprobante, redirecciona.
        if (empty($estudiante)) return redirect()->back();

        // Si el estudiante intenta acceder al comprobante de otro.
        if (rol('Estudiante') && auth()->user()->estudiante->id !== $estudiante->estudiante_id) return redirect()->back();

        $inicio = Carbon::parse($estudiante->created_at)->format('Y-m-d');

        // Busca el periodo que dentro de su rango (fecha inicio y fin) se encuentre la fecha de inscripcion del estudiante.
        $periodo = Periodo::whereRaw('? between inicio and fin', $inicio)->first();

        $materia = Materia::find($estudiante->materia_id);
        $pdf = FacadePdf::loadView('academico.pdf.comprobante', ['estudiante' => $estudiante, 'materia' => $materia, 'periodo' => $periodo]);

        // En caso de que el coordinador desee revisar el comprobante
        if (rol('Coordinador')) return $pdf->stream('Comprobante de inscripción.pdf');

        // Flujo normal, al estudiante se le descarga directamente el pdf
        return $pdf->download('Comprobante de inscripcion.pdf');
    }
}
