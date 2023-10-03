<?php

namespace App\Swep\Traits\Budget;

use App\Models\Budget\ChartOfAccounts;
use App\Models\Budget\ORSAccountEntries;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;

trait CoPurchasesPerAccountEntries
{
    public function coPurchasesPerAccountEntries(Request $request){
        $accountEntries = ORSAccountEntries::query()
            ->with(['responsibilityCenter.description'])
            ->whereHas('chartOfAccount',function ($q){
                return $q->coAccountsOnly();
            })
            ->orsEntriesOnly()
            ->get()
            ->sortBy('chartOfAccount.account_title');

        $untouchedCoa = ChartOfAccounts::query()
            ->orderBy('account_title','asc')
            ->coAccountsOnly()
            ->get();
        $untouchedCoaNull = $untouchedCoa->mapWithKeys(function ($data){
                return [
                    $data->account_code => null,
                ];
            })
            ->toArray();
        $untouchedCoa = $untouchedCoa
            ->mapWithKeys(function ($data){
                return [
                    $data->account_code => $data->account_title,
                ];
            })
            ->toArray();


        if($request->has('hide_empty_rows') && $request->hide_empty_rows == 1){
            $accountEntriesArr = [];
        }else{
            $accountEntriesArr = $untouchedCoaNull;
        }


        $depts = [];

        foreach ($accountEntries as $accountEntry){
            $rc = $accountEntry->responsibilityCenter->description->rc ?? '';
            $accountCode = $accountEntry->account_code;
            if(isset($accountEntriesArr[$accountCode][$rc])){
                $accountEntriesArr[$accountCode][$rc] = $accountEntriesArr[$accountCode][$rc] + $accountEntry->debit;
            }else{
                $accountEntriesArr[$accountCode][$rc] = $accountEntry->debit;
            }
            $depts[$accountEntry->responsibilityCenter->description->rc] = null;
        }

        return view('printables.ors.reports.co_purchases_per_account_entries')->with([
            'accounts' => $accountEntriesArr,
            'depts' => $depts,
            'untouchedDepartmentList' => Arrays::departmentListAbbv(),
            'untouchedCoa' => $untouchedCoa,

        ]);
    }
}