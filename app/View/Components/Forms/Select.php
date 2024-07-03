<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $label,
        public $cols,
        public $name,
        public $options = [],
        public $class = null,
        public $value = null,
        public $containerClass = null,
        public $id = null,
        public $for = null,
        public $required = null,
        public $tabindex = null,
    )
    {
        if(is_object($this->value)){
            $this->value = $this->value->$name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
