<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Store extends Component
{
    public $ruta, $nombre, $texto, $numero, $telefono, $descripcion;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ruta, $nombre, $texto, $numero, $telefono, $descripcion)
    {
        $this->ruta = $ruta;
        $this->nombre = $nombre;
        $this->texto = $texto;
        $this->numero = $numero;
        $this->telefono = $telefono;
        $this->descripcion = $descripcion;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.store');
    }
}
