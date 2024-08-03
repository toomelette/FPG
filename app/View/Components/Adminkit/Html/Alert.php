<?php

namespace App\View\Components\Adminkit\Html;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $type,
        public $dismissible = true,
        public $withIcon = true,
        public $bodyClass = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.adminkit.html.alert');
    }
}
