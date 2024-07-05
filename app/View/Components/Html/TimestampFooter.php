<?php

namespace App\View\Components\Html;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TimestampFooter extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $sourceData,
        public $cols
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.html.timestamp-footer');
    }
}
