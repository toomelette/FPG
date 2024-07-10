<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BudgetProposalMonitoringExporter implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $paps;
    protected $request;
    public function __construct($paps, $request)
    {
        $this->paps = $paps;
        $this->request = $request;
    }

    public function view(): View
    {
        return view('printables.ors.tables.table_budget_proposal_monitoring')->with([
            'paps' => $this->paps,
            'request' => $this->request,
        ]);
    }
}
