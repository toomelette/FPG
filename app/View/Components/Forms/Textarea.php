<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $label,
        public $name,
        public $cols,
        public $for = null,
        public $id = null,
        public $rows = 3,
        public $value = null,
        public $class = null,
        public $containerClass = null,
    )
    {
        if(is_object($this->value)){
            $this->value = $this->value->$name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.textarea');
    }
}
