<?php

namespace App\View\Components\tipografia;

use Illuminate\View\Component;

class periodo extends Component
{
    public $fecha;
    public $fase;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fase, $fecha)
    {
        $this->fase = $fase;
        $this->fecha = $fecha;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tipografia.periodo');
    }
}
