<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MonthlyPayrollExporter implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(
        protected $data,
    )
    {
    }

    public function view(): View
    {
        return view('printables.hru.payroll_preparation.MONTHLY.excel.tbl-monthly')->with($this->data);
    }
}
