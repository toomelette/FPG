<?php

namespace App\Enums;

enum AccountingRefBooks:string
{
    case CashReceipt = 'CR';
    case CheckDisbursement = 'CD';
    case CashDisbursements = 'CADJ';
    case GeneralJournal = 'GJ';
}