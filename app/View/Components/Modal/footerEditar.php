<?php

namespace App\View\Components\modal;

use Illuminate\View\Component;

class footerEditar extends Component
{
    public $ruta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ruta)
    {
        $this->ruta = $ruta;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.footer-editar');
    }
}
