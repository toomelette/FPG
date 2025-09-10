<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeeReportMainExporter implements WithMultipleSheets
{

    protected $dataCollection;
    public function __construct(array $dataCollection)
    {
        $this->dataCollection = $dataCollection;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->dataCollection['employees'] as $sheetName => $category) {
            // Create a new sheet export instance for each item in your data
            $sheets[] = new EmployeeReportExporter($category,$this->dataCollection,$sheetName);
        }

        return $sheets;
    }
}
