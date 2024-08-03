<?php

namespace App\View\Components\Adminkit\Html;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalTemplate extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $id,
        public $size = 'md',
        public $formId = null,
        public $formTarget = null,
        public $formMethod = null,
        public $formAction = null,
        public $formData = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.adminkit.html.modal-template');
    }
}
