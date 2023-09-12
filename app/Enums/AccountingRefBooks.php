<?php

namespace App\Enums;

enum AccountingRefBooks:string
{
    case CashReceipt = 'CR';
    case CashDisbursement = 'CD';
    case GeneralJournal = 'GJ';
}