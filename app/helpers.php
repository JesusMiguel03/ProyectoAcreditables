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
    function periodo($actual = '')
    {
        $periodo = Periodo::orderBy('fin', 'desc')->orderBy('fase', 'desc')->orderBy('inicio', 'desc')->first();
        $existe = !empty($periodo);

        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];

        if ($actual === 'modelo') return $periodo;
        return $existe ? $conversor[$periodo->fase] . '-' . Carbon::parse($periodo->inicio)->format('Y') : null;
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
        return $dias[$dia];
    }
}

if (!function_exists('metodologia')) {
    function metodologia($numero)
    {
        $metodologias = [0 => 'Teórico', 1 => 'Práctico', 2 => 'Teórico-práctico'];
        return $metodologias[$numero];
    }
}