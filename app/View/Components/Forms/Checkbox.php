<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Checkbox extends Component
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
        public $type,
        public $options = [],
        public $eachClass = null,
        public $class = null,
        public $value = null,
        public $containerClass = null,
        public $id = null,
        public $for = null,
        public $required = null,
        public $tabindex = null,
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.checkbox');
    }
}
