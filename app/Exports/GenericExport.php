<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class GenericExport implements FromView, WithTitle
{
    protected $view;
    protected $data;
    protected $title;

    public function __construct($view, $data,$title)
    {
        $this->view = $view;
        $this->data = $data;
        $this->title = $title;
    }

    public function view(): View
    {
        return view($this->view, $this->data);
    }
    public function title(): string
    {
        return $this->title;
    }
}
