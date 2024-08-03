<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    public function __construct(

        public $cols,
        public $name,
        public $label = null,
        public $class = null,
        public $value = null,
        public $containerClass = null,
        public $placeholder = null,
        public $type = 'text',
        public $autocomplete = 'off',
        public $id = null,
        public $for = null,
        public $required = null,
        public $tabindex = null,
        public $inputOnly = false,
        public $step = null,
        public $disabled = false,
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
        return view('components.forms.input');
    }
}
