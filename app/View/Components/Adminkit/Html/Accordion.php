<?php

namespace App\View\Components\Adminkit\Html;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Accordion extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $id,
        public $class = null,
        public $state = 0,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.adminkit.html.accordion');
    }
}
