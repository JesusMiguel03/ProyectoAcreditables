<?php

use App\Models\Academico\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 *  Valida si puede estar en la vista
 * 
 *  @param permiso (tipo: array|string): Permiso para visualizar / interactuar. 
 * 
 *  @return bool
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
        }
    }
}

/**
 *  Valida los campos
 *
 *  @param validador (tipo: object): Array con todos los campos.
 * 
 *  @return redirect
 */

if (!function_exists('validacion')) {
    function validacion($validador)
    {
        if ($validador->fails()) {
            return abort(redirect()->back()->with('error', $validador->errors()->getMessages())->withErrors($validador)->withInput());
        }
    }
}

/**
 *  Evita la duplicidad
 * 
 *  @param modelo (tipo: object): El modelo a buscar.
 * 
 *  @return redirect
 */

if (!function_exists('duplicado')) {
    function duplicado($modelo)
    {
        if ($modelo->first()) {
            return abort(redirect()->back()->withInput());
        }
    }
}

/**
 *  Redirecciona si no encuentra el modelo
 *  @param modelo.
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
 *  @param rol
 *  @return bool
 */

if (!function_exists('rol')) {
    function rol($rol)
    {
        return auth()->user()->getRoleNames()[0] === $rol;
    }
}

/**
 *  Devuelve el último periodo registrado.
 * 
 *  @return object
 */

if (!function_exists('periodoActual')) {
    function periodoActual()
    {
        return Periodo::orderBy('fin', 'desc')->first();
    }
}

/**
 *  Devuelve una fecha en el formato deseado.
 * 
 *  @return date
 */

if (!function_exists('parsearFecha')) {
    function parsearFecha($fecha, $formato)
    {
        return Carbon::parse($fecha)->format($formato);
    }
}

/**
 *  Devuelve el valor deseado de un array.
 * 
 *  @return string
 */

if (!function_exists('atributo')) {
    function atributo($array, $atributo)
    {
        return Arr::get($array, $atributo, '');
    }
}

/**
 *  Devuelve un número convertido a número romano
 * 
 *  @param nro int
 *  @return string
 */

if (!function_exists('nroRomano')) {
    function nroRomano($nroConvertir)
    {
        $nroConvertir = intval($nroConvertir);
        $respuesta = '';
        $romanos = [
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        foreach ($romanos as $romano => $num) {
            // Busca un numero que coincida
            $coincide = intval($nroConvertir / $num);

            // Añade la letra a la cadena
            $respuesta .= str_repeat($romano, $coincide);

            // Resta el numero encontrado
            $nroConvertir = $nroConvertir % $num;
        }
        return $respuesta;
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
        $existe = !empty(periodoActual());
        $periodo = periodoActual();
        return $existe ? nroRomano($periodo->fase) . '-' . parsearFecha($periodo->inicio, 'Y') : null;
    }
}

/**
 *  Devuelve el formato de cédula V-xx-xxx-xxx
 * 
 *  @return string
 */
if (!function_exists('parsearCedula')) {
    function parsearCedula($usuario)
    {
        return 'V-' . number_format($usuario, 0, ',', '.');
    }
}

/**
 *  Devuelve el formato de telefono 0000-0000000
 * 
 *  @return string
 */
if (!function_exists('parsearTelefono')) {
    function parsearTelefono($usuario)
    {
        return substr($usuario->telefono, 0, 4) . '-' . substr($usuario->telefono, 4);
    }
}


/**
 *  Devuelve un dato del estudiante perteneciente a la tabla estudiantes
 * 
 *  @param dato $string
 *  @return (int|string|bool)
 */
if (!function_exists('estudiante')) {
    function estudiante($estudiante, $dato)
    {
        switch ($dato) {
            case 'id':
                return $estudiante->id;
            case 'nombreCompleto':
                return usuario($estudiante->usuario, 'nombreCompleto');
                break;
            case 'pnf':
                return $estudiante->pnf_id;
                break;
            case 'pnfNombre':
                return $estudiante->pnf->nom_pnf;
                break;
            case 'trayecto':
                return $estudiante->trayecto_id;
                break;
            case 'trayectoNumero':
                return $estudiante->trayecto->num_trayecto;
                break;
            case 'academico':
                return !empty($estudiante)
                    ? true
                    : false;
                break;
            case 'inscrito':
                return !empty($estudiante->inscrito)
                    ? $estudiante->inscrito
                    : false;
                break;
            case 'codigo':
                return !empty($estudiante->inscrito)
                    ? $estudiante->inscrito->codigo
                    : false;
                break;
            case 'materia':
                return estudiante($estudiante, 'inscrito')
                    ? $estudiante->inscrito->materia_id
                    : false;
                break;
            case 'materiaNombre':
                return estudiante($estudiante, 'inscrito')
                    ? $estudiante->inscrito->materia->nom_materia
                    : false;
                break;
            default:
                return $estudiante;
        }
    }
}

/**
 *  Devuelve si el trayecto del estudiante y el número de la acreditable coinciden.
 *  @return bool
 */
if (!function_exists('materiaEstudiante')) {
    function materiaEstudiante($estudiante, $materia)
    {
        return $materia->num_acreditable === estudiante($estudiante, 'trayectoNumero');
    }
}

/**
 *  Devuelve los atributos de profesor del usuario actual, si no es profesor devuelve null.
 *  @return (object|null)
 */
if (!function_exists('profesor')) {
    function profesor($parametro = '')
    {
        $profesor = Auth::user()->profesor;
        if (empty($profesor)) return null;
        return !empty($parametro) ? $profesor->$parametro : $profesor;
    }
}

/**
 *  Devuelve un campo del modelo materia.
 *  @return string
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
        }
    }
}

/**
 *  Devuelve un numero convertido a fecha de la semana.
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
 *  Devuelve el horario en formato [Espacio Edificio] Dia - Hora
 *  @return string
 */
if (!function_exists('formatoHorario')) {
    function formatoHorario($horario)
    {
        return
            '[ ' . $horario->espacio . ' ' . $horario->edificio_numero . ' ] '
            . diaSemana($horario->dia) . ' - '
            . \Carbon\Carbon::parse($horario->hora)->format('g:i A');
    }
}

/**
 *  @return string Devuelve una relación de una materia
 */
if (!function_exists('materiaRelacion')) {
    function materiaRelacion($materia, $relacion)
    {
        $defecto = 'Sin asignar';

        if ($relacion === 'Acreditable') {
            return $materia->num_acreditable;
        }

        if (!empty($materia->info)) {
            if ($relacion === 'Tipo') {
                return $materia->info->metodologia_aprendizaje ?? $defecto;
            }

            if ($relacion === 'Categoria') {
                return $materia->info->categoria ?? $defecto;
            }

            if ($relacion === 'Horario') {
                return !empty($materia->info->horario)
                    ? formatoHorario($materia->info->horario)
                    : $defecto;
            }
        }
        return $defecto;
    }
}

/**
 *  * Devuelve un dato del usuario.
 *  @return string
 */
if (!function_exists('usuario')) {
    function usuario($usuario, $dato)
    {
        switch ($dato) {
            case 'id':
                return $usuario->id;
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
            case 'cedula':
                return $usuario->cedula;
                break;
            case 'correo':
                return $usuario->email;
                break;
            case 'avatar':
                return $usuario->avatar;
                break;
        }
    }
}

/**
 *  * Devuelve un dato del estudiante solicitado proveniente de la relacion estudiante-materia.
 *  @return string
 */
if (!function_exists('estudiante_materia')) {
    function estudiante_materia($estudiante, $dato)
    {
        switch ($dato) {
            case 'cedula':
                return $estudiante->esEstudiante->usuario->cedula;
                break;
            case 'nombre':
                return $estudiante->esEstudiante->usuario->nombre;
                break;
            case 'apellido':
                return $estudiante->esEstudiante->usuario->apellido;
                break;
            case 'nombreCompleto':
                return estudiante_materia($estudiante, 'nombre') . ' ' . estudiante_materia($estudiante, 'apellido');
                break;
            case 'validado':
                return $estudiante->validacion_estudiante;
                break;
            case 'estaValidado':
                return $estudiante->validacion_estudiante === 0 ? false : true;
                break;
            case 'codigo':
                return $estudiante->codigo;
                break;
            case 'inscrito':
                return $estudiante->esEstudiante->inscrito->materia->nom_materia;
                break;
            case 'profID':
                return $estudiante->esEstudiante->inscrito->materia->info->profesor->usuario->id;
                break;
            default:
                return $estudiante;
        }
    }
}
