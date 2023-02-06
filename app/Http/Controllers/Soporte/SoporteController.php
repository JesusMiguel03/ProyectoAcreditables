<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Controllers\Controller;
use App\Models\Academico\AreaConocimiento;
use App\Models\Academico\Horario;
use App\Models\Academico\PNF;
use App\Models\Academico\Trayecto;
use App\Models\Informacion\Noticia;
use App\Models\Informacion\Pregunta_frecuente;
use App\Models\Materia\Categoria;
use App\Models\Materia\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        // Filtra el modelo y recupera el elemento por su id.
        if ($modelo === 'AreaConocimiento') {
            AreaConocimiento::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'PNF') {
            PNF::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'Trayecto') {
            Trayecto::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'Noticia') {
            Noticia::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'Pregunta') {
            Pregunta_frecuente::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'Categoria') {
            Categoria::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'Materia') {
            Materia::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }

        if ($modelo === 'Horario') {
            Horario::withTrashed()->find($id)->restore();
            return redirect()->back()->with('recuperado', 'recuperado');
        }
    }   

    public function recuperarContrasena(Request $request)
    {
        permiso('soporte');

        // Recupera al usuario que coincida con el correo
        $usuario = User::where('email', '=', $request['usuario'])->first();

        // Si no se encuentra.
        if (empty($usuario)) {
            return redirect()->back()->with('error', 'error');
        }

        // Genera una contraseña aleatoria de 10 caracteres y la asigna al usuario.
        $contrasena = Str::random(10);
        $usuario->forceFill([
            'password' => Hash::make($contrasena),
        ])->save();

        return redirect()->back()->with('contrasena', $contrasena)->with('usuario', "$usuario->nombre $usuario->apellido");
    }

    public function cambiarCedula(Request $request)
    {
        permiso('soporte');

        $usuario = User::where('email', '=', $request['usuario'])->first();

        // Si no se encuentra.
        if (empty($usuario)) {
            return redirect()->back()->with('error', 'error');
        }
        
        $usuario->update([
            'cedula' => $request['cedula']
        ]);

        $cedula = $usuario->nacionalidad . '-' . number_format($request['cedula'], 0, ',', '.');

        return redirect()->back()->with('cedula', $cedula)->with('usuario', "$usuario->nombre $usuario->apellido");
    }
}
