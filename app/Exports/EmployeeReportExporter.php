<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmployeeReportExporter implements FromView, WithTitle
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(
        protected $category,
        protected $mainData,
        protected $sheetName,
    )
    {

    }

    public function view(): View
    {

        return view('printables.employee.tables.table-report')->with([
            'category' => $this->category,
            'selected_columns' => $this->mainData['selected_columns'],
            'all_columns' => $this->mainData['all_columns'],
            'request' => $this->mainData['request'],
        ]);
    }

    public function title(): string
    {
        return $this->sheetName == '' ? 'Sheet' : $this->sheetName;
    }
}
