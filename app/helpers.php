<?php

use App\Models\Academico\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 *  Valida si puede interactuar
 * 
 *  @param string $permiso
 *  @return bool|exception
 */

if (!function_exists('permiso')) {
    function permiso($permiso, $accion = '')
    {
        if (is_array($permiso)) {
            $contador = 0;

            foreach ($permiso as $perm) {
                Auth::user()->cannot($perm) ? $contador++ : '';
            }

            if ($contador === count($permiso) && empty($accion)) {
                return abort(redirect()->back());
            }
        } elseif (Auth::user()->cannot($permiso) && empty($accion)) {
            return abort(redirect()->back());
        } elseif (Auth::user()->cannot($permiso) && $accion === 'false') {
            return false;
        } else return false;
    }
}

/**
 *  Devuelve el rol del usuario actual
 * 
 *  @return string
 */
if (!function_exists('rolUsuarioConectado')) {
    function rolUsuarioConectado()
    {
        return Auth::user()->getRoleNames()[0];
    }
}

/**
 *  Valida los campos
 *
 *  @param array $validador
 *  @return exception
 */

if (!function_exists('validacion')) {
    function validacion($validador, $error)
    {
        if ($validador->fails()) {
            return abort(redirect()->back()->with($error, $validador->errors()->getMessages())->withErrors($validador)->withInput());
        }
    }
}

/**
 *  Redirecciona si no encuentra el modelo
 * 
 *  @param object $modelo
 *  @return exception
 */

if (!function_exists('existe')) {
    function existe($modelo)
    {
        if (!$modelo) {
            return abort(redirect()->back()->with('no encontrado', 'no encontrado'));
        }
    }
}

/**
 *  Devuelve si el rol del usuario coincide.
 * 
 *  @param string $rol
 *  @return bool
 */

if (!function_exists('rol')) {
    function rol($rol)
    {
        return auth()->user()->getRoleNames()[0] === $rol;
    }
}

/**
 *  Devuelve el valor deseado de un array.
 * 
 *  @param array $arreglo
 *  @param string $atributo
 *  @return string
 */

if (!function_exists('atributo')) {
    function atributo($arreglo, $atributo)
    {
        return Arr::get($arreglo, $atributo, '');
    }
}

/**
 *  Devuelve el periodo actual
 * 
 *  @return (string|null)
 */
if (!function_exists('periodo')) {
    function periodo()
    {
        $periodo = Periodo::orderBy('fin', 'desc')->first();
        $existe = !empty($periodo);

        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];

        return $existe ? $conversor[$periodo->fase] . '-' . Carbon::parse($periodo->inicio)->format('Y') : null;
    }
}

/**
 *  Devuelve un campo del modelo materia.
 * 
 *  @param object $materia
 *  @param string $dato
 *  @return int|string|object
 */

if (!function_exists('materia')) {
    function materia($materia, $dato)
    {
        switch ($dato) {
            case 'ID':
                return $materia->id;
                break;
            case 'profesorEncargado':
                return !empty($materia->info->profesor) ? $materia->info->profesor->id : null;
                break;
            case 'profesor':
                return !empty($materia->info->profesor) ? $materia->info->profesor->usuario->nombre . ' ' . $materia->info->profesor->usuario->apellido : null;
                break;
            case 'profPerfil':
                return !empty($materia->info->profesor) ? $materia->info->profesor : null;
                break;
            case 'profAvatar':
                return !empty($materia->info->profesor) ? $materia->info->profesor->usuario->avatar : null;
                break;
            case 'profID':
                return !empty($materia->info->profesor) ? $materia->info->profesor->id : null;
                break;
            case 'tieneProf':
                return !empty($materia->info->profesor);
                break;
            case 'categoria':
                return !empty($materia->info->categoria) ? $materia->info->categoria->nom_categoria : null;
                break;
        }
    }
}

/**
 *  Devuelve un numero convertido a fecha de la semana.
 * 
 *  @param int $dia
 *  @return string
 */

if (!function_exists('diaSemana')) {
    function diaSemana($dia)
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        return $dias[$dia - 1];
    }
}

/**
 *  Devuelve el valor de una relación de una materia
 * 
 *  @param object $materia
 *  @param string $relacion
 *  @return string|int
 */

if (!function_exists('materiaRelacion')) {
    function materiaRelacion($materia, $relacion)
    {
        $defecto = 'Sin asignar';

        if ($relacion === 'Acreditable') {
            return $materia->num_acreditable;
        }

        if (!empty($materia->info)) {
            if ($relacion === 'metodologia') {
                return $materia->info->metodologia ?? $defecto;
            }

            if ($relacion === 'Categoria') {
                return $materia->info->categoria->nom_categoria ?? $defecto;
            }

            if ($relacion === 'Horario') {
                $horario = $materia->info->horario;

                return !empty($materia->info->horario)
                    ? '[ ' . $horario->espacio . ' ' . $horario->edificio . ' ] ' . diaSemana($horario->dia) . ' - ' . \Carbon\Carbon::parse($horario->hora)->format('g:i A')
                    : $defecto;
            }
        }
        return $defecto;
    }
}

/**
 *  Devuelve la hora en un formato completo.
 *      ej: [C 2] Lunes - 5:40PM
 * 
 *  @param object $modelo
 *  @return string
 */

if (!function_exists('horario')) {
    function horario($modelo)
    {
        return '[ ' . $modelo->espacio . ' ' . $modelo->edificio . ' ] ' . diaSemana($modelo->dia) . ' - ' . \Carbon\Carbon::parse($modelo->hora)->format('g:i A');
    }
}

/**
 *  Devuelve un dato de un modelo.
 * 
 *  @param object $usuario
 *  @param string $modelo
 *  @param string $datoBuscar
 *  @return string|array|int|object
 */

if (!function_exists('datosUsuario')) {
    function datosUsuario($usuario, $modelo, $datoBuscar)
    {
        if ($modelo === 'Usuario') {
            switch ($datoBuscar) {
                case 'estudiante':
                    return !empty($usuario->estudiante);
                    break;
                case 'CI':
                    return $usuario->nacionalidad . '-' . number_format($usuario->cedula, 0, ',', '.');
                    break;
                case 'nombre':
                    return $usuario->nombre;
                    break;
                case 'apellido':
                    return $usuario->apellido;
                    break;
                case 'nombreCompleto':
                    return $usuario->nombre . ' ' . $usuario->apellido;
                    break;
                case 'correo':
                    return $usuario->email;
                    break;
                case 'avatar':
                    return $usuario->avatar;
                    break;
                case 'PNF':
                    return !empty($usuario->estudiante->pnf) ? $usuario->estudiante->pnf->nom_pnf : 'Sin asignar';
                    break;
                case 'PNF_id':
                    return !empty($usuario->estudiante->pnf) ? $usuario->estudiante->pnf->id : null;
                    break;
                case 'trayecto':
                    return !empty($usuario->estudiante->trayecto) ? $usuario->estudiante->trayecto->num_trayecto : 'Sin asignar';
                    break;
                case 'trayecto_id':
                    return !empty($usuario->estudiante->trayecto) ? $usuario->estudiante->trayecto->id : null;
                    break;
                default:
                    return null;
            }
        }

        if ($modelo === 'Estudiante') {
            switch ($datoBuscar) {
                case 'estudiante':
                    return $usuario ?? null;
                case 'ID':
                    return $usuario->id;
                    break;
                case 'CI':
                    return $usuario->usuario->nacionalidad . '-' . number_format($usuario->usuario->cedula, 0, ',', '.');
                    break;
                case 'nombre':
                    return $usuario->usuario->nombre;
                    break;
                case 'apellido':
                    return $usuario->usuario->apellido;
                    break;
                case 'nombreCompleto':
                    return $usuario->usuario->nombre . ' ' . $usuario->usuario->apellido;
                    break;
                case 'academico':
                    return !empty($usuario->pnf) ? false : true;
                    break;
                case 'PNF':
                    return !empty($usuario->pnf) ? $usuario->pnf->nom_pnf : 'Sin asignar';
                    break;
                case 'trayecto':
                    return !empty($usuario->trayecto) ? $usuario->trayecto->num_trayecto : 'Sin asignar';
                    break;
                case 'codigo':
                    return !empty($usuario->inscrito) ? $usuario->inscrito->codigo : null;
                    break;
                case 'profEncargado':
                    return !empty($usuario->inscrito) ? $usuario->inscrito->materia->info->profesor : null;
                    break;
                case 'materia':
                    return !empty($usuario->estudiante->inscrito) ? $usuario->estudiante->inscrito->materia_id : '';
                    break;
                case 'inscrito':
                    return $usuario->inscrito ?? null;
                    break;
            }
        }

        if ($modelo === 'Profesor') {
            switch ($datoBuscar) {
                case 'avatar':
                    return $usuario->usuario->avatar;
                    break;
                case 'nombre':
                    return $usuario->usuario->nombre;
                    break;
                case 'apellido':
                    return $usuario->usuario->apellido;
                    break;
                case 'nombreCompleto':
                    return $usuario->usuario->nombre . ' ' . $usuario->usuario->apellido;
                    break;
                case 'CI':
                    return $usuario->usuario->nacionalidad . '-' . number_format($usuario->usuario->cedula, 0, ',', '.');
                    break;
                case 'correo':
                    return $usuario->usuario->email;
                    break;
                case 'tlf':
                    return substr($usuario->telefono, 0, 4) . '-' . substr($usuario->telefono, 4);
                    break;
                case 'conocimiento':
                    return !empty($usuario->conocimiento) ? $usuario->conocimiento->nom_conocimiento : 'Sin asignar';
                    break;
                case 'activo':
                    return $usuario->activo;
                    break;
                case 'residencia':
                    return
                        'Estado: ' . $usuario->estado . ' | Ciudad: ' . $usuario->ciudad . ' | Urbanización: ' . $usuario->urb . ' | Calle: ' . $usuario->calle . ' | Casa: ' . $usuario->casa;
                    break;
            }
        }

        if ($modelo === 'EstudianteInscrito') {
            switch ($datoBuscar) {
                case 'nombre':
                    return $usuario->esEstudiante->usuario->nombre;
                    break;
                case 'apellido':
                    return $usuario->esEstudiante->usuario->apellido;
                    break;
                case 'nombreCompleto':
                    return $usuario->esEstudiante->usuario->nombre . ' ' . $usuario->esEstudiante->usuario->apellido;
                    break;
                case 'CI':
                    return $usuario->esEstudiante->usuario->nacionalidad . '-' . number_format($usuario->esEstudiante->usuario->cedula, 0, ',', '.');
                    break;
                case 'trayectoNumero':
                    return $usuario->esEstudiante->trayecto->num_trayecto;
                    break;
                case 'pnfNombre':
                    return $usuario->esEstudiante->pnf->nom_pnf;
                    break;
                case 'validado':
                    return $usuario->validado === 1 ? true : false;
                    break;
                case 'codigo':
                    return $usuario->codigo;
                    break;
                case 'profEncargado':
                    return $usuario->materia->info->profesor;
                    break;
                case 'inscrito':
                    return !empty($usuario->esEstudiante->inscrito) ? $usuario->esEstudiante->inscrito->materia->nom_materia : null;
                    break;
            }
        }
    }
}
