<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ApplicantsReportExporter implements FromView,WithTitle
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(
        protected $groupedApplicants,
        protected $mainData,
        protected $sheetName,
    )
    {

    }

    public function view(): View
    {
        return view('printables.applicant.tables.table-report-3')->with([
            'applicants' => $this->groupedApplicants,
            'columns' => $this->mainData['columns'],
            'requested_columns' => $this->mainData['requested_columns'],
            'request' => $this->mainData['request'],
            'filters' => $this->mainData['filters'],
        ]);
    }

    public function title(): string
    {
        return $this->sheetName == '' ? 'Sheet' : $this->sheetName;
    }
}
