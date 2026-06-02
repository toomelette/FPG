<?php

namespace App\Services;

use App\Models\FG\InventoryTransfers;
use App\Models\FG\ProjectPreparations;
use App\Models\FG\ReceivingReports;
use App\Models\FG\SalesInvoice;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function getUnionOfStockMovements($stock)
    {
        $warehouse = '01-BACOLOD';
        $receivingReport = ReceivingReports::query()
            ->select([
                'date',
                'control_no',
                'remarks',
                DB::raw(' receiving_report_details.*'),
                DB::raw("'RECEIVING REPORT' AS book"),
                DB::raw('1 as  direction')
            ])
            ->join('receiving_report_details','receiving_reports.uuid','=','receiving_report_details.receiving_report_uuid')
            ->where('warehouse','=',$warehouse)
//            ->where('stock_uuid','=',$stock->uuid)
        ;

        $projectPreparations = ProjectPreparations::query()
            ->select([
                'date',
                'control_no',
                'remarks',
                DB::raw(' project_preparation_details.*'),
                DB::raw("'PROJECT PREPARATION' AS book"),
                DB::raw('-1 as  direction')
            ])
            ->join('project_preparation_details','project_preparations.uuid','=','project_preparation_details.project_preparation_uuid')
            ->where('warehouse','=',$warehouse)
//            ->where('stock_uuid','=',$stock->uuid)
        ;

        $sales = SalesInvoice::query()
            ->select([
                'date',
                DB::raw('invoice_no as control_no'),
                'remarks',
                DB::raw('sales_invoice_details.*'),
                DB::raw("
                    CASE
                        WHEN sales_invoices.ref_book = 'CASH' then 'CASH SALES INVOICE'
                        WHEN sales_invoices.ref_book = 'CHARGE' then 'CHARGE SALES INVOICE'
                        ELSE sales_invoices.ref_book
                    END 
                    as book
                "),
                DB::raw("-1 as direction")
            ])
            ->join('sales_invoice_details','sales_invoices.uuid','=','sales_invoice_details.sales_invoice_uuid')
            ->where('warehouse','=',$warehouse)
//            ->where('stock_uuid','=',$stock->uuid)
        ;

        $inventoryOut = InventoryTransfers::query()
            ->select([
                'date',
                'control_no',
                'remarks',
                DB::raw(' inventory_transfer_details.*'),
                DB::raw('inventory_transfers.transfer_from as warehouse'),
                DB::raw("'INVENTORY TRANSFER' AS book"),
                DB::raw('-1 as  direction')
            ])
            ->join('inventory_transfer_details','inventory_transfers.uuid','=','inventory_transfer_details.inventory_transfer_uuid')
            ->where('transfer_from','=',$warehouse)
//            ->where('stock_uuid','=',$stock->uuid)
        ;

        $inventoryIn = InventoryTransfers::query()
            ->select([
                'date',
                'control_no',
                'remarks',
                DB::raw(' inventory_transfer_details.*'),
                DB::raw('inventory_transfers.transfer_to as warehouse'),
                DB::raw("'INVENTORY TRANSFER' AS book"),
                DB::raw('1 as  direction')
            ])
            ->join('inventory_transfer_details','inventory_transfers.uuid','=','inventory_transfer_details.inventory_transfer_uuid')
            ->where('transfer_to','=',$warehouse)
//            ->where('stock_uuid','=',$stock->uuid)
        ;


        $union = $receivingReport
            ->unionAll($projectPreparations)
            ->unionAll($sales)
            ->unionAll($inventoryOut)
            ->unionAll($inventoryIn)
        ;
        return $union;
    }
}