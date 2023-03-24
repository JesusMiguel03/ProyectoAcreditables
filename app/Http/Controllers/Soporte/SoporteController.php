<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Controllers\Controller;
use App\Models\Academico\AreaConocimiento;
use App\Models\Academico\Horario;
use App\Models\Academico\PNF;
use App\Models\Academico\Trayecto;
use App\Models\Informacion\Bitacora;
use App\Models\Informacion\Noticia;
use App\Models\Informacion\Pregunta_frecuente;
use App\Models\Materia\Categoria;
use App\Models\Materia\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SoporteController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }
    public function index()
    {
        permiso('soporte');

        return view('soporte.index');
    }

    public function restaurarElementos()
    {
        permiso('soporte');

        // Busca todos los elementos y regresa su id y nombre/número.
        $conocimientos = AreaConocimiento::onlyTrashed()->pluck('id', 'nom_conocimiento');
        $pnfs = PNF::onlyTrashed()->pluck('id', 'nom_pnf');
        $trayectos = Trayecto::onlyTrashed()->pluck('id', 'num_trayecto');
        $noticias = Noticia::onlyTrashed()->pluck('id', 'titulo');
        $preguntas = Pregunta_frecuente::onlyTrashed()->pluck('id', 'titulo');
        $categorias = Categoria::onlyTrashed()->pluck('id', 'nom_categoria');
        $materias = Materia::onlyTrashed()->pluck('id', 'nom_materia');
        $horarios = Horario::onlyTrashed()->pluck('id', 'espacio');

        return view('soporte.elementos', compact('conocimientos', 'pnfs', 'trayectos', 'noticias', 'preguntas', 'categorias', 'materias', 'horarios'));
    }

    public function recuperar($id, $modelo)
    {
        permiso('soporte');

        $usuario = auth()->user();

        $modelos = ['AreaConocimiento', 'PNF', 'Trayecto', 'Noticia', 'Pregunta', 'Categoria', 'Materia', 'Horario'];

        if (in_array($modelo, $modelos)) {

            $nombre = '';

            // Filtra el modelo y recupera el elemento por su id.
            if ($modelo === 'AreaConocimiento') {
                $area = AreaConocimiento::withTrashed()->find($id);
                $nombre = $area->nom_conocimiento;
                $area->restore();
            }

            if ($modelo === 'PNF') {
                $pnf = PNF::withTrashed()->find($id);
                $nombre = $pnf->nom_pnf;
                $pnf->restore();
            }

            if ($modelo === 'Trayecto') {
                $trayecto = Trayecto::withTrashed()->find($id);
                $nombre = $trayecto->num_trayecto;
                $trayecto->restore();
            }

            if ($modelo === 'Noticia') {
                $noticia = Noticia::withTrashed()->find($id);
                $nombre = $noticia->titulo;
                $noticia->restore();
            }

            if ($modelo === 'Pregunta') {
                $pregunta = Pregunta_frecuente::withTrashed()->find($id);
                $nombre = $pregunta->titulo;
                $pregunta->restore();
            }

            if ($modelo === 'Categoria') {
                $categoria = Categoria::withTrashed()->find($id);
                $nombre = $categoria->nom_categoria;
                $categoria->restore();
            }

            if ($modelo === 'Materia') {
                $materia = Materia::withTrashed()->find($id);
                $nombre = $materia->nom_materia;
                $materia->restore();
            }

            if ($modelo === 'Horario') {
                $horario = Horario::withTrashed()->find($id);
                $nombre = $horario->materia->nom_materia;
                $horario->restore();
            }

            Bitacora::create([
                'usuario' => "{$usuario->nombre} {$usuario->apellido}",
                'accion' => "Recuperó el registro ({$modelo}) - ({$nombre}) exitosamente",
                'estado' => 'success',
                'periodo_id' => periodo('modelo')->id ?? null
            ]);

            return redirect()->back()->with('recuperado', 'recuperado');
        }

        return redirect()->back();
    }

    public function recuperarContrasena(Request $request)
    {
        permiso('soporte');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'correo1' => ['required', 'email', 'max:' . config('variables.usuarios.correo')],
        ], [
            'correo1.required' => 'El correo es necesario.',
            'correo1.email' => 'Debe ser un correo válido.',
            'correo1.max' => 'El correo no puede contener mas de :max caracteres.',
        ]);
        validacion($validador, 'error', 'Recuperar contraseña');

        // Recupera al usuario que coincida con el correo
        $usuario = User::where('email', '=', $request['usuario'])->first();
        $usuarioBitacora = auth()->user();

        // Si no se encuentra.
        if (empty($usuario)) {
            return redirect()->back()->with('error', 'error');
        }

        // Genera una contraseña aleatoria de 10 caracteres y la asigna al usuario.
        $contrasena = Str::random(10);
        $usuario->forceFill([
            'password' => Hash::make($contrasena),
        ])->save();

        Bitacora::create([
            'usuario' => "{$usuarioBitacora->nombre} {$usuarioBitacora->apellido}",
            'accion' => "Recuperó la contraseña de ({$usuario->nombre} {$usuario->apellido}) exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        return redirect()->back()->with('contrasena', $contrasena)->with('usuario', "$usuario->nombre $usuario->apellido");
    }

    public function cambiarCedula(Request $request)
    {
        permiso('soporte');

        // Valida los campos
        $validador = Validator::make($request->all(), [
            'correo' => ['required', 'email', 'max:' . config('variables.usuarios.correo')],
            'cedula' => ['required', 'numeric', 'digits_between:' . config('variables.usuarios.cedula')[0] . ',' . config('variables.usuarios.cedula')[1], 'unique:users'],
        ], [
            'correo.required' => 'El correo es necesario.',
            'correo.email' => 'Debe ser un correo válido.',
            'correo.max' => 'El correo no puede contener mas de :max caracteres.',
            'cedula.required' => 'La cédula es necesaria.',
            'cedula.numeric' => 'La cédula debe ser un número.',
            'cedula.unique' => 'La cédula debe ser única.',
            'cedula.digits_between' => 'La cedula debe estar entre los ' . config('variables.usuarios.cedula')[0] . ' y ' . config('variables.usuarios.cedula')[1] . ' dígitos.',
        ]);
        validacion($validador, 'error', 'Cambiar cédula');

        $usuario = User::where('email', '=', $request['usuario'])->first();
        $usuarioBitacora = auth()->user();

        // Si no se encuentra.
        if (empty($usuario)) {
            return redirect()->back()->with('error', 'error');
        }

        $cedulaAnterior = number_format($usuario->cedula, 0, ',', '.');
        $formatoCI = number_format($request['cedula'], 0, ',', '.');

        $usuario->update([
            'cedula' => $request['cedula']
        ]);

        Bitacora::create([
            'usuario' => "{$usuarioBitacora->nombre} {$usuarioBitacora->apellido}",
            'accion' => "Cambió la cédula ({$cedulaAnterior}) a ({$formatoCI}) de ({$usuario->nombre} {$usuario->apellido})  exitosamente",
            'estado' => 'success',
            'periodo_id' => periodo('modelo')->id ?? null
        ]);

        $cedula = $usuario->nacionalidad . '-' . $formatoCI;

        return redirect()->back()->with('cedula', $cedula)->with('usuario', "$usuario->nombre $usuario->apellido");
    }
}
