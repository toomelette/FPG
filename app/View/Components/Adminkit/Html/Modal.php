<?php

namespace App\View\Components\Adminkit\Html;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */

    public function __construct(
        public $id,
        public $size = 'md',
        public $static = false,
        public $padding = null,
        public $decolor = false,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.adminkit.html.modal');
    }
}
