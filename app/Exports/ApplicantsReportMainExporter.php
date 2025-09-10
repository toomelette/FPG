<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ApplicantsReportMainExporter implements WithMultipleSheets
{
    protected $dataCollection;
    public function __construct(array $dataCollection)
    {
        $this->dataCollection = $dataCollection;
    }

    public function sheets(): array
    {

        $sheets = [];

        foreach ($this->dataCollection['grouped_applicants'] as $sheetName => $groupedApplicants) {
            // Create a new sheet export instance for each item in your data
            $sheets[] = new ApplicantsReportExporter($groupedApplicants,$this->dataCollection,$sheetName);
        }

        return $sheets;
    }
}
