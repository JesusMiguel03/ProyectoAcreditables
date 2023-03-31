<?php

namespace App\Listeners;

use App\Models\Informacion\Bitacora;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ControlSesion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function iniciarSesion(Login $event)
    {
        $usuario = $event->user;
        $datosUsuario = "{$usuario->nombre} {$usuario->apellido}";

        Bitacora::create([
            'usuario' => $datosUsuario,
            'accion' => 'Inició sesión',
            'estado' => 'success',
            'periodo_id' => null
        ]);
    }

    public function cerrarSession(Logout $event)
    {
        $usuario = $event->user;
        // dd($usuario);
        $datosUsuario = "{$usuario->nombre} {$usuario->apellido}";

        Bitacora::create([
            'usuario' => $datosUsuario,
            'accion' => 'Cerró sesión',
            'estado' => 'success',
            'periodo_id' => null
        ]);
    }
}
