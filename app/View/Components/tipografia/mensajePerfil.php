<?php

namespace App\View\Components\tipografia;

use Illuminate\View\Component;

class mensajePerfil extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tipografia.mensaje-perfil');
    }
}
