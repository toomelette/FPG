<?php

namespace App\Http\Controllers\Api\DTR;

use App\Http\Controllers\Controller;
use App\Models\DailyTimeRecord;
use App\Models\DTR;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QcDtrController extends Controller
{
    public function store(Request $request)
    {
        $dailyTimeRecords = $request['daily_time_records'];
        $dtrs = $request['dtrs'];
        $batchId = 'QC-'.Str::random(8);

        $dailyTimeRecordsArray = [];
        if(!empty($dailyTimeRecords) ){
            foreach ($dailyTimeRecords as $dailyTimeRecord){
                $dailyTimeRecord['system_remarks'] = $batchId;
                $dailyTimeRecordsArray[] = $dailyTimeRecord;
            }
        }

        $dtrsArray = [];
        if(!empty($dtrs) ){
            foreach ($dtrs as $dtr){
                $dtr['system_remarks'] = $batchId;
                $dtrsArray[] = $dtr;
            }
        }

        DailyTimeRecord::query()->insert($dailyTimeRecordsArray);
        DTR::query()->insert($dtrsArray);
        return [
            'message' => 'DTRs successfully uploaded.',
        ];
    }
}